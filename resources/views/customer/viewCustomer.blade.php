@extends('AdminDashboard.master')
@section('title', 'Customer Details')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Customer Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Customers</li>
<li class="breadcrumb-item active">Customer Details</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Customer Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $customer->name }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" value="{{ $customer->email }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $customer->phone }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">NIC</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $customer->nic }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $customer->address }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('new-customer') }}" class="btn btn-light">Back</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Responses Table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Customer Responses</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Subcategory</th>
                                    <th>Field</th>
                                    <th>Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customerResponses->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No responses found</td>
                                    </tr>
                                @else
                                    @foreach($customerResponses as $response)
                                        <tr>
                                            <td>{{ $response->subcategory->name ?? 'N/A' }}</td>
                                            <td>{{ $response->field->field_name ?? 'N/A' }}</td>
                                            <td>{{ $response->value ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('new-customer') }}" class="btn btn-light">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
