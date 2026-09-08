<?php

namespace App\Http\Controllers;

use App\Models\DepartmentApproval;
use App\Models\ApprovalStep;
use App\Models\ApprovalThreshold;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartmentApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = DepartmentApproval::with(['department', 'requester']);

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);
        if ($request->filled('priority')) $query->where('priority', $request->priority);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('approval_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $approvals = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => DepartmentApproval::count(),
            'pending' => DepartmentApproval::pending()->count(),
            'approved' => DepartmentApproval::where('status', 'Imekamilika')->count(),
            'rejected' => DepartmentApproval::where('status', 'Imekataliwa')->count(),
        ];

        $departments = Department::active()->get();

        if ($request->ajax()) {
            return view('panel.approvals._table', compact('approvals'));
        }

        return view('panel.approvals.index', compact('approvals', 'stats', 'departments'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        $thresholds = ApprovalThreshold::where('is_active', true)->get();

        return view('panel.approvals.create', compact('departments', 'thresholds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount_requested' => 'required|numeric|min:1',
            'expense_purpose' => 'required|string|max:500',
            'priority' => 'required|in:Ya Dharura,Ya Juu,Ya Kawaida',
            'requested_date' => 'required|date',
        ], [
            'department_id.required' => 'Tafadhali chagua idara',
            'title.required' => 'Tafadhali ingiza kichwa',
            'amount_requested.required' => 'Tafadhali ingiza kiasi',
            'amount_requested.min' => 'Kiasi lazima kiwe angalau TZS 1',
            'expense_purpose.required' => 'Tafadhali eleza lengo la matumizi',
        ]);

        $validated['requested_by'] = auth()->id();
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'Inasubiri';

        $approval = DepartmentApproval::create($validated);

        return redirect()->route('approvals.show', $approval->id)
            ->with('success', 'Ombi la fedha limewasilishwa. Nambari: ' . $approval->approval_number);
    }

    public function show($id)
    {
        $approval = DepartmentApproval::with(['department', 'requester', 'steps.approver', 'creator'])->findOrFail($id);

        return view('panel.approvals.show', compact('approval'));
    }

    public function approve(Request $request, $id)
    {
        $approval = DepartmentApproval::with('steps')->findOrFail($id);
        $user = auth()->user();

        if (!$approval->canBeApprovedBy($user)) {
            return redirect()->back()->with('error', 'Huna ruhusa ya kuthibitisha ombi hili katika hatua hii');
        }

        if (!$user->signature_path || !Storage::disk('public')->exists($user->signature_path)) {
            return redirect()->back()->with('error', 'Tafadhali pakia digital signature yako kwanza katika mipangilio');
        }

        $validated = $request->validate([
            'comments' => 'nullable|string|max:500',
            'amount_approved' => 'nullable|numeric|min:0',
            'signature_data' => 'required|string',
        ]);

        // Save signature from canvas
        $signatureData = $validated['signature_data'];
        $img = str_replace('data:image/png;base64,', '', $signatureData);
        $img = str_replace(' ', '+', $img);
        $decoded = base64_decode($img);

        $sigDir = storage_path('app/public/signatures/approvals/' . $approval->id);
        if (!is_dir($sigDir)) mkdir($sigDir, 0755, true);

        $sigFilename = 'step_' . $approval->current_level . '_' . time() . '.png';
        file_put_contents($sigDir . '/' . $sigFilename, $decoded);
        $sigPath = 'signatures/approvals/' . $approval->id . '/' . $sigFilename;

        // Generate digital signature hash
        $timestamp = now()->toIso8601String();
        $hash = ApprovalStep::generateSignatureHash($user->id, $approval->id, $approval->current_level, $timestamp);

        // Find and update the current step
        $step = $approval->steps()->where('level', $approval->current_level)->first();
        $step->update([
            'approver_user_id' => $user->id,
            'decision' => 'approved',
            'comments' => $validated['comments'] ?? null,
            'digital_signature_hash' => $hash,
            'signature_path' => $sigPath,
            'ip_address' => $request->ip(),
            'device_fingerprint' => substr($request->userAgent(), 0, 255),
            'otp_verified' => true,
            'acted_at' => now(),
        ]);

        // Update approval amount if provided
        if (!empty($validated['amount_approved'])) {
            $approval->update(['amount_approved' => $validated['amount_approved']]);
        }

        // Check if fully approved
        if ($approval->isFullyApproved()) {
            $approval->update([
                'status' => 'Imekamilika',
                'approved_date' => now(),
                'current_level' => $approval->max_level,
            ]);
        } else {
            $nextLevel = $approval->current_level + 1;
            $nextStep = $approval->steps()->where('level', $nextLevel)->first();
            $statusMap = [
                'Mhasibu' => 'Mapitio ya Mhasibu',
                'Mchungaji' => 'Imeidhinishwa na Mchungaji',
            ];
            $approval->update([
                'current_level' => $nextLevel,
                'status' => $statusMap[$nextStep->role_required] ?? 'Inasubiri',
            ]);
        }

        return redirect()->back()->with('success', 'Umefanikiwa kuthibitisha. Saini yako ya kidijitali imerekodwa.');
    }

    public function reject(Request $request, $id)
    {
        $approval = DepartmentApproval::with('steps')->findOrFail($id);
        $user = auth()->user();

        if (!$approval->canBeApprovedBy($user)) {
            return redirect()->back()->with('error', 'Huna ruhusa ya kukataa ombi hili');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
            'signature_data' => 'required|string',
        ]);

        // Save signature
        $signatureData = $validated['signature_data'];
        $img = str_replace('data:image/png;base64,', '', $signatureData);
        $img = str_replace(' ', '+', $img);
        $decoded = base64_decode($img);

        $sigDir = storage_path('app/public/signatures/approvals/' . $approval->id);
        if (!is_dir($sigDir)) mkdir($sigDir, 0755, true);

        $sigFilename = 'reject_' . $approval->current_level . '_' . time() . '.png';
        file_put_contents($sigDir . '/' . $sigFilename, $decoded);
        $sigPath = 'signatures/approvals/' . $approval->id . '/' . $sigFilename;

        $hash = ApprovalStep::generateSignatureHash($user->id, $approval->id, $approval->current_level, now()->toIso8601String());

        $step = $approval->steps()->where('level', $approval->current_level)->first();
        $step->update([
            'approver_user_id' => $user->id,
            'decision' => 'rejected',
            'comments' => $validated['rejection_reason'],
            'digital_signature_hash' => $hash,
            'signature_path' => $sigPath,
            'ip_address' => $request->ip(),
            'device_fingerprint' => substr($request->userAgent(), 0, 255),
            'acted_at' => now(),
        ]);

        $approval->update([
            'status' => 'Imekataliwa',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Ombi limekataliwa');
    }

    public function thresholds()
    {
        $thresholds = ApprovalThreshold::all();
        return view('panel.approvals.thresholds', compact('thresholds'));
    }

    public function storeThreshold(Request $request)
    {
        $validated = $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'required_roles' => 'required|array|min:1',
            'expected_hours' => 'required|integer|min:1',
        ]);

        ApprovalThreshold::create($validated);
        return redirect()->back()->with('success', 'Kiwango kimeongezwa');
    }

    public function updateSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = auth()->user();

        if ($user->signature_path && Storage::disk('public')->exists($user->signature_path)) {
            Storage::disk('public')->delete($user->signature_path);
        }

        $path = $request->file('signature')->store('signatures/staff', 'public');
        $user->update(['signature_path' => $path]);

        return redirect()->back()->with('success', 'Digital signature yako imewekwa');
    }
}
