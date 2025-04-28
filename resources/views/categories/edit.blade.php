@extends('AdminDashboard.master')
@section('title', 'Edit Insurance Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Insurance Categery</li>
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
			<h5>Edit Details</h5>
		  </div>
          <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="insurance_type_id" required>
                                    @foreach ($insurance_types as $type)
                                        <option value="{{ $type->id }}" {{ $category->insurance_type_id == $type->id?'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Categery</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" value="{{ $category->name }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
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
