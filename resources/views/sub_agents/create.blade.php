@extends('AdminDashboard.master')
@section('title', 'Add Sub Agent')

@section('breadcrumb-title')
    <h3>Add Sub Agent</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add Sub Agent</h5>
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

                        <form action="{{ route('sub_agents.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="agent_id" class="form-label">Agent</label>
                                <select name="agent_id" class="form-control">
                                     <option value="">Select Agent</option>
                                    @foreach ($subagents as $subagent)
                                        <option value="{{ $subagent->id }}">{{ $subagent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_agent_name" class="form-label">Sub Agent</label>
                                <input type="text" name="sub_agent_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Sub Agent</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
