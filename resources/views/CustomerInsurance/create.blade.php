@extends('AdminDashboard.master')
@section('title', 'Base Inputs')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>New Customer Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">New Customer Insurance</li>
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
                        <h5>Add Details</h5>

                    </div>
                    <form action="{{ route('customerinsurance.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    {{-- INV & Date --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="inv" class="form-label">RIB INV Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="inv" id="inv" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="date" class="form-label">Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Customer Dropdown --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Select Customer <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select name="name" id="customerSelect" class="form-control mb-5" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Contact, WhatsApp, Address --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <input type="text" name="contact" id="contact" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="whatsapp" class="form-label">Whatsapp Number</label>
                                            <input type="text" name="whatsapp" id="whatsapp" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" id="address" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    {{-- Policy, DN, Vehicle --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="policy" class="form-label">Policy Number</label>
                                            <input type="text" name="policy" id="policy" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="dn" class="form-label">D/N/INV Number</label>
                                            <input type="text" name="dn" id="dn" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="vehicle" class="form-label">Vehicle/Chassi No</label>
                                            <input type="text" name="vehicle" id="vehicle" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Company Dropdown --}}
                                    <div class="mb-3">
                                        <label for="insurance_company" class="form-label">Select Company <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select name="insurance_company" class="form-control mb-5" required
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Insurance Type Dropdown --}}
                                    <div class="mb-3">
                                        <label for="insurance_type" class="form-label">Select Insurance Type <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select name="insurance_type" id="insurance_type" class="form-control"
                                                required style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Insurance Type</option>
                                                @foreach ($insurance_types as $insuranceType)
                                                    <option value="{{ $insuranceType->id }}">{{ $insuranceType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Category --}}
                                    <div class="mb-3" id="category_wrapper">
                                        <label for="category" class="form-label">Select Category</label>
                                        <div class="position-relative">
                                            <select name="category" id="category" class="form-control"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Category</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Subcategory --}}
                                    <div class="mb-3" id="subcategory_wrapper">
                                        <label for="subcategory" class="form-label">Select Sub Category</label>
                                        <div class="position-relative">
                                            <select name="subcategory" id="subcategory" class="form-control"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Sub Category</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Variety Fields --}}
                                    <div class="mb-3" id="formfield_wrapper">
                                        <label for="varietyfields" class="form-label">Select Variety Fields</label>
                                        <div class="position-relative">
                                            <select name="varietyfields" id="varietyfields" class="form-control"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Variety Fields</option>
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Premium Fields --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="basic" class="form-label">Net Premium</label>
                                            <input type="number" name="basic" id="basic" step="0.01"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="srcc" class="form-label">SRCC Premium</label>
                                            <input type="number" name="srcc" id="srcc" step="0.01"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="tc" class="form-label">TC Premium</label>
                                            <input type="number" name="tc" id="tc" step="0.01"
                                                class="form-control">
                                        </div>
                                    </div>

                                    {{-- Others --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="others" class="form-label">Others</label>
                                            <input type="number" name="others" id="others" step="0.01"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="total" class="form-label">Total</label>
                                            <input type="number" name="total" id="total" step="0.01"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="sum_insured" class="form-label">Sum Insured</label>
                                            <input type="number" name="sum_insured" id="sum_insured" step="0.01"
                                                class="form-control">
                                        </div>
                                    </div>

                                    {{-- outstanding --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="paid_amount" class="form-label">Paid Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="paid_amount" id="paid_amount"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="outstanding_amount" class="form-label">Outstanding Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="paid_amount" id="paid_amount"
                                                class="form-control" required>
                                        </div>
                                    </div>


                                    {{-- Dates --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="from_date" class="form-label">Commencement Date</label>
                                            <input type="date" name="from_date" id="from_date" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="to_date" class="form-label">Expiry Date</label>
                                            <input type="date" name="to_date" id="to_date" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Agent Code --}}
                                    <div class="mb-3">
                                        <label for="introducer_code" class="form-label">Agent Code <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select name="introducer_code" id="introducer_code" class="form-control"
                                                required style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select Agent Rep_code</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->rep_code }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Sub Agent Code --}}
                                    <div class="mb-3">
                                        <label for="subagent_code" class="form-label">Sub Agent Code</label>
                                        <div class="position-relative">
                                            <select name="subagent_code" id="subagent_code" class="form-control"
                                                style="appearance: none; padding-right: 2.5rem;">
                                                <option value="">Select SubAgent Rep_code</option>
                                                @foreach ($agentsWithSubagents as $agent)
                                                    @foreach ($agent->subagents as $index => $subagent)
                                                        <option
                                                            value="{{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}">
                                                            {{ $agent->rep_code }}/{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span
                                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                        </div>
                                    </div>

                                    {{-- Premium Type --}}
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="premium_type" class="form-label">
                                                Premium Type <span class="text-danger">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <select name="premium_type" id="premium_type" class="form-control"
                                                    required style="appearance: none; padding-right: 2.5rem;">
                                                    <option value="">Select Premium Type</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Debit">Debit</option>
                                                </select>
                                                <span
                                                    style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">▼</span>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="status" class="form-label">
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="status" id="status" class="form-control"
                                                readonly required>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
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


    <script>
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

        const insuranceData = @json($insurance_types);

        document.addEventListener('DOMContentLoaded', function() {
            const insuranceSelect = document.getElementById('insurance_type');
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const formfieldSelect = document.getElementById('varietyfields');

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

        // Make the subagents accessible in JS
        const agentsWithSubagents = @json($agentsWithSubagents);

        document.addEventListener('DOMContentLoaded', () => {
            const agentSelect = document.getElementById('introducer_code');
            const subagentSelect = document.getElementById('subagent_code');

            agentSelect.addEventListener('change', function() {
                const agentId = parseInt(this.value);
                subagentSelect.innerHTML = '<option value="">Select SubAgent Rep_code</option>';

                const selectedAgent = agentsWithSubagents.find(agent => agent.id === agentId);
                if (selectedAgent && selectedAgent.subagents.length) {
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


        document.addEventListener('DOMContentLoaded', function() {
            const premiumType = document.getElementById('premium_type');
            const statusField = document.getElementById('status');

            function updateStatus() {
                if (premiumType.value === 'Cash') {
                    statusField.value = 'Completed';
                } else if (premiumType.value === 'Debit') {
                    statusField.value = 'Pending';
                } else {
                    statusField.value = '';
                }
            }

            premiumType.addEventListener('change', updateStatus);

            // Optionally call on page load if editing
            updateStatus();
        });
    </script>

@endsection

@section('script')
@endsection
