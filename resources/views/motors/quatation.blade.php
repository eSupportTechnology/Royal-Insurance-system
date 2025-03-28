@extends('AdminDashboard.master')
@section('title', 'Create Sub Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Quotation Report</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">>Quotation Report Controls</li>
    <li class="breadcrumb-item active">Insurance >Quotation Report</li>
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
                <br>
                <div class="card">
                    <div class="card-header">
                        <h5>package Details</h5>
                    </div>

                    <form action="{{ route('quotation.store', $motor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <!-- package Dropdown -->
                            <div class="mb-3 col-6">
                                <select class="form-select" name="insurance_company_id" id="insurance_company_id" required>
                                    <option value="">Select Insurance Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="dt-ext table-responsive">
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Package Type</th>
                                            <th class="text-center">Required</th>
                                            <th class="text-center">Options</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="packages">
                                        <tr>
                                            <td>
                                                <input type="text" name="package_name[]" class="form-control" placeholder="Enter package name" required />
                                            </td>
                                            <td>
                                                <select name="package_type[]" class="form-control" required>
                                                    <option value="text">Text</option>
                                                    <option value="select">Dropdown</option>
                                                    <option value="number">Number</option>
                                                    <option value="checkbox">Checkbox</option>
                                                    <option value="file">File Upload</option>
                                                    <option value="date">Date</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="required[]" value="1" class="form-check-input" />
                                            </td>
                                            <td class="text-center">
                                                <input type="text" name="field_options[]" class="form-control" placeholder="Enter options (comma-separated)" />
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger remove-row">X</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer text-end">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="button" id="addRow" class="btn btn-success">
                                        + Add Package
                                    </button>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script>


        // Add new form row dynamically
        document.addEventListener("DOMContentLoaded", function () {
    const packagesTable = document.getElementById("packages");
    const addRowButton = document.getElementById("addRow");

    // Function to add new row
    addRowButton.addEventListener("click", function () {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="package_name[]" class="form-control" placeholder="Enter package name" required></td>
            <td>
                <select name="package_type[]" class="form-control" required>
                    <option value="text">Text</option>
                    <option value="select">Dropdown</option>
                    <option value="number">Number</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="file">File Upload</option>
                    <option value="date">Date</option>
                </select>
            </td>
            <td class="text-center">
                <input type="checkbox" name="required[]" value="1" class="form-check-input">
            </td>
            <td class="text-center">
                <input type="text" name="field_options[]" class="form-control" placeholder="Enter options (comma-separated)">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger remove-row">X</button>
            </td>
        `;
        packagesTable.appendChild(newRow);
    });

    // Remove row on click
    packagesTable.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-row")) {
            event.target.closest("tr").remove();
        }
    });

            $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#export-button')) {
                $('#export-button').DataTable().destroy();
            }
            $('#export-button').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                responsive: true
            });
        });

        });
    </script>
@endsection
