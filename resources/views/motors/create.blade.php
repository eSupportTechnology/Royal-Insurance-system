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
                    <h5>Step 1: Select Filters</h5>
                </div>
                <div class="card-body">
                    <!-- Filter form (GET) -->
                    <form method="GET" action="{{ route('customerResponse.create') }}" class="row g-3">
                        <div class="col-md-4">
                            <label>Insurance Type</label>
                            <select name="insurance_type_id" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                @foreach($insurance_types as $type)
                                    <option value="{{ $type->id }}" {{ (isset($typeId) && $typeId == $type->id) ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (isset($categoryId) && $categoryId == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Sub Category (optional)</label>
                            <select name="sub_category_id" class="form-control">
                                <option value="">-- None --</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ (isset($subCategoryId) && $subCategoryId == $sub->id) ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-info">Load Form Fields</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Step 2: Fill Customer & Request Info</h5>
                </div>
                <div class="card-body">
                    <!-- Main Form (POST) -->
                    <form action="{{ route('customerResponse.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="agent_id" class="form-label">Agent</label>
                            <select name="agent_id" class="form-control" required>
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Customer Email</label>
                            <input type="email" name="customer_email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input type="text" name="customer_phone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        @if($formFields->isNotEmpty())
                        <div class="card mb-3">
                            <div class="card-header">Form Fields</div>
                            <div class="card-body">
                                @foreach($formFields as $formField)
                                    <div class="mb-3">
                                        <label>{{ $formField->field_name }}</label>
                                        @if($formField->field_type == 'text')
                                            <input type="text" name="responses[{{ $formField->id }}]" class="form-control">
                                        @elseif($formField->field_type == 'textarea')
                                            <textarea name="responses[{{ $formField->id }}]" class="form-control"></textarea>
                                        @elseif($formField->field_type == 'select')
                                            <select name="responses[{{ $formField->id }}]" class="form-control">
                                                <option value="">Select an option</option>
                                                @foreach($formField->options as $option)
                                                    <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($formField->field_type == 'checkbox')
                                            @foreach($formField->options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="responses[{{ $formField->id }}][]" value="{{ $option->option_value }}">
                                                    <label class="form-check-label">{{ $option->option_value }}</label>
                                                </div>
                                            @endforeach
                                        @elseif($formField->field_type == 'radio')
                                            @foreach($formField->options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="responses[{{ $formField->id }}]" value="{{ $option->option_value }}">
                                                    <label class="form-check-label">{{ $option->option_value }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
