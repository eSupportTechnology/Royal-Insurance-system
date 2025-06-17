@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Edit Customer Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Edit Customer Insurance</li>
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
                        <h5>Edit Details</h5>
                    </div>
                    <form action="{{ route('customerinsurance.update', $customerinsurance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="inv" class="col-sm-3 col-form-label">RIB INV Number</label>
                                        <input type="text" name="inv" id="inv"
                                            value="{{ $customerinsurance->inv }}" class="form-control" required>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="date" class="col-sm-3 col-form-label">Date</label>
                                        <input type="date" name="date" id="date"
                                            value="{{ $customerinsurance->date }}" class="form-control" required>
                                    </div>

                                    @php
                                        $customerData = $customers->mapWithKeys(function ($customer) {
                                            return [
                                                $customer->id => [
                                                    'contact' => $customer->phone,
                                                    'whatsapp' => $customer->whatsapp_number,
                                                    'address' => $customer->address,
                                                ],
                                            ];
                                        });
                                    @endphp

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Select Customer</label>
                                        <div class="position-relative">
                                            <select name="name" id="customerSelect" class="form-control mb-5" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $customer->id == $customerinsurance->name ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="contact" class="col-sm-3 col-form-label">Contact Number</label>
                                        <input type="text" name="contact" id="contact" class="form-control"
                                            value="{{ $customerinsurance->contact }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="whatsapp" class="col-sm-3 col-form-label">Whatsapp Number</label>
                                        <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                            value="{{ $customerinsurance->whatsapp }}">
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <textarea name="address" id="address" rows="3" class="form-control">{{ $customerinsurance->address }}</textarea>
                                    </div>

                                    <!-- Policy -->
                                    <div class="mb-3 row">
                                        <label for="policy" class="col-sm-3 col-form-label">Policy</label>
                                        <input type="text" name="policy" id="policy" class="form-control"
                                            value="{{ old('policy', $customerinsurance->policy) }}">
                                    </div>

                                    <!-- D/N/INV Number -->
                                    <div class="mb-3 row">
                                        <label for="dn" class="col-sm-3 col-form-label">D/N/INV Number</label>
                                        <input type="text" name="dn" id="dn" class="form-control"
                                            value="{{ old('dn', $customerinsurance->dn) }}">
                                    </div>

                                    <!-- Vehicle/ChassiNo -->
                                    <div class="mb-3 row">
                                        <label for="vehicle" class="col-sm-3 col-form-label">Vehicle/ChassiNo</label>
                                        <input type="text" name="vehicle" id="vehicle" class="form-control"
                                            value="{{ old('vehicle', $customerinsurance->vehicle) }}">
                                    </div>

                                    <!-- Company -->
                                    <div class="mb-3">
                                        <label for="insurance_company" class="form-label">Select Company</label>
                                        <div class="position-relative">
                                            <select name="insurance_company" class="form-control mb-5" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ $customerinsurance->insurance_company == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Insurance Type -->
                                    <div class="mb-3">
                                        <label for="insurance_type" class="form-label">Select Insurance Type</label>
                                        <div class="position-relative">
                                            <select name="insurance_type" id="insurance_type" class="form-control"
                                                required>
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $insuranceType)
                                                    <option value="{{ $insuranceType->id }}"
                                                        {{ $customerinsurance->insurance_type == $insuranceType->id ? 'selected' : '' }}>
                                                        {{ $insuranceType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                   <!-- Category -->
                                    <div class="mb-3" id="category_wrapper" style="display: none;">
                                        <label for="category" class="form-label">Select Category</label>
                                        <div class="position-relative">
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select Category</option>
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Subcategory -->
                                    <div class="mb-3" id="subcategory_wrapper" style="display: none;">
                                        <label for="subcategory" class="form-label">Select Sub Category</label>
                                        <div class="position-relative">
                                            <select name="subcategory" id="subcategory" class="form-control">
                                                <option value="">Select Sub Category</option>
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Form Field -->
                                    <div class="mb-3" id="formfield_wrapper" style="display: none;">
                                        <label for="varietyfields" class="form-label">Select Variety Fields </label>
                                        <div class="position-relative">
                                            <select name="varietyfields" id="varietyfields" class="form-control">
                                                <option value="">Select Variety Fields</option>
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Basic Premium -->
                                    <div class="mb-3 row">
                                        <label for="basic" class="col-sm-3 col-form-label">Net Premium</label>
                                        <input type="number" step="0.01" name="basic" id="basic"
                                            class="form-control" value="{{ old('basic', $customerinsurance->basic) }}">
                                    </div>

                                    <!-- SRCC -->
                                    <div class="mb-3 row">
                                        <label for="srcc" class="col-sm-3 col-form-label">SRCC Premium</label>
                                        <input type="number" step="0.01" name="srcc" id="srcc"
                                            class="form-control" value="{{ old('srcc', $customerinsurance->srcc) }}">
                                    </div>

                                    <!-- TC -->
                                    <div class="mb-3 row">
                                        <label for="tc" class="col-sm-3 col-form-label">TC Premium</label>
                                        <input type="number" step="0.01" name="tc" id="tc"
                                            class="form-control" value="{{ old('tc', $customerinsurance->tc) }}">
                                    </div>

                                    <!-- Others -->
                                    <div class="mb-3 row">
                                        <label for="others" class="col-sm-3 col-form-label">Others</label>
                                        <input type="number" step="0.01" name="others" id="others"
                                            class="form-control" value="{{ old('others', $customerinsurance->others) }}">
                                    </div>

                                    <!-- Total -->
                                    <div class="mb-3 row">
                                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                                        <input type="number" step="0.01" name="total" id="total"
                                            class="form-control" value="{{ old('total', $customerinsurance->total) }}">
                                    </div>

                                    <!-- Sum Insured -->
                                    <div class="mb-3 row">
                                        <label for="sum_insured" class="col-sm-3 col-form-label">Sum Insured</label>
                                        <input type="number" step="0.01" name="sum_insured" id="sum_insured"
                                            class="form-control"
                                            value="{{ old('sum_insured', $customerinsurance->sum_insured) }}">
                                    </div>

                                    <!-- From Date -->
                                    <div class="mb-3 row">
                                        <label for="from_date" class="col-sm-3 col-form-label">Commencement Date</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control"
                                            value="{{ old('from_date', $customerinsurance->from_date) }}">
                                    </div>

                                    <!-- To Date -->
                                    <div class="mb-3 row">
                                        <label for="to_date" class="col-sm-3 col-form-label">Expiry Date</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control"
                                            value="{{ old('to_date', $customerinsurance->to_date) }}">
                                    </div>

                                    <!-- Introducer Code (Agent) -->
                                    <div class="mb-3 row">
                                        <label for="introducer_code" class="col-sm-3 col-form-label">Agent Code</label>
                                        <div class="position-relative">
                                            <select name="introducer_code" id="introducer_code" class="form-control"
                                                required>
                                                <option value="">Select Agent Rep_code</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}"
                                                        {{ $agent->id == $customerinsurance->introducer_code ? 'selected' : '' }}>
                                                        {{ $agent->rep_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Subagent Code -->
                                    <div class="mb-3 row">
                                        <label for="subagent_code" class="col-sm-3 col-form-label">Sub Agent Code</label>
                                        <div class="position-relative">
                                            <select name="subagent_code" id="subagent_code" class="form-control">
                                                <option value="">Select SubAgent Rep_code</option>
                                                @foreach ($agentsWithSubagents as $agent)
                                                    @foreach ($agent->subagents as $index => $subagent)
                                                        @php
                                                            $subCode =
                                                                $agent->rep_code .
                                                                '/' .
                                                                str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                                                        @endphp
                                                        <option value="{{ $subCode }}"
                                                            {{ $customerinsurance->subagent_code == $subCode ? 'selected' : '' }}>
                                                            {{ $subCode }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    <!-- Premium Type -->
                                    <div class="mb-3 row">
                                        <label for="premium_type" class="col-sm-3 col-form-label">Premium Type</label>
                                        <div class="position-relative">
                                            <select name="premium_type" id="premium_type" class="form-control" required>
                                                <option value="">Select Premium Type</option>
                                                <option value="Cash"
                                                    {{ $customerinsurance->premium_type == 'Cash' ? 'selected' : '' }}>Cash
                                                </option>
                                                <option value="Debit"
                                                    {{ $customerinsurance->premium_type == 'Debit' ? 'selected' : '' }}>
                                                    Debit</option>
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Customer data handling
        const customerData = @json($customerData);

        document.getElementById('customerSelect').addEventListener('change', function() {
            const selectedId = this.value;
            if (customerData[selectedId]) {
                document.getElementById('contact').value = customerData[selectedId].contact ?? '';
                document.getElementById('whatsapp').value = customerData[selectedId].whatsapp ?? '';
                document.getElementById('address').value = customerData[selectedId].address ?? '';
            } else {
                document.getElementById('contact').value = '';
                document.getElementById('whatsapp').value = '';
                document.getElementById('address').value = '';
            }
        });

        // Insurance cascade handling
        const insuranceData = @json($insurance_types);

        // Get current selected values for edit mode - Fixed variable declarations
        const currentInsuranceType = {{ $customerinsurance->insurance_type ?? 'null' }};
        const currentCategory = {{ $customerinsurance->category ?? 'null' }};
        const currentSubcategory = {{ $customerinsurance->subcategory ?? 'null' }};
        const currentFormField = {{ $customerinsurance->varietyfields ?? 'null' }};

        console.log('Current values:', {
            insuranceType: currentInsuranceType,
            category: currentCategory,
            subcategory: currentSubcategory,
            formField: currentFormField
        });

        document.addEventListener('DOMContentLoaded', function() {
            const insuranceSelect = document.getElementById('insurance_type');
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const formfieldSelect = document.getElementById('varietyfields');

            const categoryWrapper = document.getElementById('category_wrapper');
            const subcategoryWrapper = document.getElementById('subcategory_wrapper');
            const formfieldWrapper = document.getElementById('formfield_wrapper');

            function populateSelect(select, items, selectedValue, valueKey = 'id', textKey = 'name') {
                select.innerHTML = '<option value="">Select ' + select.getAttribute('data-placeholder') + '</option>';
                if (items && items.length > 0) {
                    items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item[valueKey];
                        option.textContent = item[textKey];
                        if (selectedValue && item[valueKey] == selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                }
            }

            function loadCategories(selectedInsuranceId, preloadCategory = null) {
                categoryWrapper.style.display = 'none';
                subcategoryWrapper.style.display = 'none';
                formfieldWrapper.style.display = 'none';

                categorySelect.innerHTML = '<option value="">Select Category</option>';
                subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                formfieldSelect.innerHTML = '<option value="">Select Variety Fields</option>';

                if (!selectedInsuranceId) return;

                const insurance = insuranceData.find(ins => ins.id == selectedInsuranceId);
                if (insurance && insurance.categories && insurance.categories.length > 0) {
                    populateSelect(categorySelect, insurance.categories, preloadCategory);
                    categoryWrapper.style.display = 'block';

                    // If we have a preloaded category, load its subcategories
                    if (preloadCategory) {
                        loadSubcategories(selectedInsuranceId, preloadCategory, currentSubcategory);
                    }
                }
            }

            function loadSubcategories(selectedInsuranceId, selectedCategoryId, preloadSubcategory = null) {
                subcategoryWrapper.style.display = 'none';
                formfieldWrapper.style.display = 'none';

                subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                formfieldSelect.innerHTML = '<option value="">Select Variety Fields</option>';

                if (!selectedInsuranceId || !selectedCategoryId) return;

                const insurance = insuranceData.find(ins => ins.id == selectedInsuranceId);
                if (insurance && insurance.categories) {
                    const category = insurance.categories.find(cat => cat.id == selectedCategoryId);
                    if (category && category.subcategories && category.subcategories.length > 0) {
                        populateSelect(subcategorySelect, category.subcategories, preloadSubcategory);
                        subcategoryWrapper.style.display = 'block';

                        // If we have a preloaded subcategory, load its form fields
                        if (preloadSubcategory) {
                            loadFormFields(selectedInsuranceId, selectedCategoryId, preloadSubcategory, currentFormField);
                        }
                    }
                }
            }

            function loadFormFields(selectedInsuranceId, selectedCategoryId, selectedSubcategoryId, preloadFormField = null) {
                formfieldWrapper.style.display = 'none';
                formfieldSelect.innerHTML = '<option value="">Select Variety Fields</option>';

                if (!selectedInsuranceId || !selectedCategoryId || !selectedSubcategoryId) return;

                const insurance = insuranceData.find(ins => ins.id == selectedInsuranceId);
                if (insurance && insurance.categories) {
                    const category = insurance.categories.find(cat => cat.id == selectedCategoryId);
                    if (category && category.subcategories) {
                        const subcategory = category.subcategories.find(sub => sub.id == selectedSubcategoryId);
                        if (subcategory && subcategory.form_fields && subcategory.form_fields.length > 0) {
                            populateSelect(formfieldSelect, subcategory.form_fields, preloadFormField, 'id', 'field_name');
                            formfieldWrapper.style.display = 'block';
                        }
                    }
                }
            }

            // Event listeners for user interactions
            insuranceSelect.addEventListener('change', function() {
                loadCategories(this.value);
            });

            categorySelect.addEventListener('change', function() {
                const insuranceId = insuranceSelect.value;
                loadSubcategories(insuranceId, this.value);
            });

            subcategorySelect.addEventListener('change', function() {
                const insuranceId = insuranceSelect.value;
                const categoryId = categorySelect.value;
                loadFormFields(insuranceId, categoryId, this.value);
            });

            // Initialize with existing data for edit mode
            if (currentInsuranceType && currentInsuranceType !== null) {
                console.log('Loading existing data for insurance type:', currentInsuranceType);
                loadCategories(currentInsuranceType, currentCategory);
            }
        });

        // Agent and subagent handling
        const agentsWithSubagents = @json($agentsWithSubagents);

        document.addEventListener('DOMContentLoaded', function() {
            const agentSelect = document.getElementById('introducer_code');
            const subagentSelect = document.getElementById('subagent_code');

            agentSelect.addEventListener('change', function() {
                const agentId = parseInt(this.value);
                subagentSelect.innerHTML = '<option value="">Select SubAgent Rep_code</option>';

                const selectedAgent = agentsWithSubagents.find(agent => agent.id === agentId);
                if (selectedAgent && selectedAgent.subagents && selectedAgent.subagents.length > 0) {
                    selectedAgent.subagents.forEach((subagent, index) => {
                        const code = `${selectedAgent.rep_code}/${String(index + 1).padStart(3, '0')}`;
                        const option = document.createElement('option');
                        option.value = code;
                        option.textContent = code;
                        subagentSelect.appendChild(option);
                    });
                }
            });
        });
    </script>
@endsection

@section('script')
@endsection
