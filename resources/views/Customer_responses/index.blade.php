@extends('AdminDashboard.master')
@section('title', 'Customer Responses')

@section('content')
<br>
<div class="card">
    <div class="card-header">
    <a href="{{ route('customerResponses.create') }}" class="btn btn-primary mb-3">Add Response</a>
    </div>
    <div class="dt-ext table-responsive">
        <table class="table table-responsive-sm" id="export-button">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Subcategory</th>
                <th>Field</th>
                <th>Response</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($responses as $response)
            <tr>
                <td>{{ $response->customer->name ?? 'N/A' }}</td>
                <td>{{ $response->subcategory->name ?? 'N/A' }}</td>
                <td>{{ $response->field->field_name }}</td>
                <td>{{ $response->value }}</td>
                <td>
                    <a href="{{ route('customerResponses.destroy', $response->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
