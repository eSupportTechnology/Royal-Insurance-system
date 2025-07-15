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
                        <div class="card-body">
                            <div class="row">
                                <div class="col">

                                    {{-- INV & Date --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="inv" class="form-label">RIB INV Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="inv" id="inv"
                                                value="{{ $customerinsurance->inv }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="date" class="form-label">Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date"
                                                value="{{ $customerinsurance->date }}" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Customer Dropdown --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Select Customer <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select name="name" id="customerSelect" class="form-control mb-5" required>
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $customer->id == $customerinsurance->name ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">▼</span>
                                        </div>
                                    </div>

                                    {{-- Contact, WhatsApp, Address --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <input type="text" name="contact" id="contact" class="form-control"
                                                value="{{ $customerinsurance->contact }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="whatsapp" class="form-label">Whatsapp Number</label>
                                            <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                                value="{{ $customerinsurance->whatsapp }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" id="address" rows="1" class="form-control">{{ $customerinsurance->address }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Policy, DN, Vehicle --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="policy" class="form-label">Policy Number</label>
                                            <input type="text" name="policy" id="policy" class="form-control"
                                                value="{{ $customerinsurance->policy }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="dn" class="form-label">D/N/INV Number</label>
                                            <input type="text" name="dn" id="dn" class="form-control"
                                                value="{{ $customerinsurance->dn }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="vehicle" class="form-label">Vehicle/Chassi No</label>
                                            <input type="text" name="vehicle" id="vehicle" class="form-control"
                                                value="{{ $customerinsurance->vehicle }}">
                                        </div>
                                    </div>

                                    {{-- Company Dropdown --}}
                                    <div class="mb-3">
                                        <label for="insurance_company" class="form-label">Select Company <span
                                                class="text-danger">*</span></label>
                                        <select name="insurance_company" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ $customerinsurance->insurance_company == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Insurance Type Dropdown --}}
                                    <div class="mb-3">
                                        <label for="insurance_type" class="form-label">Select Insurance Type <span
                                                class="text-danger">*</span></label>
                                        <select name="insurance_type" id="insurance_type" class="form-control" required>
                                            <option value="">Select Insurance Type</option>
                                            @foreach ($insurance_types as $insuranceType)
                                                <option value="{{ $insuranceType->id }}"
                                                    {{ $customerinsurance->insurance_type == $insuranceType->id ? 'selected' : '' }}>
                                                    {{ $insuranceType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Category, Subcategory, Variety Field --}}
                                    <div class="mb-3" id="category_wrapper">
                                        <label for="category" class="form-label">Select Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="subcategory_wrapper">
                                        <label for="subcategory" class="form-label">Select Sub Category</label>
                                        <select name="subcategory" id="subcategory" class="form-control">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="formfield_wrapper">
                                        <label for="varietyfields" class="form-label">Select Variety Fields</label>
                                        <select name="varietyfields" id="varietyfields" class="form-control">
                                            <option value="">Select Variety Fields</option>
                                        </select>
                                    </div>

                                    {{-- Premium Inputs --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="basic" class="form-label">Net Premium</label>
                                            <input type="number" step="0.01" name="basic" id="basic"
                                                class="form-control" value="{{ $customerinsurance->basic }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="srcc" class="form-label">SRCC Premium</label>
                                            <input type="number" step="0.01" name="srcc" id="srcc"
                                                class="form-control" value="{{ $customerinsurance->srcc }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="tc" class="form-label">TC Premium</label>
                                            <input type="number" step="0.01" name="tc" id="tc"
                                                class="form-control" value="{{ $customerinsurance->tc }}">
                                        </div>
                                    </div>

                                    {{-- Others, Total, Sum Insured --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="others" class="form-label">Others</label>
                                            <input type="number" step="0.01" name="others" id="others"
                                                class="form-control" value="{{ $customerinsurance->others }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="total" class="form-label">Total</label>
                                            <input type="number" step="0.01" name="total" id="total"
                                                class="form-control" value="{{ $customerinsurance->total }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="sum_insured" class="form-label">Sum Insured</label>
                                            <input type="number" step="0.01" name="sum_insured" id="sum_insured"
                                                class="form-control" value="{{ $customerinsurance->sum_insured }}">
                                        </div>
                                    </div>

                                    {{-- outstanding --}}

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="paid_amount" class="form-label">Paid Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="paid_amount" id="paid_amount"
                                                value="{{ $customerinsurance->paid_amount }}" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="outstanding_amount" class="form-label">Outstanding Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="outstanding_amount" id="outstanding_amount"
                                                value="{{ $customerinsurance->outstanding_amount }}" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Dates --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="from_date" class="form-label">Commencement Date</label>
                                            <input type="date" name="from_date" id="from_date" class="form-control"
                                                value="{{ $customerinsurance->from_date }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="to_date" class="form-label">Expiry Date</label>
                                            <input type="date" name="to_date" id="to_date" class="form-control"
                                                value="{{ $customerinsurance->to_date }}">
                                        </div>
                                    </div>

                                    {{-- Agent Code --}}
                                    <div class="mb-3">
                                        <label for="introducer_code" class="form-label">Agent Code <span
                                                class="text-danger">*</span></label>
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
                                    </div>

                                    {{-- Sub Agent Code --}}
                                    <div class="mb-3">
                                        <label for="subagent_code" class="form-label">Sub Agent Code</label>
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
                                    </div>

                                    {{-- Premium Type --}}
                                    {{-- Premium Type (Read-only display, but submits value) --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="premium_type" class="form-label">Premium Type <span
                                                    class="text-danger">*</span></label>

                                            {{-- Disabled dropdown (for display only) --}}
                                            <select class="form-control" disabled>
                                                <option value="">Select Premium Type</option>
                                                <option value="Cash"
                                                    {{ $customerinsurance->premium_type == 'Cash' ? 'selected' : '' }}>Cash
                                                </option>
                                                <option value="Debit"
                                                    {{ $customerinsurance->premium_type == 'Debit' ? 'selected' : '' }}>
                                                    Debit</option>
                                            </select>

                                            {{-- Hidden input to actually submit the value --}}
                                            <input type="hidden" name="premium_type"
                                                value="{{ $customerinsurance->premium_type }}">
                                        </div>


                                        <div class="mb-3 col-md-6">
                                            <label for="status" class="form-label">Status</label>
                                            <input type="text" name="status" id="status" class="form-control"
                                                value="{{ $customerinsurance->status }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
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
                select.innerHTML = '<option value="">Select ' + select.getAttribute('data-placeholder') +
                    '</option>';
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
                            loadFormFields(selectedInsuranceId, selectedCategoryId, preloadSubcategory,
                                currentFormField);
                        }
                    }
                }
            }

            function loadFormFields(selectedInsuranceId, selectedCategoryId, selectedSubcategoryId,
                preloadFormField = null) {
                formfieldWrapper.style.display = 'none';
                formfieldSelect.innerHTML = '<option value="">Select Variety Fields</option>';

                if (!selectedInsuranceId || !selectedCategoryId || !selectedSubcategoryId) return;

                const insurance = insuranceData.find(ins => ins.id == selectedInsuranceId);
                if (insurance && insurance.categories) {
                    const category = insurance.categories.find(cat => cat.id == selectedCategoryId);
                    if (category && category.subcategories) {
                        const subcategory = category.subcategories.find(sub => sub.id == selectedSubcategoryId);
                        if (subcategory && subcategory.form_fields && subcategory.form_fields.length > 0) {
                            populateSelect(formfieldSelect, subcategory.form_fields, preloadFormField, 'id',
                                'field_name');
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
                        const code =
                            `${selectedAgent.rep_code}/${String(index + 1).padStart(3, '0')}`;
                        const option = document.createElement('option');
                        option.value = code;
                        option.textContent = code;
                        subagentSelect.appendChild(option);
                    });
                }
            });
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     const premiumType = document.getElementById('premium_type');
        //     const statusField = document.getElementById('status');

        //     function updateStatus() {
        //         if (premiumType.value === 'Cash') {
        //             statusField.value = 'Completed';
        //         } else if (premiumType.value === 'Debit') {
        //             statusField.value = 'Pending';
        //         } else {
        //             statusField.value = '';
        //         }
        //     }

        //     // Update status on page load and when premium type changes
        //     updateStatus();
        //     premiumType.addEventListener('change', updateStatus);
        // });
    </script>
@endsection

@section('script')
@endsection
