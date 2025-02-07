@extends('AdminDashboard.master')
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
          <form action="{{ route('company.update',$companies->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <select class="form-select digits" id="exampleFormControlSelect9" name="name" value="{{ $companies->name }}" required>
                                    <option {{ $companies->name == 'Sri Lanka Insurance Corporation - General' ? 'selected' : '' }}>Sri Lanka Insurance Corporation - General</option>
                                    <option {{ $companies->name == 'Ceylinco General Insurance' ? 'selected' : '' }}>Ceylinco General Insurance</option>
                                    <option {{ $companies->name == 'Orient Insurance' ? 'selected' : '' }}>Orient Insurance</option>
                                    <option {{ $companies->name == 'LOLC General Insurance' ? 'selected' : '' }}>LOLC General Insurance</option>
                                    <option {{ $companies->name == 'Co-Op General Insurance' ? 'selected' : '' }}>Co-Op General Insurance</option>
                                    <option {{ $companies->name == "Peoples' Insurance" ? 'selected' : '' }}>Peoples' Insurance</option>
                                    <option {{ $companies->name == 'Allianz General Insurance' ? 'selected' : '' }}>Allianz General Insurance</option>
                                    <option {{ $companies->name == 'Fair First Insurance' ? 'selected' : '' }}>Fair First Insurance</option>
                                </select>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <select class="form-select digits" id="exampleFormControlSelect9" name="email" value="{{ $companies->email }}" required>
                                    <option {{ $companies->email == 'nishanf@slicgeneral.com' ? 'selected' : '' }}>nishanf@slicgeneral.com</option>
                                    <option {{ $companies->email == 'zuharas@slicgeneral.com' ? 'selected' : '' }}>zuharas@slicgeneral.com</option>
                                    <option {{ $companies->email == 'pathumt@slicgeneral.com' ? 'selected' : '' }}>pathumt@slicgeneral.com</option>
                                    <option {{ $companies->email == 'lakshmipr@slicgeneral.com' ? 'selected' : '' }}>lakshmipr@slicgeneral.com</option>
                                    <option {{ $companies->email == 'indikap@ceyins.lk' ? 'selected' : '' }}>indikap@ceyins.lk</option>
                                    <option {{ $companies->email == 'brokerservicing@ceyins.lk' ? 'selected' : '' }}>brokerservicing@ceyins.lk</option>
                                    <option {{ $companies->email == 'banca3@ceyins.lk' ? 'selected' : '' }}>banca3@ceyins.lk</option>
                                    <option {{ $companies->email == 'banca5@ceyins.lk' ? 'selected' : '' }}>banca5@ceyins.lk</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contact</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="contact_number" value="{{ $companies->contact_number }}" placeholder="contact number" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Insurance Type</label>
                            <div class="col-sm-9">
                                <select class="form-select digits" id="exampleFormControlSelect9" name="insurance_type" value="{{ $companies->insurance_type }}" required>
                                    <option {{ $companies->insurance_type == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                    <option {{ $companies->insurance_type == 'Health' ? 'selected' : '' }}>Health</option>
                                    <option {{ $companies->insurance_type == 'Property' ? 'selected' : '' }}>Property</option>
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
