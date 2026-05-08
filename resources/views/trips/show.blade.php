@extends('layout')
@section('title', $trip->name)

@section('content')
    <div class="mb-3">
        @if(Auth::user()->isParent())
            <a href="{{ route('parent.children') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to My Children</a>
        @else
            <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Trips</a>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">{{ $trip->name }}</h1>
            <p class="card-text">
                <strong>Destination:</strong> {{ $trip->destination }}<br>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($trip->date)->format('l, d F Y') }}<br>
                <strong>Price:</strong> &euro;{{ number_format($trip->price, 2) }}
            </p>

            @if($trip->description)
                <hr>
                <h5>About this trip</h5>
                <p>{{ $trip->description }}</p>
            @endif

            @if($trip->bank_details)
                <hr>
                <h5>Payment Information</h5>
                <div class="alert alert-info">
                    {!! nl2br(e($trip->bank_details)) !!}
                </div>
            @endif
        </div>
    </div>

    @if(Auth::user()->isTeacher())
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
    @endif

    @if(Auth::user()->isParent())
        <h3>Your Children on This Trip</h3>
        @forelse($trip->students as $student)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0">{{ $student->name }}</h5>
                            <small class="text-muted">Class {{ $student->class }}</small>
                        </div>
                        <div class="col-md-3">
                            <strong>Permission:</strong>
                            @if($student->pivot->permission_given)
                                <span class="badge bg-success">Submitted</span>
                            @else
                                <span class="badge bg-warning">Not yet submitted</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <strong>Payment:</strong>
                            @if($student->pivot->paid)
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            @if(!$student->pivot->permission_given)
                                <form method="POST" action="{{ route('parent.submit-permission', ['student' => $student->id, 'trip' => $trip->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Submit Permission</button>
                                </form>
                            @else
                                <span class="text-success fw-bold">Ready to go!</span>
                            @endif
                        </div>
                    </div>
                    @if($student->pivot->notes)
                        <hr>
                        <small class="text-muted"><strong>Notes:</strong> {{ $student->pivot->notes }}</small>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                None of your children are registered for this trip.
            </div>
        @endforelse
    @endif

    @if(Auth::user()->isTeacher())
        <h3>All Students</h3>
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
                                        {{ $student->pivot->permission_given ? 'Yes' : 'No' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('trips.students.toggle-paid', [$trip, $student]) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-{{ $student->pivot->paid ? 'success' : 'outline-secondary' }}">
                                        {{ $student->pivot->paid ? 'Yes' : 'No' }}
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
    @endif
@endsection
