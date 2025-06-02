@extends('AdminDashboard.master')
@section('title', 'Sub_Agents')

@section('breadcrumb-title')
    <h3>Sub Agents</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Representatives List</h5>
                        <a href="{{ route('sub_agents.create') }}" class="btn btn-primary">Add New Representative</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rep_code</th>
                                    <th>Representative_Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agentsWithSubagents as $agent)
                                {{-- @foreach ($subagents as $subagent) --}}
                                @foreach ($agent->subagents as $index => $subagent)
                                    <tr>
                                        <td>{{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $subagent->sub_agent_name }}</td>
                                        <td>{{ $subagent->email }}</td>
                                        <td>{{ $subagent->phone }}</td>
                                        <td>{{ $subagent->company_name }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('sub_agents.edit', $subagent->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('sub_agents.destroy', $subagent->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
