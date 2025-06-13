@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Profit Margin</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">New Profit Margin</li>
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
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Add Profit Margin Details</h5>

                    </div>
                    <form action="{{ route('profitMargin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
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
                                                    <option value="{{ $insuranceType->id }}">{{ $insuranceType->name }}
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
                                        <label for="form_field_id" class="form-label">Select Form Field</label>
                                        <div class="position-relative">
                                            <select name="form_field_id" id="form_field_id" class="form-control"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Form Field</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>


                                    {{-- select item --}}
                                    <div class="mb-3">
                                        <label for="profit_type" class="form-label">Select Profit Type</label>
                                        <div class="position-relative">
                                            <select name="profit_type" id="profit_type" class="form-control" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Type</option>
                                                <option value="RCC">SRCC</option>
                                                <option value="TC">TC</option>
                                                <option value="Net Premium">Net Premium</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                                ▼
                                            </span>
                                        </div>
                                    </div>

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
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="rib" class="form-control"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="main_agent" class="form-control"
                                                            placeholder="Enter the value" required />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="sub_agent" class="form-control"
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
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a href="{{ route('profitMargin.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

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

            // Initially hide dependent sections
            categoryWrapper.style.display = 'none';
            subcategoryWrapper.style.display = 'none';
            formfieldWrapper.style.display = 'none';

            insuranceSelect.addEventListener('change', function() {
                const selectedInsuranceId = parseInt(this.value);

                categorySelect.innerHTML = '<option value="">Select Category</option>';
                subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';

                categoryWrapper.style.display = 'none';
                subcategoryWrapper.style.display = 'none';
                formfieldWrapper.style.display = 'none';

                const selectedInsurance = insuranceData.find(ins => ins.id === selectedInsuranceId);

                if (selectedInsurance && selectedInsurance.categories.length > 0) {
                    selectedInsurance.categories.forEach(cat => {
                        categorySelect.innerHTML +=
                        `<option value="${cat.id}">${cat.name}</option>`;
                    });
                    categoryWrapper.style.display = 'block';
                }
            });

            categorySelect.addEventListener('change', function() {
                const selectedInsuranceId = parseInt(insuranceSelect.value);
                const selectedCategoryId = parseInt(this.value);

                subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';

                subcategoryWrapper.style.display = 'none';
                formfieldWrapper.style.display = 'none';

                const selectedInsurance = insuranceData.find(ins => ins.id === selectedInsuranceId);
                const selectedCategory = selectedInsurance?.categories.find(cat => cat.id ===
                    selectedCategoryId);

                if (selectedCategory && selectedCategory.subcategories.length > 0) {
                    selectedCategory.subcategories.forEach(sub => {
                        subcategorySelect.innerHTML +=
                            `<option value="${sub.id}">${sub.name}</option>`;
                    });
                    subcategoryWrapper.style.display = 'block';
                }
            });

            subcategorySelect.addEventListener('change', function() {
                const selectedInsuranceId = parseInt(insuranceSelect.value);
                const selectedCategoryId = parseInt(categorySelect.value);
                const selectedSubCategoryId = parseInt(subcategorySelect.value);

                formfieldSelect.innerHTML = '<option value="">Select Form Field</option>';
                formfieldWrapper.style.display = 'none';

                const selectedInsurance = insuranceData.find(ins => ins.id === selectedInsuranceId);
                const selectedCategory = selectedInsurance?.categories.find(cat => cat.id ===
                    selectedCategoryId);
                const selectedSubCategory = selectedCategory?.subcategories.find(sub => sub.id ===
                    selectedSubCategoryId);

                if (selectedSubCategory && selectedSubCategory.form_fields.length > 0) {
                    selectedSubCategory.form_fields.forEach(field => {
                        formfieldSelect.innerHTML +=
                            `<option value="${field.id}">${field.field_name}</option>`;
                    });
                    formfieldWrapper.style.display = 'block';
                }
            });
        });
    </script>





@endsection

@section('script')

@endsection
