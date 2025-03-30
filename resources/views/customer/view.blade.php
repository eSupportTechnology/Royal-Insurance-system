@extends('AdminDashboard.master')

@section('title', 'Customer Profile')

@section('content')
<div class="container mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Customer Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>
            <p><strong>NIC:</strong> {{ $customer->nic }}</p>
            <p><strong>Address:</strong> {{ $customer->address }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Customer Insurance Requests</h5>
        </div>
        <div class="card-body">
            @if($responses->isEmpty())
                <p class="text-muted">No insurance requests found for this customer.</p>
            @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Insurance Type</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responses as $response)
                            <tr>
                                <td>{{ $response->insuranceType->name ?? 'N/A' }}</td>
                                <td>{{ $response->category->name ?? 'N/A' }}</td>
                                <td>{{ $response->subCategory->name ?? 'N/A' }}</td>
                                <td>{{ $response->status }}</td>
                                <td>{{ $response->date ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('seemore', $response->id) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
