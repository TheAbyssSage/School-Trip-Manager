<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class StudentTripController extends Controller
{
    public function togglePermission(Trip $trip, Student $student)
    {
        $current = $trip->students()
            ->where('student_id', $student->id)
            ->first()
            ->pivot
            ->permission_given;

        $trip->students()->updateExistingPivot($student->id, [
            'permission_given' => ! $current,
        ]);

        return back()->with('success', 'Permission status updated.');
    }

    public function togglePaid(Trip $trip, Student $student)
    {
        $current = $trip->students()
            ->where('student_id', $student->id)
            ->first()
            ->pivot
            ->paid;

        $trip->students()->updateExistingPivot($student->id, [
            'paid' => ! $current,
        ]);

        return back()->with('success', 'Payment status updated.');
    }

    public function updateNotes(Request $request, Trip $trip, Student $student)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $trip->students()->updateExistingPivot($student->id, [
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Notes updated.');
    }
}
