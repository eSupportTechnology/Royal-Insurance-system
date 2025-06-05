@extends('AdminDashboard.master')
@section('title', 'Sub_Agents')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
@endsection


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Sub Agents List</h5>
                        <a href="{{ route('sub_agents.create') }}" class="btn btn-primary">Add Sub Agent</a>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="export-button">
                                <thead>
                                    <tr>
                                        <th>Rep_code</th>
                                        <th>Sub_Agent</th>
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
                                                <td>{{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>{{ $subagent->sub_agent_name }}</td>
                                                <td>{{ $subagent->email }}</td>
                                                <td>{{ $subagent->phone }}</td>
                                                <td>{{ $subagent->company_name }}</td>
                                                <td class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('sub_agents.edit', $subagent->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('sub_agents.destroy', $subagent->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
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
    </div>
@endsection
