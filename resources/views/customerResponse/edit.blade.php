@extends('AdminDashboard.master')

@section('title', 'Edit Insurance Request')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header"><h5>Edit Insurance Request</h5></div>
                <div class="card-body">

                    <form action="{{ route('customerResponse.update', $response->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Agent with Autocomplete -->
                        <div class="mb-3">
                            <label for="agent_search" class="form-label">Agent</label>
                            <div class="position-relative">
                                <input type="text" id="agent_search" class="form-control" placeholder="Type agent name..." autocomplete="off"
                                       value="{{ $response->agent->name ?? '' }}">
                                <input type="hidden" name="agent_id" id="agent_id" value="{{ $response->agent_id }}" required>
                                <div id="agent_suggestions" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>

                        <!-- Customer with Autocomplete -->
                        <div class="mb-3">
                            <label for="customer_search" class="form-label">Customer</label>
                            <div class="position-relative">
                                <input type="text" id="customer_search" class="form-control" placeholder="Type customer name..." autocomplete="off"
                                       value="{{ $response->customer_name ?? '' }}">
                                <input type="hidden" name="customer_id" id="customer_id" value="{{ $response->customer_id }}" required>
                                <div id="customer_suggestions" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>

                        <!-- Insurance Type, Category, Subcategory -->
                        <div class="mb-3">
                            <label for="insurance_type_id" class="form-label">Insurance Type</label>
                            <div class="position-relative">
                                <select name="insurance_type_id" id="insurance_type_id" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    @foreach($insurance_types as $type)
                                        <option value="{{ $type->id }}" {{ $response->insurance_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <div class="position-relative">
                                <select name="category_id" id="category_id" class="form-control" required style="appearance: none; padding-right: 2.5rem;">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $response->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sub_category_id" class="form-label">Sub Category</label>
                            <div class="position-relative">
                                <select name="sub_category_id" id="sub_category_id" class="form-control" style="appearance: none; padding-right: 2.5rem;">
                                    <option value="">-- None --</option>
                                    @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}" {{ $response->sub_category_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <!-- Status and Date -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <div class="position-relative">
                                <select name="status" id="status" class="form-control" style="appearance: none; padding-right: 2.5rem;">
                                    <option value="Pending" {{ $response->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $response->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $response->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); pointer-events: none;">
                                    ▼
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $response->date }}">
                        </div>

                        <!-- Form Fields -->
                        <div class="mt-4 p-4 border rounded bg-light shadow-sm text-black">
                            <h5 class='mb-2'>Form Fields</h5>

                            @foreach($response->responseFields as $field)
                                @php
                                    $inputValue = $field->response;
                                    $fieldData = $field->formField;
                                @endphp

                                <div class="mb-3">
                                    <label class="fw">{{ $fieldData->field_name }}</label>

                                    @if($fieldData->field_type === 'text' || $fieldData->field_type === 'number' || $fieldData->field_type === 'date')
                                        <input type="{{ $fieldData->field_type }}" name="responses[{{ $fieldData->id }}]" value="{{ $inputValue }}" class="form-control">

                                    @elseif($fieldData->field_type === 'textarea')
                                        <textarea name="responses[{{ $fieldData->id }}]" class="form-control">{{ $inputValue }}</textarea>

                                    @elseif($fieldData->field_type === 'select')
                                        <select name="responses[{{ $fieldData->id }}]" class="form-control">
                                            <option value="">Select an option</option>
                                            @foreach($fieldData->options as $opt)
                                                <option value="{{ $opt->option_value }}" {{ $inputValue == $opt->option_value ? 'selected' : '' }}>
                                                    {{ $opt->option_value }}
                                                </option>
                                            @endforeach
                                        </select>

                                    @elseif($fieldData->field_type === 'checkbox')
                                        @php $values = explode(', ', $inputValue); @endphp
                                        @foreach($fieldData->options as $opt)
                                            <div class="form-check">
                                                <input type="checkbox" name="responses[{{ $fieldData->id }}][]" value="{{ $opt->option_value }}"
                                                    class="form-check-input" {{ in_array($opt->option_value, $values) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $opt->option_value }}</label>
                                            </div>
                                        @endforeach

                                    @elseif($fieldData->field_type === 'radio')
                                        @foreach($fieldData->options as $opt)
                                            <div class="form-check">
                                                <input type="radio" name="responses[{{ $fieldData->id }}]" value="{{ $opt->option_value }}"
                                                    class="form-check-input" {{ $inputValue == $opt->option_value ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $opt->option_value }}</label>
                                            </div>
                                        @endforeach

                                    @elseif($fieldData->field_type === 'file')
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $inputValue) }}" target="_blank">View Uploaded File</a>
                                        </div>
                                        <input type="file" name="responses[{{ $fieldData->id }}]" class="form-control">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Update Response</button>
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
    });
</script>
@endsection
