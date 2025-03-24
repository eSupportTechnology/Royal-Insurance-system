@extends('AdminDashboard.master')
@section('title', 'Form Field Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="mt-3">Form Details</h3>
                <p class="mt-3">
                    <strong>Insurance Type:</strong> {{ $insuranceType->name }}<br>
                    <strong>Category:</strong> {{ $category->name }}<br>
                    <strong>Sub Category:</strong> {{ $subCategory->name ?? 'N/A' }}
                </p>

                @if ($formFields->isNotEmpty()) <!-- Check if there are form fields -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Fields</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th>Field Type</th>
                                        <th>Required</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formFields as $field)
                                        @if ($subCategory && $field->sub_category_id == $subCategory->id) <!-- If sub-category matches, show specific fields -->
                                            <tr>
                                                <td>{{ $field->field_name }}</td>
                                                <td>{{ ucfirst($field->field_type) }}</td>
                                                <td>{{ $field->required ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    @if (in_array($field->field_type, ['select', 'checkbox']))
                                                        <ul>
                                                            @foreach ($field->options as $option)
                                                                <li>{{ $option->option_value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @elseif (!$subCategory) <!-- If no sub-category, show fields for the general category -->
                                            <tr>
                                                <td>{{ $field->field_name }}</td>
                                                <td>{{ ucfirst($field->field_type) }}</td>
                                                <td>{{ $field->required ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    @if (in_array($field->field_type, ['select', 'checkbox']))
                                                        <ul>
                                                            @foreach ($field->options as $option)
                                                                <li>{{ $option->option_value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('formField.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        No form fields found for the selected combination.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
