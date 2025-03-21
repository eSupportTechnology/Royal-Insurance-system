@extends('AdminDashboard.master')
@section('title', 'Create Insurance Sub-Category')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Create Insurance Sub-Category</h5>
                    </div>
                    <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Insurance Sub-Category Input -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Sub-Category Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Save</button>
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
        var categories = @json($categories); // Get categories from Laravel

        function updateCategories(insuranceTypeId) {
            $('#category').empty().append('<option value="">Select Category</option>');

            categories.forEach(function (category) {
                if (category.insurance_type_id == insuranceTypeId) {
                    $('#category').append('<option value="' + category.id + '">' + category.name + '</option>');
                }
            });
        }

        // When Insurance Type is selected, update categories
        $('#insurance_type').change(function () {
            var selectedType = $(this).val();
            updateCategories(selectedType);
        });
    });
</script>
@endsection
