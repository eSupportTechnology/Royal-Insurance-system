@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Insurance Company</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Insurance Company</li>
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
		<div class="card mt-3">
		  <div class="card-header">
			<h5>Add Company Details</h5>

		  </div>
          <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="Enter Insurance Company Name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Logo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="logo" placeholder="choose the logo" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="address" placeholder="Enter Insurance Company Address">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="email" name="email" placeholder="Enter Email Address" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contact Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="contact_number" placeholder="Type your Contact Number">
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Type</label>
                            <div class="col-sm-9">
                                <select class="form-select digits" id="exampleFormControlSelect9" name="insurance_type">
                                  <option>Vehicle</option>
                                  <option>Health</option>
                                  <option>Property</option>
                                </select>
                              </div>
                          </div> --}}
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ route('company.index') }}" class="btn btn-light">Cancel</a>
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
