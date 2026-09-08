<?php

namespace App\Http\Controllers;

use App\Models\ChildrenClass;
use App\Models\Member;
use Illuminate\Http\Request;

class ChildrenClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = ChildrenClass::withCount(['activeStudents', 'teachers'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })
            ->orderBy('name')
            ->paginate(15);

        $stats = [
            'total_classes' => ChildrenClass::count(),
            'active_classes' => ChildrenClass::active()->count(),
            'total_students' => \DB::table('children_students')->where('status', 'Active')->count(),
            'total_teachers' => \DB::table('children_teachers')->where('is_active', true)->count(),
        ];

        if ($request->ajax()) {
            return view('panel.children._table', compact('classes'));
        }

        return view('panel.children.index', compact('classes', 'stats'));
    }

    public function create()
    {
        $teachers = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        return view('panel.children.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:children_classes,name',
            'description' => 'nullable|string|max:1000',
            'age_min' => 'nullable|integer|min:0|max:18',
            'age_max' => 'nullable|integer|min:0|max:18|gte:age_min',
        ], [
            'name.required' => 'Tafadhali ingiza jina la darasa',
            'name.unique' => 'Jina la darasa tayari linatumika',
            'age_max.gte' => 'Umri wa juu lazima uwe mkubwa au sawa na wa chini',
        ]);

        ChildrenClass::create($validated);

        return redirect()->route('children.index')
            ->with('success', 'Darasa limeundwa kikamilifu');
    }

    public function show($id)
    {
        $class = ChildrenClass::with(['activeStudents', 'teachers.member'])->findOrFail($id);

        return view('panel.children.show', compact('class'));
    }

    public function edit($id)
    {
        $class = ChildrenClass::findOrFail($id);
        return view('panel.children.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = ChildrenClass::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:children_classes,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'age_min' => 'nullable|integer|min:0|max:18',
            'age_max' => 'nullable|integer|min:0|max:18|gte:age_min',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $class->update($validated);

        return redirect()->route('children.show', $class->id)
            ->with('success', 'Darasa limesasishwa kikamilifu');
    }

    public function destroy($id)
    {
        $class = ChildrenClass::findOrFail($id);

        if ($class->students()->count() > 0) {
            return redirect()->back()->with('error', 'Haliwezi kufuta darasa lenye wanafunzi');
        }

        $class->delete();
        return redirect()->route('children.index')
            ->with('success', 'Darasa limefutwa');
    }

    public function addStudent(Request $request, $classId)
    {
        $class = ChildrenClass::findOrFail($classId);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id|unique:children_students,member_id,NULL,id,class_id,' . $classId,
            'notes' => 'nullable|string|max:500',
        ], [
            'member_id.required' => 'Tafadhali chagua mtoto',
            'member_id.unique' => 'Mtoto huyu tayari yuko katika darasa hili',
        ]);

        $class->students()->attach($validated['member_id'], [
            'status' => 'Active',
            'enrollment_date' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Mtoto ameongezwa kikamilifu');
    }

    public function removeStudent($classId, $memberId)
    {
        $class = ChildrenClass::findOrFail($classId);
        $class->students()->detach($memberId);

        return redirect()->back()->with('success', 'Mtoto ameondolewa');
    }

    public function addTeacher(Request $request, $classId)
    {
        $class = ChildrenClass::findOrFail($classId);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'required|in:Mwalimu,Msaidizi,Kiongozi',
        ]);

        $class->teachers()->attach($validated['member_id'], [
            'role' => $validated['role'],
            'start_date' => now(),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Mwalimu ameongezwa');
    }

    public function removeTeacher($classId, $memberId)
    {
        $class = ChildrenClass::findOrFail($classId);
        $class->teachers()->detach($memberId);

        return redirect()->back()->with('success', 'Mwalimu ameondolewa');
    }
}
