@extends('AdminDashboard.master')
@section('title', 'Edit Agent')

@section('breadcrumb-title')
    <h3>Edit Agent</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Agent</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('agents.update', $agent->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $agent->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $agent->email }}">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $agent->phone }}">
                            </div>

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ $agent->company_name }}">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control">{{ $agent->address }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Agent</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection