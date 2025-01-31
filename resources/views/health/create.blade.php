@extends('layouts.simple.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Health Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Health Insurance</li>
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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
          <form action="{{ route('health.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="Enter Your Name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Age</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="age" placeholder="Enter Your Age" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">NIC</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nic" placeholder="Enter Your NIC" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="address" placeholder="Enter Your Address" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Weight (Kg)</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" id="weight" name="weight" type="number" placeholder="Enter Your Weight (Kg)" required>
                            </div>
                        </div>
                       
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contact</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="number" name="contact_number" placeholder="Enter Your Contact Number" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Blood Group</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="blood_group" placeholder="Enter Your Blood Group " required>
                            </div>
                        </div>
                      
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ route('health.index') }}" class="btn btn-light">Cancel</a>
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