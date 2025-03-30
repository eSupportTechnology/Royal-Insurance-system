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

                        <!-- Agent -->
                        <div class="mb-3">
                            <label>Agent</label>
                            <select name="agent_id" class="form-control" required>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $response->agent_id == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Customer -->
                        <div class="mb-3">
                            <label>Customer</label>
                            <select name="customer_id" class="form-control" required>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $response->customer_email == $customer->email ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Insurance Type, Category, Subcategory -->
                        <div class="mb-3">
                            <label>Insurance Type</label>
                            <select name="insurance_type_id" class="form-control" required>
                                @foreach($insurance_types as $type)
                                    <option value="{{ $type->id }}" {{ $response->insurance_type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $response->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Sub Category</label>
                            <select name="sub_category_id" class="form-control">
                                <option value="">-- None --</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ $response->sub_category_id == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status and Date -->
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Pending" {{ $response->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ $response->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ $response->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $response->date }}">
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
