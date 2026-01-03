<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Role;
use App\Models\Jumuiya;

class AuthController extends Controller
{
    // Show login form
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Handle login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ], [
            'email.required' => 'Tafadhali ingiza namba ya kadi au barua pepe',
            'password.required' => 'Tafadhali ingiza nywila',
        ]);

        $remember = $request->has('remember');

        // Get login input
        $login = trim($request->input('email'));

        // Determine login method and get correct email for authentication
        if (preg_match('/^KKKT-AGAPE-\d{4}-\d{4}$/i', $login)) {
            // Input is member number - use it directly as email (new format)
            // Also check for legacy users with @kkkt-agape.org format
            $memberNumber = strtoupper($login);
            $user = User::where('email', $memberNumber)->first();

            if (!$user) {
                // Check legacy format
                $user = User::where('email', $memberNumber . '@kkkt-agape.org')->first();
            }

            if (!$user) {
                // Find via member relationship
                $member = Member::where('member_number', $memberNumber)->first();
                if ($member && $member->user) {
                    $user = $member->user;
                }
            }

            if ($user) {
                $credentials['email'] = $user->email;
            } else {
                $credentials['email'] = $memberNumber; // Will fail but with correct error
            }
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Input is email - check if it's in User table or Member table
            $user = User::where('email', $login)->first();

            if (!$user) {
                // Check if email is in Member table
                $member = Member::where('email', $login)->first();
                if ($member && $member->user) {
                    $credentials['email'] = $member->user->email;
                }
            }
            // If found directly in User table, credentials['email'] stays as is
        }

        if (Auth::attempt($credentials, $remember)) {
            // Check if user is active
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akaunti yako bado haijaidhinishwa. Tafadhali wasiliana na msimamizi wa kanisa.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Update last login
            Auth::user()->update(['last_login_at' => now()]);

            return redirect()->intended(route('dashboard'))->with('success', 'Umefanikiwa kuingia!');
        }

        return back()->withErrors([
            'email' => 'Namba ya kadi/barua pepe au nywila si sahihi.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear browser cache to prevent back button access after logout
        return redirect()->route('login')
            ->with('success', 'Umetoka nje salama')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Send password reset link
    public function sendResetLink(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Tafadhali ingiza barua pepe',
            'email.email' => 'Barua pepe si sahihi',
            'email.exists' => 'Barua pepe hii haijasajiliwa kwenye mfumo',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first('email'),
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->email;

        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Generate new token
        $token = Str::random(64);

        // Store the token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // For now, we'll show the token in the success message (since email isn't configured)
        // In production, you would send an email with the reset link
        $resetUrl = route('password.reset', $token) . '?email=' . urlencode($email);

        $message = 'Kiungo cha kubadilisha nenosiri kimetayarishwa. Kwa sababu mfumo wa barua pepe haujaundwa, tafadhali tumia kiungo hiki: ' . $resetUrl;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kiungo cha kubadilisha nenosiri kimetumwa. Angalia barua pepe yako.',
                'reset_url' => $resetUrl // Remove this in production
            ]);
        }

        return back()->with('success', $message);
    }

    // Show reset password form
    public function showResetForm($token)
    {
        $email = request()->query('email');
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Barua pepe inahitajika',
            'email.email' => 'Barua pepe si sahihi',
            'email.exists' => 'Barua pepe hii haijasajiliwa',
            'password.required' => 'Nenosiri jipya linahitajika',
            'password.min' => 'Nenosiri lazima liwe na herufi 6 au zaidi',
            'password.confirmed' => 'Nenosiri hazilingani',
        ]);

        // Find the password reset record
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Kiungo cha kubadilisha nenosiri si sahihi au kimepitwa na wakati.']);
        }

        // Check if token is valid
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Kiungo cha kubadilisha nenosiri si sahihi.']);
        }

        // Check if token has expired (1 hour)
        if (Carbon::parse($resetRecord->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Kiungo cha kubadilisha nenosiri kimepitwa na wakati. Tafadhali omba kiungo kipya.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Nenosiri limebadilishwa! Tafadhali ingia na nenosiri lako jipya.');
    }

    // Show registration form
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $jumuiyas = Jumuiya::with('leader')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('auth.register', compact('jumuiyas'));
    }

    // Handle member self-registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Mme,Mke',
            'id_number' => 'nullable|string|size:20|regex:/^[0-9]+$/',

            // Contact Information
            'phone' => 'required|string|max:20|unique:members,phone',
            'email' => 'nullable|email|max:255|unique:users,email',
            'address' => 'nullable|string|max:500',
            'house_number' => 'nullable|string|max:50',
            'block_number' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',

            // Christian Information
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'baptism_date' => 'nullable|date',
            'confirmation_date' => 'nullable|date',
            'marital_status' => 'required|string|max:50',
            'special_group' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'church_elder' => 'nullable|string|max:255',

            // Family Information
            'spouse_name' => 'nullable|string|max:255',
            'spouse_phone' => 'nullable|string|max:20',
            'neighbor_name' => 'nullable|string|max:255',
            'neighbor_phone' => 'nullable|string|max:20',
        ], [
            'first_name.required' => 'Jina la kwanza linahitajika',
            'last_name.required' => 'Jina la mwisho linahitajika',
            'phone.required' => 'Namba ya simu inahitajika',
            'phone.unique' => 'Namba hii ya simu imeshasajiliwa',
            'email.unique' => 'Barua pepe hii imeshasajiliwa',
            'date_of_birth.required' => 'Tarehe ya kuzaliwa inahitajika',
            'date_of_birth.before' => 'Tarehe ya kuzaliwa lazima iwe kabla ya leo',
            'gender.required' => 'Jinsia inahitajika',
            'marital_status.required' => 'Hali ya ndoa inahitajika',
            'jumuiya_id.required' => 'Tafadhali chagua jumuiya',
            'jumuiya_id.exists' => 'Jumuiya uliyochagua haipo',
            'id_number.size' => 'Namba ya NIDA lazima iwe na tarakimu 20 haswa',
            'id_number.regex' => 'Namba ya NIDA lazima iwe na tarakimu tu (0-9)',
        ]);

        // Capitalize names properly (Title Case)
        $firstName = ucwords(strtolower(trim($validated['first_name'])));
        $middleName = $validated['middle_name'] ? ucwords(strtolower(trim($validated['middle_name']))) : null;
        $lastName = ucwords(strtolower(trim($validated['last_name'])));

        // Generate member number automatically
        $year = date('Y');
        $lastMember = Member::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastMember && $lastMember->member_number) {
            $sequence = intval(substr($lastMember->member_number, -4)) + 1;
        } else {
            $sequence = 1;
        }

        $memberNumber = 'KKKT-AGAPE-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Generate envelope number
        $envelopeNumber = Member::generateEnvelopeNumber();

        // Get or create member role
        $memberRole = Role::where('name', 'Mwanachama')->first();

        // Use member number as login identifier (stored in email field)
        // Real email is stored only in member table
        $loginEmail = $memberNumber;

        // Auto-generate password from last name (lowercase)
        $autoPassword = strtolower(trim($lastName));

        // Build full name with proper capitalization
        $fullName = $firstName . ($middleName ? ' ' . $middleName : '') . ' ' . $lastName;

        // Create user account (inactive until approved)
        $user = User::create([
            'name' => $fullName,
            'email' => $loginEmail, // Member number as login identifier
            'password' => Hash::make($autoPassword),
            'password_changed' => false, // Default password - user must change it
            'role_id' => $memberRole ? $memberRole->id : null,
            'is_active' => false, // Inactive until admin approves
        ]);

        // Create member record with all fields (using capitalized names)
        $member = Member::create([
            'member_number' => $memberNumber,
            'envelope_number' => $envelopeNumber,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'id_number' => $validated['id_number'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'house_number' => $validated['house_number'] ?? null,
            'block_number' => $validated['block_number'] ?? null,
            'city' => $validated['city'] ?? null,
            'region' => $validated['region'] ?? null,
            'jumuiya_id' => $validated['jumuiya_id'],
            'baptism_date' => $validated['baptism_date'] ?? null,
            'confirmation_date' => $validated['confirmation_date'] ?? null,
            'marital_status' => $validated['marital_status'],
            'special_group' => $validated['special_group'] ?? null,
            'occupation' => $validated['occupation'] ?? null,
            'church_elder' => $validated['church_elder'] ?? null,
            'spouse_name' => $validated['spouse_name'] ?? null,
            'spouse_phone' => $validated['spouse_phone'] ?? null,
            'neighbor_name' => $validated['neighbor_name'] ?? null,
            'neighbor_phone' => $validated['neighbor_phone'] ?? null,
            'membership_date' => now(),
            'is_active' => false, // Inactive until admin approves
            'user_id' => $user->id,
        ]);

        $loginInfo = 'Unaweza kuingia kwa kutumia namba yako ya kadi: ' . $memberNumber;
        if (!empty($validated['email'])) {
            $loginInfo .= ' au barua pepe yako: ' . $validated['email'];
        }

        return redirect()->route('login')->with('success',
            'Usajili umefanikiwa! Namba yako ya muumini ni: ' . $memberNumber . '. ' .
            'Nenosiri lako ni: ' . $autoPassword . ' (jina "' . $lastName . '" kwa herufi ndogo). ' .
            $loginInfo . '. ' .
            'MUHIMU: Akaunti yako bado haijaidhinishwa. Tafadhali subiri msimamizi wa kanisa aidhinishe akaunti yako kabla ya kuweza kuingia kwenye mfumo.'
        );
    }
}
