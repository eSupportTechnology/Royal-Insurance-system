@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Customer Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Customer Insurance</li>
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
                        <h5>Show Customer Insurance Details</h5>

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
                                            value="{{ old('inv', $customerinsurance->inv) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="date" class="col-sm-3 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control"
                                            value="{{ old('date', $customerinsurance->date) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $customerinsurance->name) }}" readonly>
                                    </div>

                                    <!-- Include similar form fields for the remaining columns -->
                                    <div class="mb-3 row">
                                        <label for="policy" class="col-sm-3 col-form-label">Policy</label>
                                        <input type="text" name="policy" id="policy" class="form-control"
                                            value="{{ old('policy', $customerinsurance->policy) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="dn" class="col-sm-3 col-form-label">D/N</label>
                                        <input type="text" name="dn" id="dn" class="form-control"
                                            value="{{ old('dn', $customerinsurance->dn) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="vehicle" class="col-sm-3 col-form-label">Vehicle</label>
                                        <input type="text" name="vehicle" id="vehicle" class="form-control"
                                            value="{{ old('vehicle', $customerinsurance->vehicle) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="insurance_company" class="col-sm-3 col-form-label">Company</label>
                                        <input type="text" name="insurance_company" id="insurance_company"
                                            class="form-control"
                                            value="{{ old('insurance_company', $customerinsurance->insurance_company) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="insurance_type" class="col-sm-3 col-form-label">Insurance Type</label>
                                        <input type="text" name="insurance_type" id="insurance_type" class="form-control"
                                            value="{{ old('insurance_type', $customerinsurance->insurance_type) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="category" class="col-sm-3 col-form-label">Category</label>
                                        <input type="text" name="category" id="category" class="form-control"
                                            value="{{ old('category', $customerinsurance->category) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="sub_category" class="col-sm-3 col-form-label">Sub-Category</label>
                                        <input type="text" name="sub_category" id="sub_category" class="form-control"
                                            value="{{ old('sub_category', $customerinsurance->sub_category) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="form_field" class="col-sm-3 col-form-label">Form Field</label>
                                        <input type="text" name="form_field" id="form_field" class="form-control"
                                            value="{{ old('form_field', $customerinsurance->form_field) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="rep" class="col-sm-3 col-form-label">Rep</label>
                                        <input type="text" name="rep" id="rep" class="form-control"
                                            value="{{ old('rep', $customerinsurance->rep) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="basic" class="col-sm-3 col-form-label">Basic</label>
                                        <input type="number" name="basic" id="basic" step="0.01"
                                            class="form-control" value="{{ old('basic', $customerinsurance->basic) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="srcc" class="col-sm-3 col-form-label">SRCC</label>
                                        <input type="number" name="srcc" id="srcc" step="0.01"
                                            class="form-control" value="{{ old('srcc', $customerinsurance->srcc) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tc" class="col-sm-3 col-form-label">TC</label>
                                        <input type="number" name="tc" id="tc" step="0.01"
                                            class="form-control" value="{{ old('tc', $customerinsurance->tc) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="others" class="col-sm-3 col-form-label">Others</label>
                                        <input type="number" name="others" id="others" step="0.01"
                                            class="form-control" value="{{ old('others', $customerinsurance->others) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                                        <input type="number" name="total" id="total" step="0.01"
                                            class="form-control" value="{{ old('total', $customerinsurance->total) }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="sum_insured" class="col-sm-3 col-form-label">Sum Insured</label>
                                        <input type="number" name="sum_insured" id="sum_insured" step="0.01"
                                            class="form-control"
                                            value="{{ old('sum_insured', $customerinsurance->sum_insured) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="from_date" class="col-sm-3 col-form-label">From Date</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control"
                                            value="{{ old('from_date', $customerinsurance->from_date) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="to_date" class="col-sm-3 col-form-label">To Date</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control"
                                            value="{{ old('to_date', $customerinsurance->to_date) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                                        <input type="text" name="contact" id="contact" class="form-control"
                                            value="{{ old('contact', $customerinsurance->contact) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <textarea name="address" id="address" rows="3" class="form-control" readonly>{{ old('address', $customerinsurance->address) }}</textarea>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="agent_code" class="col-sm-3 col-form-label">Agent
                                            Code</label>
                                        <input type="text" name="agent_code" id="agent_code"
                                            class="form-control"
                                            value="{{ old('Agent_code', $customerinsurance->agent_code) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="subagent_code" class="col-sm-3 col-form-label">Sub Agent
                                            Code</label>
                                        <input type="text" name="subagent_code" id="subagent_code"
                                            class="form-control"
                                            value="{{ old('subagent_code', $customerinsurance->subagent_code) }}" readonly>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                                        <input type="text" name="status" id="status" class="form-control"
                                            value="{{ old('status', $customerinsurance->status) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endsection
