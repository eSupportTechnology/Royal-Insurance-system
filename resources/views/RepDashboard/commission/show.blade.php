@extends('RepDashboard.master')
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
                        <h5>Show Insurance Details</h5>

                    </div>
                    <form action="{{ route('customerinsurance.update', $customerinsurance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">RIB INV Number</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->inv }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->date }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->customer->name ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->contact }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Whatsapp Number</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->whatsapp }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="3" readonly>{{ $customerinsurance->address }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Policy Number</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->policy }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">D/N/INV Number</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->dn }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Vehicle/ChassiNo</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->vehicle }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->company->name ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Insurance Type</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->insuranceType->name ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->categories?->name ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sub-Category</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->subCategory?->name ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Variety Fields</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->formField?->field_name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label">Net Premium</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->basic }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SRCC Premium</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->srcc }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">TC Premium</label>
                                        <input type="text" class="form-control" value="{{ $customerinsurance->tc }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Others</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->others }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->total }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sum Insured</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->sum_insured }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Paid Amount</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->paid_amount }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Outstanding Amount</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->outstanding_amount }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Commencement Date</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->from_date }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->to_date }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Agent Code</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->agent?->rep_code ?? 'N/A' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sub Agent Code</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->subagent_code }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Premium Type</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->premium_type }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customerinsurance->status }}" readonly>
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

