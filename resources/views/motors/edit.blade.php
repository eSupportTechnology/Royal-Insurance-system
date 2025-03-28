@extends('AdminDashboard.master')
@section('title', 'Edit Motor Insurance')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Motor Insurance</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12">
		<div class="container">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>

		<div class="card">
		  <div class="card-header">
			<h5>Edit Request Details</h5>
		  </div>
          <form action="{{ route('updatemotors', $motor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Make</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="make" value="{{ $motor->make }}" placeholder="Make" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Model</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="model" value="{{ $motor->model }}" placeholder="Type your Model" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Year</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="year" value="{{ $motor->year }}" placeholder="Year" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="vehicle_number" value="{{ $motor->vehicle_number }}" placeholder="Vehicle Number" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Class</label>
                            <div class="col-sm-9">
                                <select id="class" name="class" class="form-control digits" required>
                                    <option value="Comprehensive Cover" {{ $motor->class == 'Comprehensive Cover' ? 'selected' : '' }}>Comprehensive Cover</option>
                                    <option value="Third Party" {{ $motor->class == 'Third Party' ? 'selected' : '' }}>Third Party</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Usage</label>
                            <div class="col-sm-9">
                                <select id="usage" name="usage" class="form-control digits" required>
                                    <option value="Private Car" {{ $motor->usage == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                    <option value="Hiring" {{ $motor->usage == 'Hiring' ? 'selected' : '' }}>Hiring</option>
                                    <option value="Rent a Car" {{ $motor->usage == 'Rent a Car' ? 'selected' : '' }}>Rent a Car</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Value (Rs.)</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" id="vehicle_val" name="vehicle_value" type="number" value="{{ $motor->vehicle_value }}" placeholder="Vehicle Value (Rs.)" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Financial Interest (LB Finance)</label>
                            <div class="col-sm-9">
                                <select id="financial_interest" name="financial_interest" class="form-control digits" required>
                                    <option value="yes" {{ $motor->financial_interest == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $motor->financial_interest == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Fuel Type</label>
                            <div class="col-sm-9">
                                <select id="fuel_type" name="fuel_type" class="form-control digits" required>
                                    <option value="petrol" {{ $motor->fuel_type == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="diesel" {{ $motor->fuel_type == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="hybrid" {{ $motor->fuel_type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="electric" {{ $motor->fuel_type == 'electric' ? 'selected' : '' }}>Electric</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Customer</label>
                            <div class="col-sm-9">
                                <select name="customer_id" id="customerSelect" class="form-select" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $customer->id == $motor->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $motor->email) }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $motor->phone) }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">NIC</label>
                            <div class="col-sm-9">
                                <input type="text" id="nic" name="nic" class="form-control" value="{{ old('nic', $motor->nic) }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Location</label>
                            <div class="col-sm-9">
                                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $motor->address) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Other Details</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="other_details" rows="3" placeholder="Other Details">{{ $motor->other_details }}</textarea>
                            </div>
                        </div>

                        @foreach (['vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc'] as $field)
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                            <div class="col-sm-9">
                                <!-- Display Existing Files -->
                                @foreach (json_decode($motor->$field, true) ?? [] as $file)
                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                <input type="checkbox" name="remove_{{ $field }}[]" value="{{ $file }}"> Remove
                                @endforeach
                                <input type="file" name="{{ $field }}[]" multiple>
                            </div>
                        </div>
                        @endforeach


                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select id="status" name="status" class="form-control digits" required>
                                    <option value="Not send" {{ $motor->status == 'Not send' ? 'selected' : '' }}>Not send</option>
                                    <option value="sent" {{ $motor->status == 'sent' ? 'selected' : '' }}>sent</option>

                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('indexxx') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </form>
		</div>
	  </div>
	</div>
  </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // When customer is selected
        $('#customerSelect').on('change', function() {
            var customerId = $(this).val();
            if (customerId) {
                // Find the customer data by ID
                var customer = @json($customers);

                // Loop through customers to find the selected one
                var selectedCustomer = customer.find(c => c.id == customerId);

                // Populate the fields
                if (selectedCustomer) {
                    $('#email').val(selectedCustomer.email);
                    $('#phone').val(selectedCustomer.phone);
                    $('#nic').val(selectedCustomer.nic);
                    $('#address').val(selectedCustomer.address);
                }
            } else {
                // Clear fields if no customer is selected
                $('#email').val('');
                $('#phone').val('');
                $('#nic').val('');
                $('#address').val('');
            }
        });
    });
</script>
@endsection
