<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $students = $user->students()->with(['trips' => function ($query) {
            $query->orderBy('date', 'asc');
        }])->get();

        return view('parent.children', compact('students'));
    }

    public function submitPermission(Request $request, Student $student, Trip $trip)
    {
        // Verify this student belongs to the authenticated parent
        if ($student->parent_id !== Auth::id()) {
            abort(403);
        }

        $trip->students()->updateExistingPivot($student->id, [
            'permission_given' => true,
        ]);

        return back()->with('success', "Permission submitted for {$student->name} on trip {$trip->name}.");
    }
}
