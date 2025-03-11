@extends('AdminDashboard.master')
@section('title', 'Edit Sub Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Edit Insurance Form Field</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
<br>
        <div class="card">
            <div class="card-header">
                <h5>Edit Details</h5>
            </div>

            <form action="{{ route('formField.update', $formField->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                <div class="col-sm-6">
                    <select class="form-select" name="sub_category_id" id="sub_category_id" required>
                        <option value="">Select Insurance Sub Category</option>
                        @foreach($subcategories as $category)
                            <option value="{{$category->id }}" {{ $formField->sub_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="dt-ext table-responsive">
                    <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Field Name</th>
                            <th>Field Type</th>
                            <th>Required</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="formFields">
                        <tr>
                            <td>
                                <input type="text" name="field_name" value="{{ $formField->field_name }}" class="form-control" required />
                            </td>
                            <td>
                                <select name="field_type" class="form-control">
                                    <option value="text" {{ $formField->field_type == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="number" {{ $formField->field_type == 'number' ? 'selected' : '' }}>Number</option>
                                    <option value="password" {{ $formField->field_type == 'password' ? 'selected' : '' }}>Password</option>
                                    <option value="email" {{ $formField->field_type == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="tel" {{ $formField->field_type == 'tel' ? 'selected' : '' }}>Phone</option>
                                    <option value="date" {{ $formField->field_type == 'date' ? 'selected' : '' }}>Date</option>
                                    <option value="time" {{ $formField->field_type == 'time' ? 'selected' : '' }}>Time</option>
                                    <option value="datetime-local" {{ $formField->field_type == 'datetime-local' ? 'selected' : '' }}>Date & Time</option>
                                    <option value="month" {{ $formField->field_type == 'month' ? 'selected' : '' }}>Month</option>
                                    <option value="week" {{ $formField->field_type == 'week' ? 'selected' : '' }}>Week</option>
                                    <option value="url" {{ $formField->field_type == 'url' ? 'selected' : '' }}>URL</option>
                                    <option value="hidden" {{ $formField->field_type == 'hidden' ? 'selected' : '' }}>Hidden</option>
                                    <option value="select" {{ $formField->field_type == 'select' ? 'selected' : '' }}>Dropdown</option>
                                    <option value="checkbox" {{ $formField->field_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                    <option value="radio" {{ $formField->field_type == 'radio' ? 'selected' : '' }}>Radio</option>
                                    <option value="file" {{ $formField->field_type == 'file' ? 'selected' : '' }}>File Upload</option>
                                    <option value="color" {{ $formField->field_type == 'color' ? 'selected' : '' }}>Color Picker</option>
                                    <option value="range" {{ $formField->field_type == 'range' ? 'selected' : '' }}>Range Slider</option>
                                    <option value="search" {{ $formField->field_type == 'search' ? 'selected' : '' }}>Search Box</option>
                                    <option value="textarea" {{ $formField->field_type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="required" value="1" {{ $formField->required ? 'checked' : '' }} />
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger remove-row">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('formField.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Remove row functionality
            document.getElementById("formFields").addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-row")) {
                    event.target.closest("tr").remove();
                }
            });
        });
    </script>
@endsection
