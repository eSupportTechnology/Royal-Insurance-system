@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Customer</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Edit Customer</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Edit Details</h5>

                    </div>
                    <form action="{{ route('customerinsurance.update', $customerinsurance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="inv" class="col-sm-3 col-form-label">INV</label>
                                        <input type="text" name="inv" id="inv" class="form-control"
                                            value="{{ old('inv', $customerinsurance->inv) }}" required>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="date" class="col-sm-3 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control"
                                            value="{{ old('date', $customerinsurance->date) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="company_id" class="form-label">Select Customer</label>
                                        <div class="position-relative">
                                            <select name="customer_id" class="form-control" required>
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $customer->id == $customerinsurance->customer_id ? 'selected' : '' }}>
                                                        {{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Include similar form fields for the remaining columns -->
                                    <div class="mb-3 row">
                                        <label for="policy" class="col-sm-3 col-form-label">Policy</label>
                                        <input type="text" name="policy" id="policy" class="form-control"
                                            value="{{ old('policy', $customerinsurance->policy) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="dn" class="col-sm-3 col-form-label">D/N</label>
                                        <input type="text" name="dn" id="dn" class="form-control"
                                            value="{{ old('dn', $customerinsurance->dn) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="vehicle" class="col-sm-3 col-form-label">Vehicle</label>
                                        <input type="text" name="vehicle" id="vehicle" class="form-control"
                                            value="{{ old('vehicle', $customerinsurance->vehicle) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="company_id" class="form-label">Select Company</label>
                                        <div class="position-relative">
                                            <select name="company_id" class="form-control" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ $company->id == $customerinsurance->company_id ? 'selected' : '' }}>
                                                        {{ $company->name }}</option>
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
                                            <select name="insurance_type_id" id="insurance_type_id" class="form-control"
                                                required>
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $insuranceType)
                                                    <option value="{{ $insuranceType->id }}"
                                                        {{ $insuranceType->id == $customerinsurance->insurance_type_id ? 'selected' : '' }}>
                                                        {{ $insuranceType->name }}</option>
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
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $customerinsurance->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
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
                                                    <option value="{{ $sub_category->id }}"
                                                        {{ $sub_category->id == $customerinsurance->sub_category_id ? 'selected' : '' }}>
                                                        {{ $sub_category->name }}</option>
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
                                                    <option value="{{ $form_field->id }}"
                                                        {{ $form_field->id == $customerinsurance->form_field_id ? 'selected' : '' }}>
                                                        {{ $form_field->field_name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="rep" class="col-sm-3 col-form-label">Rep</label>
                                        <input type="text" name="rep" id="rep" class="form-control"
                                            value="{{ old('rep', $customerinsurance->rep) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="basic" class="col-sm-3 col-form-label">Basic</label>
                                        <input type="number" name="basic" id="basic" step="0.01"
                                            class="form-control" value="{{ old('basic', $customerinsurance->basic) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="srcc" class="col-sm-3 col-form-label">SRCC</label>
                                        <input type="number" name="srcc" id="srcc" step="0.01"
                                            class="form-control" value="{{ old('srcc', $customerinsurance->srcc) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tc" class="col-sm-3 col-form-label">TC</label>
                                        <input type="number" name="tc" id="tc" step="0.01"
                                            class="form-control" value="{{ old('tc', $customerinsurance->tc) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="others" class="col-sm-3 col-form-label">Others</label>
                                        <input type="number" name="others" id="others" step="0.01"
                                            class="form-control" value="{{ old('others', $customerinsurance->others) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                                        <input type="number" name="total" id="total" step="0.01"
                                            class="form-control" value="{{ old('total', $customerinsurance->total) }}"
                                            required>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="sum_insured" class="col-sm-3 col-form-label">Sum Insured</label>
                                        <input type="number" name="sum_insured" id="sum_insured" step="0.01"
                                            class="form-control"
                                            value="{{ old('sum_insured', $customerinsurance->sum_insured) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="from_date" class="col-sm-3 col-form-label">From Date</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control"
                                            value="{{ old('from_date', $customerinsurance->from_date) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="to_date" class="col-sm-3 col-form-label">To Date</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control"
                                            value="{{ old('to_date', $customerinsurance->to_date) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                                        <input type="text" name="contact" id="contact" class="form-control"
                                            value="{{ old('contact', $customerinsurance->contact) }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $customerinsurance->address) }}</textarea>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="agent_code" class="col-sm-3 col-form-label">Agent Code</label>
                                        <div class="position-relative">
                                            <select name="agent_code" id="agent_code" class="form-control" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Agent Rep_code</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->rep_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    {{-- subagents --}}
                                    <div class="mb-3 row">
                                        <label for="subagent_code" class="col-sm-3 col-form-label">Sub Agent
                                            Code</label>
                                        <div class="position-relative">
                                            <select name="subagent_code" id="subagent_code" class="form-control" nullable
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select SubAgent Rep_code</option>
                                                @foreach ($agentsWithSubagents as $agent)
                                                    @foreach ($agent->subagents as $index => $subagent)
                                                        <option
                                                            value="{{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}">
                                                            {{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="position-relative">
                                            <select name="status" id="status" class="form-control" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Type</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Debit">Debit</option>

                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>

                                    </div>

                                    <div class="card-footer text-end">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endsection
