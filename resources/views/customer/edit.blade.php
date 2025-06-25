@extends('AdminDashboard.master')
@section('title', 'Edit Customer Details')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Customer Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Customer Details</li>
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
			<h5>Edit Customer Details</h5>
		  </div>
          <form action="{{ route('update-customer', $newcustomers->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" value="{{ $newcustomers->name }}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="email" name="email" value="{{ $newcustomers->email }}" >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="phone" value="{{ $newcustomers->phone }}" >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">WhatsApp Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="whatsapp_number" value="{{ $newcustomers->whatsapp_number }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">NIC</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nic" value="{{ $newcustomers->nic }}" >
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Job</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="job" value="{{ $newcustomers->job }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Location</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="address" value="{{ $newcustomers->address }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('new-customer') }}" class="btn btn-light">Cancel</a>
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
