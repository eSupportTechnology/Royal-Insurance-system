@extends('AdminDashboard.master')
@section('title', 'Create Sub Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Insurance Form Field</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if (session('success'))
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
                        <h5>Add Details</h5>
                    </div>

                    <form action="{{ route('formField.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <!-- Insurance Type Dropdown -->
                            <div class="mb-3 col-6">
                                <select class="form-select" name="insurance_type_id" id="insurance_type_id" required>
                                    <option value="">Select Insurance Type</option>
                                    @foreach ($insurance_types as $insurance_type)
                                        <option value="{{ $insurance_type->id }}">{{ $insurance_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Insurance Category Dropdown -->
                            <div class="mb-3 col-6">
                                <select class="form-select" name="category_id" id="category_id" required>
                                    <option value="">Select Insurance Category</option>
                                </select>
                            </div>

                            <!-- Insurance Sub-Category Dropdown -->
                            <div class="mb-3 col-6">
                                <select class="form-select" name="sub_category_id" id="sub_category_id">
                                    <option value="">Select Insurance Sub Category (Optional)</option>
                                </select>
                            </div>

                            <div class="dt-ext table-responsive">
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Field Name</th>
                                            <th>Field Type</th>
                                            <th class="text-center">Required</th>
                                            <th class="text-center">Options</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="formFields">
                                        <tr>
                                            <td>
                                                <input type="text" name="field_name[]" class="form-control" placeholder="Enter field name" required />
                                            </td>
                                            <td>
                                                <select name="field_type[]" class="form-control" required>
                                                    <option value="text">Text</option>
                                                    <option value="select">Dropdown</option>
                                                    <option value="number">Number</option>
                                                    <option value="checkbox">Checkbox</option>
                                                    <option value="file">File Upload</option>
                                                    <option value="date">Date</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="required[]" value="1" class="form-check-input" />
                                            </td>
                                            <td class="text-center">
                                                <input type="text" name="field_options[]" class="form-control" placeholder="Enter options (comma-separated)" />
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
                                    <button type="button" id="addRow" class="btn btn-success">
                                        + Add Field
                                    </button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var categories = @json($categories);
            var subcategories = @json($subcategories);

            // Update categories based on selected insurance type
            function updateCategories(insuranceTypeId) {
                $('#category_id').empty().append('<option value="">Select Insurance Category</option>');
                $('#sub_category_id').empty().append('<option value="">Select Insurance Sub Category</option>');

                categories.forEach(function (category) {
                    if (category.insurance_type_id == insuranceTypeId) {
                        $('#category_id').append('<option value="' + category.id + '">' + category.name + '</option>');
                    }
                });
            }

            // Update subcategories based on selected category
            function updateSubCategories(categoryId) {
                $('#sub_category_id').empty().append('<option value="">Select Insurance Sub Category</option>');

                subcategories.forEach(function (subcategory) {
                    if (subcategory.category_id == categoryId) {
                        $('#sub_category_id').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    }
                });
            }

            // On change, update category dropdown
            $('#insurance_type_id').change(function () {
                var selectedType = $(this).val();
                updateCategories(selectedType);
            });

            // On change, update subcategory dropdown
            $('#category_id').change(function () {
                var selectedCategory = $(this).val();
                updateSubCategories(selectedCategory);
            });
        });

        // Add new form row dynamically
        document.addEventListener("DOMContentLoaded", function () {
            const formFields = document.getElementById("formFields");
            const addRowButton = document.getElementById("addRow");

            // Function to add new row
            addRowButton.addEventListener("click", function () {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td><input type="text" name="field_name[]" class="form-control" placeholder="Enter field name" required></td>
                    <td>
                        <select name="field_type[]" class="form-control" required>
                            <option value="text">Text</option>
                            <option value="select">Dropdown</option>
                            <option value="number">Number</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="file">File Upload</option>
                            <option value="date">Date</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" name="required[]" value="1" class="form-check-input">
                    </td>
                    <td class="text-center">
                        <input type="text" name="field_options[]" class="form-control" placeholder="Enter options (comma-separated)">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger remove-row">X</button>
                    </td>
                `;
                formFields.appendChild(newRow);
            });

            // Remove row on click
            formFields.addEventListener("click", function (event) {
                if (event.target.classList.contains("remove-row")) {
                    event.target.closest("tr").remove();
                }
            });
        });
    </script>
@endsection
