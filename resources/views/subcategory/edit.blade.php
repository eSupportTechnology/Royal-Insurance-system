@extends('AdminDashboard.master')
@section('title', 'Edit Insurance Sub Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Insurance Sub Categery</li>
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
          <form action="{{ route('subcategories.update', $subcategories->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $subcategories->category_id == $category->id?'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Insurance Sub Categery</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" value="{{ $subcategories->name }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-light">Cancel</a>
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
