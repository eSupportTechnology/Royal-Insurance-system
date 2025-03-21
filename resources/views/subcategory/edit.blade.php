@extends('AdminDashboard.master')
@section('title', 'Edit Insurance Sub-Category')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Insurance Sub-Category</h5>
                    </div>
                    <form action="{{ route('subcategories.update', $subcategories->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Insurance Type Dropdown -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Insurance Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="insurance_type" name="insurance_type_id" required>
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ old('insurance_type_id', $subcategories->insurance_type_id) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Insurance Category Dropdown -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Insurance Category</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="category" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $subcategories->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Insurance Sub-Category Input -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Sub-Category Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" value="{{ $subcategories->name }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('subcategories.index') }}" class="btn btn-light">Cancel</a>
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
        var categories = @json($categories); // Get all categories

        function updateCategories(insuranceTypeId, selectedCategoryId = null) {
            $('#category').empty().append('<option value="">Select Category</option>');

            categories.forEach(function (category) {
                if (category.insurance_type_id == insuranceTypeId) {
                    let isSelected = selectedCategoryId == category.id ? 'selected' : '';
                    $('#category').append('<option value="' + category.id + '" ' + isSelected + '>' + category.name + '</option>');
                }
            });
        }

        // When Insurance Type is changed
        $('#insurance_type').change(function () {
            updateCategories($(this).val());
        });

        // On page load, filter categories based on selected insurance type
        var initialInsuranceType = $('#insurance_type').val();
        var selectedCategory = "{{ old('category_id', $subcategories->category_id) }}";
        updateCategories(initialInsuranceType, selectedCategory);
    });
</script>
@endsection
