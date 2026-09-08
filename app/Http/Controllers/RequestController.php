<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\ApprovalStep;
use App\Models\ApprovalThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $query = RequestModel::with(['requester', 'approver', 'steps.approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        if ($request->filled('start_date')) {
            $query->where('requested_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('requested_date', '<=', $request->end_date);
        }

        $requests = $query->orderBy('requested_date', 'desc')->paginate(7);

        $stats = [
            'total' => RequestModel::count(),
            'pending' => RequestModel::pending()->count(),
            'approved' => RequestModel::approved()->count(),
            'rejected' => RequestModel::rejected()->count(),
        ];

        $statusCounts = [
            'Inasubiri' => $stats['pending'],
            'Imeidhinishwa' => $stats['approved'],
            'Imekataliwa' => $stats['rejected'],
        ];

        $departments = RequestModel::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->orderBy('department')
            ->pluck('department');

        return view('panel.requests.index', compact(
            'requests',
            'stats',
            'statusCounts',
            'departments'
        ));
    }

    public function create()
    {
        $departments = [
            'Uongozi', 'Uimbaji', 'Usafi', 'Afya', 'Teknolojia',
            'Mapokezi', 'Vijana', 'Wanawake', 'Watoto'
        ];

        $year = date('Y');
        $lastRequest = RequestModel::whereYear('created_at', $year)
            ->orderBy('id', 'desc')->first();
        $sequence = $lastRequest ? intval(substr($lastRequest->request_number, -4)) + 1 : 1;
        $nextRequestNumber = 'REQ' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        return view('panel.requests.create', compact('departments', 'nextRequestNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'amount_requested' => 'required|numeric|min:0|max:999999999999.99',
            'requested_date' => 'required|date',
        ], [
            'title.required' => 'Tafadhali ingiza kichwa cha ombi',
            'title.max' => 'Kichwa ni kirefu mno',
            'department.required' => 'Tafadhali chagua idara',
            'department.max' => 'Jina la idara ni refu mno',
            'description.required' => 'Tafadhali ingiza maelezo ya ombi',
            'description.max' => 'Maelezo ni marefu mno',
            'amount_requested.required' => 'Tafadhali ingiza kiasi kinachohitajika',
            'amount_requested.numeric' => 'Kiasi lazima kiwe nambari',
            'amount_requested.min' => 'Kiasi lazima kiwe chanya',
            'amount_requested.max' => 'Kiasi ni kubwa mno',
            'requested_date.required' => 'Tafadhali chagua tarehe ya ombi',
            'requested_date.date' => 'Tarehe si sahihi',
        ]);

        $year = date('Y');
        $lastRequest = RequestModel::whereYear('created_at', $year)
            ->orderBy('id', 'desc')->first();
        $sequence = $lastRequest ? intval(substr($lastRequest->request_number, -4)) + 1 : 1;
        $validated['request_number'] = 'REQ' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $validated['status'] = 'Inasubiri';
        $validated['requested_by'] = Auth::id();

        // Determine approval chain from threshold
        $threshold = ApprovalThreshold::findForAmount($validated['amount_requested']);
        $roles = $threshold ? $threshold->required_roles : ['Mhasibu', 'Mchungaji'];
        $validated['max_level'] = count($roles);
        $validated['current_level'] = 1;

        DB::transaction(function () use ($validated, $roles) {
            $requestModel = RequestModel::create($validated);

            // Create approval steps
            foreach ($roles as $index => $role) {
                ApprovalStep::create([
                    'request_id' => $requestModel->id,
                    'level' => $index + 1,
                    'role_required' => $role,
                ]);
            }
        });

        return redirect()->route('requests.index')
            ->with('success', 'Ombi limewasilishwa kikamilifu');
    }

    public function show($id)
    {
        $request = RequestModel::with(['requester', 'approver', 'steps.approver'])->findOrFail($id);
        $approvalStages = $request->getApprovalStages();

        return view('panel.requests.show', compact('request', 'approvalStages'));
    }

    public function edit($id)
    {
        $requestModel = RequestModel::findOrFail($id);

        if ($requestModel->status !== 'Inasubiri') {
            return redirect()->route('requests.show', $id)
                ->with('error', 'Ombi ambalo tayari limeidhinishwa au kukataliwa haliwezi kubadilishwa');
        }

        $departments = [
            'Uongozi', 'Uimbaji', 'Usafi', 'Afya', 'Teknolojia',
            'Mapokezi', 'Vijana', 'Wanawake', 'Watoto'
        ];

        return view('panel.requests.edit', [
            'request' => $requestModel,
            'departments' => $departments
        ]);
    }

    public function update(Request $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);

        if ($requestModel->status !== 'Inasubiri') {
            return redirect()->route('requests.show', $id)
                ->with('error', 'Ombi ambalo tayari limeidhinishwa au kukataliwa haliwezi kubadilishwa');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'amount_requested' => 'required|numeric|min:0|max:999999999999.99',
            'requested_date' => 'required|date',
        ], [
            'title.required' => 'Tafadhali ingiza kichwa cha ombi',
            'title.max' => 'Kichwa ni kirefu mno',
            'department.required' => 'Tafadhali chagua idara',
            'department.max' => 'Jina la idara ni refu mno',
            'description.required' => 'Tafadhali ingiza maelezo ya ombi',
            'description.max' => 'Maelezo ni marefu mno',
            'amount_requested.required' => 'Tafadhali ingiza kiasi kinachohitajika',
            'amount_requested.numeric' => 'Kiasi lazima kiwe nambari',
            'amount_requested.min' => 'Kiasi lazima kiwe chanya',
            'amount_requested.max' => 'Kiasi ni kubwa mno',
            'requested_date.required' => 'Tafadhali chagua tarehe ya ombi',
            'requested_date.date' => 'Tarehe si sahihi',
        ]);

        $requestModel->update($validated);

        return redirect()->route('requests.index')
            ->with('success', 'Ombi limebadilishwa kikamilifu');
    }

    public function destroy($id)
    {
        $request = RequestModel::findOrFail($id);
        $request->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Ombi limefutwa kikamilifu');
    }

    /**
     * Approve a request at the current level with digital signature
     */
    public function approve(Request $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);

        if ($requestModel->status !== 'Inasubiri') {
            return redirect()->route('requests.show', $id)
                ->with('error', 'Ombi hili tayari limeshughulikiwa');
        }

        $validated = $request->validate([
            'amount_approved' => 'required|numeric|min:0|max:999999999999.99',
            'approval_notes' => 'nullable|string|max:1000',
            'digital_signature' => 'required|string',
            'signature_data' => 'required|string',
        ], [
            'amount_approved.required' => 'Tafadhali ingiza kiasi kilichoidhinishwa',
            'amount_approved.numeric' => 'Kiasi lazima kiwe nambari',
            'amount_approved.min' => 'Kiasi lazima kiwe chanya',
            'amount_approved.max' => 'Kiasi ni kubwa mno',
            'approval_notes.max' => 'Maelezo ni marefu mno',
            'digital_signature.required' => 'Tafadhali sahihi kidigitali',
            'signature_data.required' => 'Tafadhali sahihi kidigitali',
        ]);

        $nextStep = $requestModel->nextPendingStep();
        if (!$nextStep) {
            return redirect()->route('requests.show', $id)
                ->with('error', 'Hatua ya sasa ya idhinishaji haipatikani');
        }

        // Save digital signature as image file
        $signaturePath = null;
        if (!empty($validated['signature_data'])) {
            $signatureData = $validated['signature_data'];
            if (str_starts_with($signatureData, 'data:image/png;base64,')) {
                $signatureData = substr($signatureData, 22);
            } elseif (str_starts_with($signatureData, 'data:image/jpeg;base64,')) {
                $signatureData = substr($signatureData, 23);
            }

            $signatureBinary = base64_decode($signatureData);
            if ($signatureBinary !== false) {
                $filename = 'signatures/request_' . $id . '_level_' . $nextStep->level . '_' . time() . '.png';
                Storage::disk('public')->put($filename, $signatureBinary);
                $signaturePath = $filename;
            }
        }

        DB::transaction(function () use ($requestModel, $nextStep, $validated, $signaturePath) {
            $timestamp = now()->toDateTimeString();

            // Update the current approval step
            $nextStep->update([
                'decision' => 'approved',
                'comments' => $validated['approval_notes'] ?? null,
                'approver_user_id' => Auth::id(),
                'digital_signature_hash' => ApprovalStep::generateSignatureHash(
                    Auth::id(), $requestModel->id, $nextStep->level, $timestamp
                ),
                'signature_path' => $signaturePath,
                'ip_address' => request()->ip(),
                'acted_at' => $timestamp,
            ]);

            // Check if fully approved
            $pendingSteps = $requestModel->steps()->whereNull('acted_at')->count();

            if ($pendingSteps === 0) {
                // All steps completed
                $requestModel->update([
                    'status' => 'Imeidhinishwa',
                    'amount_approved' => $validated['amount_approved'],
                    'approval_notes' => $validated['approval_notes'] ?? null,
                    'approved_by' => Auth::id(),
                    'approved_date' => Carbon::now(),
                    'current_level' => $requestModel->max_level,
                ]);
            } else {
                // Move to next level
                $requestModel->update([
                    'current_level' => $nextStep->level + 1,
                    'amount_approved' => $validated['amount_approved'],
                ]);
            }
        });

        return redirect()->route('requests.show', $id)
            ->with('success', 'Idhinishaji limekamilika kwa hatua ya ' . $this->getLevelName($nextStep->level));
    }

    /**
     * Reject a request at the current level
     */
    public function reject(Request $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);

        if ($requestModel->status !== 'Inasubiri') {
            return redirect()->route('requests.show', $id)
                ->with('error', 'Ombi hili tayari limeshughulikiwa');
        }

        $validated = $request->validate([
            'approval_notes' => 'required|string|max:1000',
        ], [
            'approval_notes.required' => 'Tafadhali ingiza sababu za kukataa ombi',
            'approval_notes.max' => 'Maelezo ni marefu mno',
        ]);

        $nextStep = $requestModel->nextPendingStep();
        if ($nextStep) {
            $nextStep->update([
                'decision' => 'rejected',
                'comments' => $validated['approval_notes'],
                'approver_user_id' => Auth::id(),
                'acted_at' => now(),
            ]);
        }

        $requestModel->update([
            'status' => 'Imekataliwa',
            'approval_notes' => $validated['approval_notes'],
            'approved_by' => Auth::id(),
            'approved_date' => Carbon::now(),
        ]);

        return redirect()->route('requests.show', $id)
            ->with('success', 'Ombi limekataliwa');
    }

    public function pending($id)
    {
        $requestModel = RequestModel::findOrFail($id);

        $requestModel->update([
            'status' => 'Inasubiri',
            'approved_by' => null,
            'approved_date' => null,
            'approval_notes' => null,
        ]);

        return redirect()->route('requests.show', $id)
            ->with('success', 'Ombi limewekwa kwenye hali ya kusubiri');
    }

    /**
     * Get level name for display
     */
    private function getLevelName($level)
    {
        $names = [
            1 => 'Mhasibu',
            2 => 'Mchungaji',
            3 => 'Mwenyekiti',
        ];
        return $names[$level] ?? "Hatua ya {$level}";
    }
}
