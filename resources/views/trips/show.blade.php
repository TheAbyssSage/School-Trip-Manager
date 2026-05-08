@extends('layout')
@section('title', $trip->name)

@section('content')
    <div class="mb-3">
        <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Trips</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">{{ $trip->name }}</h1>
            <p class="card-text">
                <strong>Destination:</strong> {{ $trip->destination }}<br>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($trip->date)->format('l, d F Y') }}<br>
                <strong>Price:</strong> &euro;{{ number_format($trip->price, 2) }}
            </p>
        </div>
    </div>

    {{-- Summary badges --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-info">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $totalStudents }}</h5>
                    <p class="card-text">Total Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $permissionCount }} / {{ $totalStudents }}</h5>
                    <p class="card-text">Permission Given</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $paidCount }} / {{ $totalStudents }}</h5>
                    <p class="card-text">Paid</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Students table --}}
    <h3>Students</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Permission</th>
                    <th>Paid</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trip->students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>
                            <form method="POST" action="{{ route('trips.students.toggle-permission', [$trip, $student]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $student->pivot->permission_given ? 'success' : 'outline-secondary' }}">
                                    {{ $student->pivot->permission_given ? '✅ Yes' : '❌ No' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('trips.students.toggle-paid', [$trip, $student]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $student->pivot->paid ? 'success' : 'outline-secondary' }}">
                                    {{ $student->pivot->paid ? '✅ Yes' : '❌ No' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('trips.students.notes', [$trip, $student]) }}" class="d-flex gap-1">
                                @csrf
                                <input type="text" name="notes" value="{{ $student->pivot->notes }}" class="form-control form-control-sm" style="min-width: 120px;" placeholder="e.g. allergies">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No students assigned to this trip yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
