@extends('layout')
@section('title', 'My Children')

@section('content')
    <h1>My Children</h1>
    <p class="text-muted">View your children's upcoming trips and submit permission forms.</p>

    @forelse($students as $student)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $student->name }}</strong> — Class {{ $student->class }}
            </div>
            <div class="card-body">
                @if($student->trips->isEmpty())
                    <p class="text-muted">No upcoming trips for this student.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Trip</th>
                                    <th>Destination</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Permission</th>
                                    <th>Paid</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->trips as $trip)
                                    <tr>
                                        <td>
                                            <a href="{{ route('trips.show', $trip) }}">{{ $trip->name }}</a>
                                        </td>
                                        <td>{{ $trip->destination }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trip->date)->format('d-m-Y') }}</td>
                                        <td>&euro;{{ number_format($trip->price, 2) }}</td>
                                        <td>
                                            @if($trip->pivot->permission_given)
                                                <span class="badge bg-success">Given</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($trip->pivot->paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$trip->pivot->permission_given)
                                                <form method="POST" action="{{ route('parent.submit-permission', ['student' => $student->id, 'trip' => $trip->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">Submit Permission</button>
                                                </form>
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No children linked to your account yet. Please contact the school to link your children.
        </div>
    @endforelse
@endsection
