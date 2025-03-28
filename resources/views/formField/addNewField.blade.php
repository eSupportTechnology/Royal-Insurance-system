@extends('AdminDashboard.master')
@section('title', 'Add New Form Field')

@section('breadcrumb-title')
    <h3>Add New Form Field</h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Field</h5>
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
                    <form action="{{ route('formField.storeNew') }}" method="POST">
                        @csrf
                        <input type="hidden" name="insurance_type_id" value="{{ $insuranceTypeId }}">
                        <input type="hidden" name="category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="sub_category_id" value="{{ $subCategoryId }}">

                        <div class="mb-3">
                            <label for="field_name" class="form-label">Field Name</label>
                            <input type="text" name="field_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="field_type" class="form-label">Field Type</label>
                            <select name="field_type" class="form-control" id="field_type" required>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Select</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="file">File</option>
                            </select>
                        </div>

                        <div class="mb-3" id="optionsDiv" style="display:none;">
                            <label for="field_options" class="form-label">Options (Comma separated)</label>
                            <input type="text" name="field_options" class="form-control">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="required" class="form-check-input" id="required">
                            <label class="form-check-label" for="required">Required</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Field</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fieldTypeSelect = document.getElementById('field_type');
        const optionsDiv = document.getElementById('optionsDiv');

        fieldTypeSelect.addEventListener('change', function () {
            const fieldType = fieldTypeSelect.value;
            if (['select', 'checkbox', 'radio'].includes(fieldType)) {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection
