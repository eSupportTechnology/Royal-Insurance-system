@extends('AdminDashboard.master')
@section('title', 'Edit Profit Margin')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Profit Margin</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Edit Profit Margin</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Edit Profit Margin Details</h5>
                    </div>
                    <form action="{{ route('profitMargin.update', $profitMargin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="company_id" class="form-label">Select Company</label>
                                        <div class="position-relative">
                                            <select name="company_id" class="form-control" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}" {{ $company->id == $profitMargin->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="insurance_type_id" class="form-label">Select Insurance Type</label>
                                        <div class="position-relative">
                                            <select name="insurance_type_id" id="insurance_type_id" class="form-control" required>
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $insuranceType)
                                                    <option value="{{ $insuranceType->id }}" {{ $insuranceType->id == $profitMargin->insurance_type_id ? 'selected' : '' }}>{{ $insuranceType->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Select Category</label>
                                        <div class="position-relative">
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $profitMargin->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sub_category_id" class="form-label">Select Sub Category</label>
                                        <div class="position-relative">
                                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                                <option value="">Select Sub Category</option>
                                                @foreach ($sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}" {{ $sub_category->id == $profitMargin->sub_category_id ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="form_field_id" class="form-label">Select Form Field</label>
                                        <div class="position-relative">
                                            <select name="form_field_id" id="form_field_id" class="form-control">
                                                <option value="">Select Form Field</option>
                                                @foreach ($form_fields as $form_field)
                                                    <option value="{{ $form_field->id }}" {{ $form_field->id == $profitMargin->form_field_id ? 'selected' : '' }}>{{ $form_field->field_name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="profit_type" class="form-label">Select Type</label>
                                        <div class="position-relative">
                                            <select name="profit_type" id="profit_type" class="form-control" required>
                                                <option value="">Select Type</option>
                                                <option value="RCC" {{ $profitMargin->profit_type == 'RCC' ? 'selected' : '' }}>RCC</option>
                                                <option value="TC" {{ $profitMargin->profit_type == 'TC' ? 'selected' : '' }}>TC</option>
                                                <option value="Net Premium" {{ $profitMargin->profit_type == 'Net Premium' ? 'selected' : '' }}>Net Premium</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>RIB</th>
                                                    <th>Main Agent</th>
                                                    <th>Sub Agent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="total" class="form-control" value="{{ $profitMargin->total }}" required></td>
                                                    <td><input type="text" name="rib" class="form-control" value="{{ $profitMargin->rib }}" required></td>
                                                    <td><input type="text" name="main_agent" class="form-control" value="{{ $profitMargin->main_agent }}" required></td>
                                                    <td><input type="text" name="sub_agent" class="form-control" value="{{ $profitMargin->sub_agent }}" required></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('profitMargin.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
