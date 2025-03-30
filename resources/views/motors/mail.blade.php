@extends('AdminDashboard.master')
@section('title', 'Request Details- Motor Insurance')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Request Details- Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Request Details- Motor Insurance</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Mail Request Details</h5>
                    </div>
                    <form action="{{ route('storemailmotors', $customerResponse->id) }}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Company Selection -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Select Company</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="company_id" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Customer Response Details -->
                                    <div class="card mb-4">
                                        <div class="card-header">Customer Response Details</div>
                                        <div class="card-body">
                                            @foreach ($customerResponseFields as $field)
                                                <div class="mb-3">
                                                    <label>{{ $field->formField->field_name }}:</label>
                                                    <p>{{ $field->response }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Send Mail</button>
                            <a href="{{ route('indexxx') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
