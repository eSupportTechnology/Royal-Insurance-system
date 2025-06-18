@extends('AdminDashboard.master')
@section('title', 'Edit Profit Margin')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Profit Margin</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Edit Profit Margin</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Edit Profit Margin Details</h5>
                    </div>
                    <form action="{{ route('profitMargin.update', $profitMargin->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <!-- Select Company -->
                                    <div class="mb-3">
                                        <label for="company_id" class="form-label">Select Company</label>
                                        <div class="position-relative">
                                            <select name="company_id" class="form-control mb-5" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id', $profitMargin->company_id) == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Select Insurance Type -->
                                    <div class="mb-3">
                                        <label for="insurance_type_id" class="form-label">Select Insurance Type</label>
                                        <div class="position-relative">
                                            <select name="insurance_type_id" id="insurance_type_id" class="form-control"
                                                required style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $insuranceType)
                                                    <option value="{{ $insuranceType->id }}"
                                                        {{ old('insurance_type_id', $profitMargin->insurance_type_id) == $insuranceType->id ? 'selected' : '' }}>
                                                        {{ $insuranceType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Select Category -->
                                    <div class="mb-3" id="category_wrapper">
                                        <label for="category_id" class="form-label">Select Category</label>
                                        <div class="position-relative">
                                            <select name="category_id" id="category_id" class="form-control"
                                                data-selected="{{ old('category_id', $profitMargin->category_id) }}"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Category</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Select Subcategory -->
                                    <div class="mb-3" id="subcategory_wrapper">
                                        <label for="sub_category_id" class="form-label">Select Sub Category</label>
                                        <div class="position-relative">
                                            <select name="sub_category_id" id="sub_category_id" class="form-control"
                                                data-selected="{{ old('sub_category_id', $profitMargin->sub_category_id) }}"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Sub Category</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Select Form Field -->
                                    <div class="mb-3" id="formfield_wrapper">
                                        <label for="form_field_id" class="form-label">Select Variety Fields</label>
                                        <div class="position-relative">
                                            <select name="form_field_id" id="form_field_id" class="form-control"
                                                data-selected="{{ old('form_field_id', $profitMargin->form_field_id) }}"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Variety Fields</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Select Profit Type -->
                                    <div class="mb-3">
                                        <label for="profit_type" class="form-label">Select Profit Type</label>
                                        <div class="position-relative">
                                            <select name="profit_type" id="profit_type" class="form-control" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Type</option>
                                                <option value="RCC"
                                                    {{ old('profit_type', $profitMargin->profit_type) == 'RCC' ? 'selected' : '' }}>
                                                    SRCC Premium</option>
                                                <option value="TC"
                                                    {{ old('profit_type', $profitMargin->profit_type) == 'TC' ? 'selected' : '' }}>
                                                    TC Premium</option>
                                                <option value="Net Premium"
                                                    {{ old('profit_type', $profitMargin->profit_type) == 'Net Premium' ? 'selected' : '' }}>
                                                    Net Premium</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Input Fields -->
                                    <div class="dt-ext table-responsive">
                                        <table class="table table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>RIB</th>
                                                    <th class="text-center">Main Agent</th>
                                                    <th class="text-center">Sub Agent</th>
                                                </tr>
                                            </thead>
                                            <tbody id="formFields">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="total" class="form-control"
                                                            value="{{ old('total', $profitMargin->total) }}"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="rib" class="form-control"
                                                            value="{{ old('rib', $profitMargin->rib) }}"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="main_agent" class="form-control"
                                                            value="{{ old('main_agent', $profitMargin->main_agent) }}"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="sub_agent" class="form-control"
                                                            value="{{ old('sub_agent', $profitMargin->sub_agent) }}"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('profitMargin.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    const insuranceData = @json($insurance_types);

    document.addEventListener('DOMContentLoaded', function() {
        const insuranceSelect = document.getElementById('insurance_type_id');
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('sub_category_id');
        const formfieldSelect = document.getElementById('form_field_id');

        const categoryWrapper = document.getElementById('category_wrapper');
        const subcategoryWrapper = document.getElementById('subcategory_wrapper');
        const formfieldWrapper = document.getElementById('formfield_wrapper');

        categoryWrapper.style.display = 'none';
        subcategoryWrapper.style.display = 'none';
        formfieldWrapper.style.display = 'none';

        const selectedInsuranceId = parseInt(insuranceSelect.value);
        if (selectedInsuranceId) {
            loadCategories(selectedInsuranceId);
        }

        insuranceSelect.addEventListener('change', function() {
            const selectedId = parseInt(this.value);
            loadCategories(selectedId);
        });

        categorySelect.addEventListener('change', function() {
            loadSubcategories(parseInt(insuranceSelect.value), parseInt(this.value));
        });

        subcategorySelect.addEventListener('change', function() {
            loadFormFields(parseInt(insuranceSelect.value), parseInt(categorySelect.value), parseInt(
                this.value));
        });

        function loadCategories(insuranceId) {
            const selected = categorySelect.dataset.selected;
            categorySelect.innerHTML = '<option value="">Select Category</option>';
            subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';

            categoryWrapper.style.display = 'none';
            subcategoryWrapper.style.display = 'none';
            formfieldWrapper.style.display = 'none';

            const insurance = insuranceData.find(i => i.id === insuranceId);
            if (insurance?.categories?.length > 0) {
                insurance.categories.forEach(cat => {
                    categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
                });
                categoryWrapper.style.display = 'block';
                if (selected) categorySelect.value = selected;
                categorySelect.dispatchEvent(new Event('change'));
            }
        }

        function loadSubcategories(insuranceId, categoryId) {
            const selected = subcategorySelect.dataset.selected;
            subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';

            subcategoryWrapper.style.display = 'none';
            formfieldWrapper.style.display = 'none';

            const insurance = insuranceData.find(i => i.id === insuranceId);
            const category = insurance?.categories?.find(c => c.id === categoryId);
            if (category?.subcategories?.length > 0) {
                category.subcategories.forEach(sub => {
                    subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
                subcategoryWrapper.style.display = 'block';
                if (selected) subcategorySelect.value = selected;
                subcategorySelect.dispatchEvent(new Event('change'));
            }
        }

        function loadFormFields(insuranceId, categoryId, subcategoryId) {
            const selected = formfieldSelect.dataset.selected;
            formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';
            formfieldWrapper.style.display = 'none';

            const insurance = insuranceData.find(i => i.id === insuranceId);
            const category = insurance?.categories?.find(c => c.id === categoryId);
            const subcategory = category?.subcategories?.find(s => s.id === subcategoryId);

            if (subcategory?.form_fields?.length > 0) {
                subcategory.form_fields.forEach(field => {
                    formfieldSelect.innerHTML +=
                        `<option value="${field.id}">${field.field_name}</option>`;
                });
                formfieldWrapper.style.display = 'block';
                if (selected) formfieldSelect.value = selected;
            }
        }
    });
</script>

@section('script')
@endsection
