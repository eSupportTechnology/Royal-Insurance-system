@extends('AdminDashboard.master')
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
<li class="breadcrumb-item active">Insurance type</li>
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
          <form action="{{ route('insuranceType.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Type</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Insurance Type" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ route('insuranceType.index') }}" class="btn btn-light">Cancel</a>
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
