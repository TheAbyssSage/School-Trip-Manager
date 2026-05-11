<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::withCount('students')
            ->orderBy('date', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $user = auth()->user();

        if ($user->isParent()) {
            // Parents only see their own children
            $childIds = $user->students()->pluck('id');
            $trip->load(['students' => function ($query) use ($childIds) {
                $query->whereIn('student_id', $childIds)->orderBy('class')->orderBy('name');
            }]);
        } else {
            $trip->load(['students' => function ($query) {
                $query->orderBy('class')->orderBy('name');
            }]);
        }

        $totalStudents = $trip->students->count();
        $permissionCount = $trip->students->where('pivot.permission_given', true)->count();
        $paidCount = $trip->students->where('pivot.paid', true)->count();

        return view('trips.show', compact('trip', 'totalStudents', 'permissionCount', 'paidCount'));
    }

    public function create()
    {
        return view('trips.create');
    }

    public function store(Request $request)
    {
        Trip::create($this->validateTrip($request));

        return redirect()->route('trips.index')->with('success', 'Trip created successfully!');
    }

    public function edit(Trip $trip)
    {
        return view('trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $trip->update($this->validateTrip($request));

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully!');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Trip deleted.');
    }

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

    protected function validateTrip(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'bank_details' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:2000',
        ]);
    }
}
