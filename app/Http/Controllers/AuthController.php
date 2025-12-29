<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        // Check if input is member number (format: KKKT-AGAPE-YYYY-NNNN)
        $login = $request->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';

        // If it looks like a member number, convert to email format
        if (preg_match('/^KKKT-AGAPE-\d{4}-\d{4}$/', $login)) {
            $credentials['email'] = $login . '@kkkt-agape.org';
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

        return redirect()->route('login')->with('success', 'Umetoka nje salama');
    }

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Send password reset link (placeholder)
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Tafadhali ingiza barua pepe',
            'email.email' => 'Barua pepe si sahihi',
            'email.exists' => 'Barua pepe hii haijasajiliwa',
        ]);

        // TODO: Implement password reset email sending
        return back()->with('success', 'Kiungo cha kubadilisha nywila kimetumwa kwenye barua pepe yako');
    }

    // Show reset password form
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Handle password reset (placeholder)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // TODO: Implement password reset logic
        return redirect()->route('login')->with('success', 'Nywila imebadilishwa! Tafadhali ingia');
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:members,phone',
            'email' => 'nullable|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Mme,Mke',
            'marital_status' => 'required|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'password' => 'required|min:8|confirmed',
        ], [
            'first_name.required' => 'Jina la kwanza linahitajika',
            'last_name.required' => 'Jina la mwisho linahitajika',
            'phone.required' => 'Namba ya simu inahitajika',
            'phone.unique' => 'Namba hii ya simu imeshasajiliwa',
            'email.unique' => 'Barua pepe hii imeshasajiliwa',
            'date_of_birth.required' => 'Tarehe ya kuzaliwa inahitajika',
            'gender.required' => 'Jinsia inahitajika',
            'marital_status.required' => 'Hali ya ndoa inahitajika',
            'password.required' => 'Nenosiri linahitajika',
            'password.min' => 'Nenosiri lazima liwe na herufi 8 au zaidi',
            'password.confirmed' => 'Nenosiri hayalingani',
            'jumuiya_id.required' => 'Tafadhali chagua jumuiya',
            'jumuiya_id.exists' => 'Jumuiya uliyochagua haipo',
        ]);

        // Generate member number
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

        // Generate email for login if not provided
        $loginEmail = $validated['email'] ?? $memberNumber . '@kkkt-agape.org';

        // Create user account (inactive until approved)
        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']),
            'email' => $loginEmail,
            'password' => Hash::make($validated['password']),
            'role_id' => $memberRole ? $memberRole->id : null,
            'is_active' => false, // Inactive until admin approves
        ]);

        // Create member record
        $member = Member::create([
            'member_number' => $memberNumber,
            'envelope_number' => $envelopeNumber,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'marital_status' => $validated['marital_status'],
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'region' => $validated['region'] ?? null,
            'jumuiya_id' => $validated['jumuiya_id'],
            'membership_date' => now(),
            'is_active' => false, // Inactive until admin approves
            'user_id' => $user->id,
        ]);

        return redirect()->route('login')->with('success', 'Usajili umefanikiwa! Tafadhali subiri uthibitisho kutoka kwa msimamizi wa kanisa kabla ya kuingia.');
    }
}
