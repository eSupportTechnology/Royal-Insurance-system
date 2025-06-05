@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>New Customer</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">New Customer</li>
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
                        <h5>Add Details</h5>

                    </div>
                    <form action="{{ route('customerinsurance.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="inv" class="col-sm-3 col-form-label">INV</label>
                                        <input type="text" name="inv" id="inv" class="form-control" required>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="date" class="col-sm-3 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer_id" class="form-label">Select Customer</label>
                                        <div class="position-relative" >
                                            <select name="customer_id" class="form-control mb-5" required style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                              ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Include similar form fields for the remaining columns -->
                                    <div class="mb-3 row">
                                        <label for="policy" class="col-sm-3 col-form-label">Policy</label>
                                        <input type="text" name="policy" id="policy" class="form-control">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="dn" class="col-sm-3 col-form-label">D/N</label>
                                        <input type="text" name="dn" id="dn" class="form-control">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="vehicle" class="col-sm-3 col-form-label">Vehicle</label>
                                        <input type="text" name="vehicle" id="vehicle" class="form-control">

                                        <div class="mb-3 row">
                                            <label for="class" class="col-sm-3 col-form-label">Class</label>
                                            <input type="text" name="class" id="class" class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="insurance_company" class="col-sm-3 col-form-label">Company</label>
                                            <input type="text" name="insurance_company" id="insurance_company"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="rep" class="col-sm-3 col-form-label">Rep</label>
                                            <input type="text" name="rep" id="rep" class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="basic" class="col-sm-3 col-form-label">Basic</label>
                                            <input type="number" name="basic" id="basic" step="0.01"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="srcc" class="col-sm-3 col-form-label">SRCC</label>
                                            <input type="number" name="srcc" id="srcc" step="0.01"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="tc" class="col-sm-3 col-form-label">TC</label>
                                            <input type="number" name="tc" id="tc" step="0.01"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="others" class="col-sm-3 col-form-label">Others</label>
                                            <input type="number" name="others" id="others" step="0.01"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="total" class="col-sm-3 col-form-label">Total</label>
                                            <input type="number" name="total" id="total" step="0.01"
                                                class="form-control">

                                            <div class="mb-3 row">
                                                <label for="sum_insured" class="col-sm-3 col-form-label">Sum Insured</label>
                                                <input type="number" name="sum_insured" id="sum_insured" step="0.01"
                                                    class="form-control">
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="from_date" class="col-sm-3 col-form-label">From Date</label>
                                                <input type="date" name="from_date" id="from_date"
                                                    class="form-control">
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="to_date" class="col-sm-3 col-form-label">To Date</label>
                                                <input type="date" name="to_date" id="to_date"
                                                    class="form-control">
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                                                <input type="text" name="contact" id="contact"
                                                    class="form-control">
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                                <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="introducer_code" class="col-sm-3 col-form-label">Introducer Code</label>
                                                <input type="text" name="introducer_code" id="introducer_code"
                                                    class="form-control">
                                            </div>

                                            <div class="card-footer text-end">
                                                <div class="col-sm-9 offset-sm-3">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
