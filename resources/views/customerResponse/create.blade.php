@extends('AdminDashboard.master')
@section('title', 'Create Insurance Request')

@section('breadcrumb-title')
    <h3>Create Insurance Request</h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create Insurance Request</h5>
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

                    <form action="{{ route('customerResponse.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Select Agent with Autocomplete -->
                        <div class="mb-3">
                            <label for="agent_search" class="form-label">Select Agent</label>
                            <div class="position-relative">
                                <input type="text" id="agent_search" class="form-control" placeholder="Type atleast 1 characters..." autocomplete="off">
                                <input type="hidden" name="agent_id" id="agent_id" required>
                                <div id="agent_suggestions" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>

                        <!-- Select Customer with Autocomplete -->
                        <div class="mb-3">
                            <label for="customer_search" class="form-label">Select Customer</label>
                            <div class="position-relative">
                                <input type="text" id="customer_search" class="form-control mb-5" placeholder="Type atleast 1 characters..." autocomplete="off">
                                <input type="hidden" name="customer_id" id="customer_id" required>
                                <div id="customer_suggestions" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>

                        <!-- Select Insurance Type -->
                        <div class="mb-3">
                            <label for="insurance_type_id" class="form-label">Select Insurance Type</label>
                            <div class="position-relative">
                                <select name="insurance_type_id" id="insurance_type_id" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    <option value="">Select Insurance Type</option>
                                    @foreach($insurance_types as $insuranceType)
                                        <option value="{{ $insuranceType->id }}">{{ $insuranceType->name }}</option>
                                    @endforeach
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <!-- Select Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Select Category</label>
                            <div class="position-relative">
                                <select name="category_id" id="category_id" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    <option value="">Select Category</option>
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <!-- Select Subcategory -->
                        <div class="mb-3">
                            <label for="sub_category_id" class="form-label">Select Sub Category</label>
                            <div class="position-relative">
                                <select name="sub_category_id" id="sub_category_id" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    <option value="">Select Sub Category</option>
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <!-- Form Fields Area -->
                        <div id="formFieldsArea" class="mt-4 p-4 border rounded bg-light shadow-sm text-black"></div>

                        <!-- Status -->
                        <div class="mb-3 mt-5">
                            <label for="status" class="form-label">Status</label>
                            <div class="position-relative">
                                <select name="status" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <!-- Submission Date -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Submission Date</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Insurance Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var categories = @json($categories);
        var subcategories = @json($subcategories);
        var formFields = @json($formFields);
        var agents = @json($agents);
        var customers = @json($customers);

        // Autocomplete functionality for agents
        $('#agent_search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            const suggestions = $('#agent_suggestions');

            if (searchTerm.length < 1) {
                suggestions.removeClass('show');
                return;
            }

            const filteredAgents = agents.filter(agent =>
                agent.name.toLowerCase().includes(searchTerm)
            );

            if (filteredAgents.length > 0) {
                let html = '';
                filteredAgents.forEach(agent => {
                    html += `<button type="button" class="dropdown-item" data-id="${agent.id}" data-name="${agent.name}">${agent.name}</button>`;
                });
                suggestions.html(html).addClass('show');
            } else {
                suggestions.removeClass('show');
            }
        });

        // Handle agent selection
        $(document).on('click', '#agent_suggestions .dropdown-item', function() {
            const agentId = $(this).data('id');
            const agentName = $(this).data('name');

            $('#agent_search').val(agentName);
            $('#agent_id').val(agentId);
            $('#agent_suggestions').removeClass('show');
        });

        // Autocomplete functionality for customers
        $('#customer_search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            const suggestions = $('#customer_suggestions');

            if (searchTerm.length < 1) {
                suggestions.removeClass('show');
                return;
            }

            const filteredCustomers = customers.filter(customer =>
                customer.name.toLowerCase().includes(searchTerm)
            );

            if (filteredCustomers.length > 0) {
                let html = '';
                filteredCustomers.forEach(customer => {
                    html += `<button type="button" class="dropdown-item" data-id="${customer.id}" data-name="${customer.name}">${customer.name}</button>`;
                });
                suggestions.html(html).addClass('show');
            } else {
                suggestions.removeClass('show');
            }
        });

        // Handle customer selection
        $(document).on('click', '#customer_suggestions .dropdown-item', function() {
            const customerId = $(this).data('id');
            const customerName = $(this).data('name');

            $('#customer_search').val(customerName);
            $('#customer_id').val(customerId);
            $('#customer_suggestions').removeClass('show');
        });

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.position-relative').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // Clear hidden fields when input is cleared
        $('#agent_search').on('input', function() {
            if ($(this).val() === '') {
                $('#agent_id').val('');
            }
        });

        $('#customer_search').on('input', function() {
            if ($(this).val() === '') {
                $('#customer_id').val('');
            }
        });

        function renderFields(fields) {
            $('#formFieldsArea').empty();

            fields.forEach(field => {
                let fieldHtml = `<div class="mb-3 mt-4 "><label>${field.field_name}</label>`;

                if (field.field_type === 'text') {
                    fieldHtml += `<input type="text" name="responses[${field.id}]" class="form-control">`;
                } else if (field.field_type === 'textarea') {
                    fieldHtml += `<textarea name="responses[${field.id}]" class="form-control"></textarea>`;
                } else if (field.field_type === 'date') {
                    fieldHtml += `<input type="date" name="responses[${field.id}]" class="form-control">`;
                } else if (field.field_type === 'file') {
                    fieldHtml += `<input type="file" name="responses[${field.id}]" class="form-control">`;
                } else if (field.field_type === 'number') {
                    fieldHtml += `<input type="number" name="responses[${field.id}]" class="form-control">`;
                } else if (field.field_type === 'select') {
                    fieldHtml += `<select name="responses[${field.id}]" class="form-control"><option value="">Select an option</option>`;
                    field.options.forEach(option => {
                        fieldHtml += `<option value="${option.option_value}">${option.option_value}</option>`;
                    });
                    fieldHtml += `</select>`;
                } else if (field.field_type === 'checkbox') {
                    field.options.forEach(option => {
                        fieldHtml += `<div class="form-check">
                            <input type="checkbox" name="responses[${field.id}][]" value="${option.option_value}" class="form-check-input">
                            <label class="form-check-label">${option.option_value}</label>
                        </div>`;
                    });
                } else if (field.field_type === 'radio') {
                    field.options.forEach(option => {
                        fieldHtml += `<div class="form-check">
                            <input type="radio" name="responses[${field.id}]" value="${option.option_value}" class="form-check-input">
                            <label class="form-check-label">${option.option_value}</label>
                        </div>`;
                    });
                }

                fieldHtml += `</div>`;
                $('#formFieldsArea').append(fieldHtml);
            });
        }

        $('#insurance_type_id').change(function () {
            const insuranceTypeId = $(this).val();
            $('#category_id').empty().append('<option value="">Select Category</option>');
            $('#sub_category_id').empty().append('<option value="">Select Sub Category</option>');
            $('#formFieldsArea').empty();

            categories.forEach(category => {
                if (category.insurance_type_id == insuranceTypeId) {
                    $('#category_id').append(`<option value="${category.id}">${category.name}</option>`);
                }
            });
        });

        $('#category_id').change(function () {
            const categoryId = $(this).val();
            $('#sub_category_id').empty().append('<option value="">Select Sub Category</option>');
            $('#formFieldsArea').empty();

            subcategories.forEach(subcategory => {
                if (subcategory.category_id == categoryId) {
                    $('#sub_category_id').append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
                }
            });

            const typeId = $('#insurance_type_id').val();
            const fields = formFields.filter(field =>
                field.insurance_type_id == typeId &&
                field.category_id == categoryId &&
                field.sub_category_id === null
            );

            renderFields(fields);
        });

        $('#sub_category_id').change(function () {
            const subCategoryId = $(this).val();
            const typeId = $('#insurance_type_id').val();
            const categoryId = $('#category_id').val();

            if (!typeId || !categoryId) return;

            let fields = [];

            if (subCategoryId) {
                fields = formFields.filter(field =>
                    field.insurance_type_id == typeId &&
                    field.category_id == categoryId &&
                    field.sub_category_id == subCategoryId
                );
            } else {
                fields = formFields.filter(field =>
                    field.insurance_type_id == typeId &&
                    field.category_id == categoryId &&
                    field.sub_category_id === null
                );
            }

            renderFields(fields);
        });
    });
</script>

@endsection
