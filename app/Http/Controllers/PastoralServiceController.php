<?php

namespace App\Http\Controllers;

use App\Models\PastoralService;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PastoralServiceController extends Controller
{
    /**
     * Display a listing of pastoral services
     * Members see only their own services, Admin/Pastor see all
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = PastoralService::with(['member', 'approver']);

        // If user is a regular member, show only their services
        if ($user->isMwanachama() && $user->member) {
            $query->where('member_id', $user->member->id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by service type
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('preferred_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('preferred_date', '<=', $request->end_date);
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $stats = [
            'total' => PastoralService::count(),
            'pending' => PastoralService::pending()->count(),
            'approved' => PastoralService::approved()->count(),
            'rejected' => PastoralService::rejected()->count(),
            'completed' => PastoralService::completed()->count(),
        ];

        // If member, get only their stats
        if ($user->isMwanachama() && $user->member) {
            $stats = [
                'total' => PastoralService::where('member_id', $user->member->id)->count(),
                'pending' => PastoralService::where('member_id', $user->member->id)->pending()->count(),
                'approved' => PastoralService::where('member_id', $user->member->id)->approved()->count(),
                'rejected' => PastoralService::where('member_id', $user->member->id)->rejected()->count(),
                'completed' => PastoralService::where('member_id', $user->member->id)->completed()->count(),
            ];
        }

        $serviceTypes = [
            'Ubatizo',
            'Uthibitisho',
            'Ndoa',
            'Wakfu',
            'Mazishi',
            'Ushauri wa Kichungaji',
            'Nyingine'
        ];

        return view('panel.pastoral-services.index', compact('services', 'stats', 'serviceTypes'));
    }

    /**
     * Show the form for creating a new service request
     */
    public function create()
    {
        $user = Auth::user();

        // Get user's member record or all members for admin
        if ($user->isMwanachama() && $user->member) {
            $members = collect([$user->member]);
        } else {
            $members = Member::where('is_active', true)
                           ->orderBy('first_name')
                           ->get();
        }

        $serviceTypes = [
            'Ubatizo' => 'Ubatizo (Baptism)',
            'Uthibitisho' => 'Uthibitisho (Confirmation)',
            'Ndoa' => 'Ndoa (Marriage)',
            'Wakfu' => 'Wakfu (Dedication)',
            'Mazishi' => 'Mazishi (Funeral)',
            'Ushauri wa Kichungaji' => 'Ushauri wa Kichungaji (Pastoral Counseling)',
            'Nyingine' => 'Nyingine (Other)'
        ];

        return view('panel.pastoral-services.create', compact('members', 'serviceTypes'));
    }

    /**
     * Store a newly created service request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'service_type' => 'required|in:Ubatizo,Uthibitisho,Ndoa,Wakfu,Mazishi,Ushauri wa Kichungaji,Nyingine',
            'preferred_date' => 'nullable|date|after:today',
            'description' => 'nullable|string|max:2000',
        ], [
            'member_id.required' => 'Tafadhali chagua muumini',
            'member_id.exists' => 'Muumini hapatikani',
            'service_type.required' => 'Tafadhali chagua aina ya huduma',
            'service_type.in' => 'Aina ya huduma si sahihi',
            'preferred_date.date' => 'Tarehe si sahihi',
            'preferred_date.after' => 'Tarehe lazima iwe kesho au baadaye',
            'description.max' => 'Maelezo ni marefu mno',
        ]);

        $validated['status'] = 'Inasubiri';
        $validated['created_by'] = Auth::id();

        PastoralService::create($validated);

        return redirect()->route('pastoral-services.index')
            ->with('success', 'Ombi la huduma limewasilishwa kikamilifu');
    }

    /**
     * Display the specified service
     */
    public function show($id)
    {
        $service = PastoralService::with(['member', 'approver', 'creator'])->findOrFail($id);

        // Check if member can view this service
        $user = Auth::user();
        if ($user->isMwanachama() && $user->member && $service->member_id != $user->member->id) {
            abort(403, 'Huna ruhusa ya kuangalia ombi hili');
        }

        return view('panel.pastoral-services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service
     * Only pending services can be edited
     */
    public function edit($id)
    {
        $service = PastoralService::findOrFail($id);
        $user = Auth::user();

        // Check permissions
        if ($user->isMwanachama() && $user->member && $service->member_id != $user->member->id) {
            abort(403, 'Huna ruhusa ya kuhariri ombi hili');
        }

        // Only pending services can be edited
        if ($service->status != 'Inasubiri') {
            return redirect()->route('pastoral-services.show', $service->id)
                ->with('error', 'Ombi hili haliwezi kuhariribwa');
        }

        if ($user->isMwanachama() && $user->member) {
            $members = collect([$user->member]);
        } else {
            $members = Member::where('is_active', true)->orderBy('first_name')->get();
        }

        $serviceTypes = [
            'Ubatizo' => 'Ubatizo (Baptism)',
            'Uthibitisho' => 'Uthibitisho (Confirmation)',
            'Ndoa' => 'Ndoa (Marriage)',
            'Wakfu' => 'Wakfu (Dedication)',
            'Mazishi' => 'Mazishi (Funeral)',
            'Ushauri wa Kichungaji' => 'Ushauri wa Kichungaji (Pastoral Counseling)',
            'Nyingine' => 'Nyingine (Other)'
        ];

        return view('panel.pastoral-services.edit', compact('service', 'members', 'serviceTypes'));
    }

    /**
     * Update the specified service
     */
    public function update(Request $request, $id)
    {
        $service = PastoralService::findOrFail($id);
        $user = Auth::user();

        // Check permissions
        if ($user->isMwanachama() && $user->member && $service->member_id != $user->member->id) {
            abort(403, 'Huna ruhusa ya kuhariri ombi hili');
        }

        // Only pending services can be updated
        if ($service->status != 'Inasubiri') {
            return redirect()->route('pastoral-services.show', $service->id)
                ->with('error', 'Ombi hili haliwezi kuhariribwa');
        }

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'service_type' => 'required|in:Ubatizo,Uthibitisho,Ndoa,Wakfu,Mazishi,Ushauri wa Kichungaji,Nyingine',
            'preferred_date' => 'nullable|date|after:today',
            'description' => 'nullable|string|max:2000',
        ], [
            'member_id.required' => 'Tafadhali chagua muumini',
            'member_id.exists' => 'Muumini hapatikani',
            'service_type.required' => 'Tafadhali chagua aina ya huduma',
            'service_type.in' => 'Aina ya huduma si sahihi',
            'preferred_date.date' => 'Tarehe si sahihi',
            'preferred_date.after' => 'Tarehe lazima iwe kesho au baadaye',
            'description.max' => 'Maelezo ni marefu mno',
        ]);

        $validated['updated_by'] = Auth::id();
        $service->update($validated);

        return redirect()->route('pastoral-services.show', $service->id)
            ->with('success', 'Ombi limeharibiwa kikamilifu');
    }

    /**
     * Approve a service request (Admin/Pastor only)
     */
    public function approve(Request $request, $id)
    {
        $service = PastoralService::findOrFail($id);

        if ($service->status != 'Inasubiri') {
            return redirect()->back()->with('error', 'Ombi hili tayari limeshughulikiwa');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $service->update([
            'status' => 'Imeidhinishwa',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pastoral-services.show', $service->id)
            ->with('success', 'Ombi limeidhinishwa kikamilifu');
    }

    /**
     * Reject a service request (Admin/Pastor only)
     */
    public function reject(Request $request, $id)
    {
        $service = PastoralService::findOrFail($id);

        if ($service->status != 'Inasubiri') {
            return redirect()->back()->with('error', 'Ombi hili tayari limeshughulikiwa');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:2000',
        ], [
            'admin_notes.required' => 'Tafadhali ingiza sababu ya kukataa',
        ]);

        $service->update([
            'status' => 'Imekataliwa',
            'admin_notes' => $validated['admin_notes'],
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pastoral-services.show', $service->id)
            ->with('success', 'Ombi limekataliwa');
    }

    /**
     * Mark service as completed (Admin/Pastor only)
     */
    public function complete($id)
    {
        $service = PastoralService::findOrFail($id);

        if ($service->status != 'Imeidhinishwa') {
            return redirect()->back()->with('error', 'Ombi hili halijaidhinishwa');
        }

        $service->update([
            'status' => 'Imekamilika',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pastoral-services.show', $service->id)
            ->with('success', 'Huduma imekamilika kikamilifu');
    }

    /**
     * Remove the specified service
     */
    public function destroy($id)
    {
        $service = PastoralService::findOrFail($id);
        $user = Auth::user();

        // Check permissions - only creator can delete pending services
        if ($user->isMwanachama() && $user->member && $service->member_id != $user->member->id) {
            abort(403, 'Huna ruhusa ya kufuta ombi hili');
        }

        // Only pending services can be deleted
        if ($service->status != 'Inasubiri') {
            return redirect()->back()->with('error', 'Ombi hili haliwezi kufutwa');
        }

        $service->delete();

        return redirect()->route('pastoral-services.index')
            ->with('success', 'Ombi limefutwa kikamilifu');
    }
}
