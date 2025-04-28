@extends('AdminDashboard.master')
@section('title', 'Edit Form Field')

@section('breadcrumb-title')
    <h3>Edit Form Field</h3>
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

                        <div class="accordion" id="accordionForms">
                            @forelse ($groupedFormFields as $insuranceType => $categories)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="true">
                                            {{ $insuranceType }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            @foreach ($categories as $category => $subCategories)
                                                <div class="mb-3">
                                                    <h5>{{ $category }}</h5>
                                                    @foreach ($subCategories as $subCategory => $formFields)
                                                        <div class="card mb-3">
                                                            <div class="card-header d-flex justify-content-between">
                                                                <strong>{{ $subCategory ?? 'General' }}</strong>
                                                                <a href="{{ route('formField.addNew', [
                                                                    'insurance_type_id' => $formFields->first()->insurance_type_id ?? null,
                                                                    'category_id' => $formFields->first()->category_id ?? null,
                                                                    'sub_category_id' => $formFields->first()->sub_category_id ?? null
                                                                ]) }}" class="btn btn-sm btn-success">Add New Field</a>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Field Name</th>
                                                                            <th>Field Type</th>
                                                                            <th>Required</th>
                                                                            <th>Options</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($formFields as $formField)
                                                                            <tr>
                                                                                <td>{{ $formField->field_name }}</td>
                                                                                <td>{{ ucfirst($formField->field_type) }}</td>
                                                                                <td>{{ $formField->required ? 'Yes' : 'No' }}</td>
                                                                                <td>{{ $formField->field_options }}</td>
                                                                                <td>
                                                                                    <a href="{{ route('formField.edit', $formField->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                                    <form action="{{ route('formField.delete', $formField->id) }}" method="POST" style="display:inline-block;">
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
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">No Form Fields Found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
