@extends('layout')
@section('title', 'Trips')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📋 All School Trips</h1>
        <a href="{{ route('trips.create') }}" class="btn btn-primary">+ New Trip</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Students</th>
                    <th>Permission</th>
                    <th>Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trips as $trip)
                    @php
                        $total = $trip->students_count;
                        $permission = $trip->students()->wherePivot('permission_given', true)->count();
                        $paid = $trip->students()->wherePivot('paid', true)->count();
                        $permPct = $total > 0 ? round(($permission / $total) * 100) : 0;
                        $paidPct = $total > 0 ? round(($paid / $total) * 100) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $trip->name }}</strong></td>
                        <td>{{ $trip->destination }}</td>
                        <td>{{ \Carbon\Carbon::parse($trip->date)->format('d-m-Y') }}</td>
                        <td>&euro;{{ number_format($trip->price, 2) }}</td>
                        <td>{{ $total }}</td>
                        <td>
                            <span class="badge bg-{{ $permPct >= 80 ? 'success' : ($permPct >= 50 ? 'warning' : 'danger') }}">
                                {{ $permPct }}%
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $paidPct >= 80 ? 'success' : ($paidPct >= 50 ? 'warning' : 'danger') }}">
                                {{ $paidPct }}%
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('trips.show', $trip) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('trips.edit', $trip) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No trips found. <a href="{{ route('trips.create') }}">Create one!</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $trips->links() }}
    </div>
@endsection
