@extends('layouts.simple.master')
@section('title', 'Edit Insurance Company')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Insurance Company</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Insurance Company</li>
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
          <form action="{{route('company.update',$companies->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" value="{{ $companies->name }}" placeholder="Type The Company Name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="email" value="{{ $companies->email }}" placeholder="Type the company Email" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contact </label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="number" name="contact_number" value="{{ $companies->contact_number }}" placeholder="Type The Company Contact Number " required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"> Insurance type </label>
                            <div class="col-sm-9">
                            <select class="form-select digits" id="exampleFormControlSelect9" name="insurance_type" required>
                                    <option{{ $companies->insurance_type == 'Vehicle' ? 'selected' : '' }}>Vehicle </option>
                                    <option{{ $companies->insurance_type == 'Health' ? 'selected' : '' }}>Health </option>
                                    <option{{ $companies->insurance_type == 'Property' ? 'selected' : '' }}>Property </option>
                                    <option{{ $companies->insurance_type == 'Other' ? 'selected' : '' }}>Other </option>
                                </select>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
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
