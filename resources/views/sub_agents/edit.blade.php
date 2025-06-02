@extends('AdminDashboard.master')
@section('title', 'Edit Sub_Agent')

@section('breadcrumb-title')
    <h3>Edit Sub Agent</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Sale Representative</h5>
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

                        <form action="{{ route('sub_agents.update', $subagent->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="agent_id" class="form-label">Sales Supervisor</label>
                                <select name="agent_id" class="form-control">
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_agent_name" class="form-label">Sales Representative Name</label>
                                <input type="text" name="sub_agent_name" class="form-control" value="{{ $subagent->sub_agent_name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $subagent->email }}">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $subagent->phone }}">
                            </div>

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ $subagent->company_name }}">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control">{{ $subagent->address }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Representative</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
