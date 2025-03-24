@extends('AdminDashboard.master')
@section('title', 'Create Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Insurance Category</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
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

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Add Category Details</h5>
                </div>
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Insurance Type -->
                            <div class="col-md-12">
                                <div class="mb-3 row">
                                    <label class="col-md-3 col-form-label ">Insurance Type</label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="insurance_type_id" id="insurance_type_id" required>
                                            <option value="">Select Insurance Type</option>
                                            @foreach($insurance_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Insurance Category -->
                            <div class="col-md-12">
                                <div class="mb-3 row">
                                    <label class="col-md-3 col-form-label">Insurance Category</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Insurance Category" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form Footer -->
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
