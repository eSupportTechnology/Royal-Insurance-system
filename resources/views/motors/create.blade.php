@extends('layouts.simple.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Motor Insurance</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12">
        <div class="container">
            @if(session('success'))
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
		<div class="card">
		  <div class="card-header">
			<h5>Add Details</h5>
            
		  </div>
          <form action="{{ route('storemotors') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Make</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="make" placeholder="Make" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Model</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="model" placeholder="Type your Model" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Year</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="year" placeholder="Year" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="vehicle_number" placeholder="Vehicle Number" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Class</label>
                            <div class="col-sm-9">
                                <select id="class" name="class" class="form-control digits" required>
                                    <option value="Comprehensive Cover">Comprehensive Cover</option>
                                    <option value="Third Party">Third Party</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Usage</label>
                            <div class="col-sm-9">
                                <select id="usage" name="usage" class="form-control digits" required>
                                    <option value="Private Car">Private Car</option>
                                    <option value="Hiring">Hiring</option>
                                    <option value="Rent a Car">Rent a Car</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Value (Rs.)</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" id="vehicle_val" name="vehicle_value" type="number" placeholder="Vehicle Value (Rs.)" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Financial Interest (LB Finance)</label>
                            <div class="col-sm-9">
                                <select id="financial_interest" name="financial_interest" class="form-control digits" required>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Fuel Type</label>
                            <div class="col-sm-9">
                                <select id="fuel_type" name="fuel_type" class="form-control digits" required>
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="electric">Electric</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="name" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">ID Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="id_number" placeholder="ID Number" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Location</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="location" rows="3" placeholder="Location" required></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Other Details</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="other_details" rows="3" placeholder="Other Details"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Vehicle Book Copy</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file"  name="vehicle_copy[]" multiple>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">id copy / DL copy</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="id_copy[]" multiple>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Renewal Notice</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="renewal_copy[]" multiple>

                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Vehicle Photos</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="vehical_pic[]" multiple>

                            </div>
                        </div>

                        

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Client's Letter</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="client_letter[]" multiple >

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Other Docs</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="other_doc[]" multiple>

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label pt-0">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status" disabled>
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
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
@endsection