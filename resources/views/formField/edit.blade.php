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
                    <div class="card-header">
                        <h5>Edit Form Field</h5>
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

                        <form action="{{ route('formField.update', $formField->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="field_name" class="form-label">Field Name</label>
                                <input type="text" name="field_name" class="form-control" value="{{ old('field_name', $formField->field_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="field_type" class="form-label">Field Type</label>
                                <select name="field_type" class="form-control" id="field_type" required>
                                    <option value="text" {{ $formField->field_type == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="textarea" {{ $formField->field_type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                    <option value="select" {{ $formField->field_type == 'select' ? 'selected' : '' }}>Select</option>
                                    <option value="checkbox" {{ $formField->field_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                    <option value="radio" {{ $formField->field_type == 'radio' ? 'selected' : '' }}>Radio</option>
                                </select>
                            </div>

                            <div class="mb-3" id="optionsDiv" style="display: {{ in_array($formField->field_type, ['select', 'checkbox', 'radio']) ? 'block' : 'none' }};">
                                <label for="field_options" class="form-label">Field Options (Comma Separated)</label>
                                <input type="text" name="field_options" id="field_options" class="form-control" value="{{ is_array($formFieldOptions) ? implode(', ', $formFieldOptions) : $formFieldOptions }}">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="required" class="form-check-input" id="required" {{ $formField->required ? 'checked' : '' }}>
                                <label class="form-check-label" for="required">Required</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Form Field</button>
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
            const fieldOptions = document.getElementById('field_options');

            function toggleOptionsDiv() {
                if (['select', 'checkbox', 'radio'].includes(fieldTypeSelect.value)) {
                    optionsDiv.style.display = 'block';
                } else {
                    optionsDiv.style.display = 'none';
                    fieldOptions.value = '';
                }
            }

            // Initial display check
            toggleOptionsDiv();

            // Listen for changes in the field type dropdown
            fieldTypeSelect.addEventListener('change', toggleOptionsDiv);
        });
    </script>
@endsection