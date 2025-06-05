@extends('AdminDashboard.master')
@section('title', 'Agents')

@section('breadcrumb-title')
    <h3>Agents</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>All Agents List</h5>
                        <a href="{{ route('agents.create') }}" class="btn btn-primary">Add New Agent</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rep_code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agents as $agent)
                                    <tr>
                                        <td>{{ $agent->rep_code }}</td>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->phone }}</td>
                                        <td>{{ $agent->company_name }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
