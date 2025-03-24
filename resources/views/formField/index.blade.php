@extends('AdminDashboard.master')
@section('title', 'Form Fields')

@section('breadcrumb-title')
    <h3>Form Fields</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Forms Overview</h5>
                        <a href="{{ route('formField.create') }}" class="btn btn-primary">Create New Form</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Insurance Type</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($forms as $groupKey => $formGroup)
                                        @php
                                            $firstField = $formGroup->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $firstField->insuranceType->name ?? 'N/A' }}</td>
                                            <td>{{ $firstField->category->name ?? 'N/A' }}</td>
                                            <td>{{ $firstField->subCategory->name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('formField.show', $groupKey) }}" class="btn btn-info btn-sm">See More</a>
                                                <form action="{{ route('formField.delete', $groupKey) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this form?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Forms Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
