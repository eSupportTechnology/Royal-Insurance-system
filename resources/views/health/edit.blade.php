@extends('layouts.simple.master')
@section('title', 'Edit Health Insurance')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Health Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Health Insurance</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12">
		<div class="container">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
          <form action="{{route('health.update',$healths->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" value="{{ $healths->name }}" placeholder="Type Your Name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Age</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="age" value="{{ $healths->age }}" placeholder="Type Your Age" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">NIC</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="string" name="nic" value="{{ $healths->nic }}" placeholder="Type Your NIC" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="address" value="{{ $healths->address }}" placeholder="Type Your Address" required>
                            </div>
                        </div>
                       
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Weight</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" id="weight" type="number" name="weight" value="{{ $healths->weight }}" placeholder="Type Your Weight" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contact </label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="number" name="contact_number" value="{{ $healths->contact_number }}" placeholder="Type Your Contact Number " required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Blood Group </label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="string" name="blood_group" value="{{ $healths->blood_group }}" placeholder="Type Your Blood Group " required>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
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
