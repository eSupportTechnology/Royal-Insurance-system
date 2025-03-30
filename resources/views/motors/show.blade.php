@extends('AdminDashboard.master')

@section('title', 'Customer Response Details')

@section('content')
<div class="container mt-8">
    <div class="card mb-4 mt-5">
        <div class="card-header"><h5>Customer Information</h5></div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $response->customer_name }}</p>
            <p><strong>Email:</strong> {{ $response->customer_email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $response->customer_phone ?? 'N/A' }}</p>
            <p><strong>Insurance Type:</strong> {{ $response->insuranceType->name ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $response->category->name ?? 'N/A' }}</p>
            <p><strong>Sub Category:</strong> {{ $response->subCategory->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $response->status }}</p>
            <p><strong>Submitted Date:</strong> {{ $response->date ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5>Customer Responses</h5></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Field Type</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($response->responseFields as $field)
                        <tr>
                            <td>{{ $field->formField->field_name ?? 'N/A' }}</td>
                            <td>{{ $field->formField->field_type ?? 'N/A' }}</td>
                            <td>
                                @if($field->formField->field_type === 'file')
                                    @php
                                        $filePath = 'storage/' . $field->response;
                                        $isImage = in_array(pathinfo($filePath, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset($filePath) }}" alt="Uploaded Image" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                                    @else
                                        <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-sm btn-outline-primary">Download File</a>
                                    @endif

                                @else
                                    {{ $field->response }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
