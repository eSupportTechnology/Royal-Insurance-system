@extends('RepDashboard.master')

@section('title', 'Sub Agent Commission Details')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Filter Sub Agent Commissions</h5>
                </div>
                <div class="card-body row">
                    <div class="col-md-4">
                        <label for="customer-filter">Filter by Customer</label>
                        <select id="customer-filter" class="form-control">
                            <option value="">All Customers</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="company-filter">Filter by Company</label>
                        <select id="company-filter" class="form-control">
                            <option value="">All Companies</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="clear_filters" class="btn btn-secondary me-2">Clear Filters</button>
                        <button id="apply_filters" class="btn btn-primary">Apply Filters</button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Sub Agent Commission Details</h5>
                </div>
                <div class="card-body">
                    <div class="dt-ext table-responsive">
                        <table class="table table-bordered" id="subagent-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Insurance ID</th>
                                    <th>Customer Name</th>
                                    <th>Company Name</th>
                                    <th>Sub Agent ID</th>
                                    <th>Net Premium Commission</th>
                                    <th>SRCC Premium Commission</th>
                                    <th>TC Premium Commission</th>
                                    <th>Total Commission</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody> <!-- DataTables will populate this -->
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('frontend/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('frontend/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#subagent-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('rep.commissions.subagent') }}',
                    data: function(d) {
                        d.customer_id = $('#customer-filter').val();
                        d.company_id = $('#company-filter').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'customer_insurance_id', name: 'customer_insurance_id' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'sub_agent_id', name: 'sub_agent_id' },
                    { data: 'net_premium', name: 'net_premium' },
                    { data: 'srcc_premium', name: 'srcc_premium' },
                    { data: 'tc_premium', name: 'tc_premium' },
                    { data: 'total', name: 'total' },
                    { data: 'status', name: 'status' },
                ],
                dom: 'Bfrtip',
                buttons: ['csv', 'excel', 'pdf', 'print'],
            });

            $('#apply_filters').on('click', function() {
                table.ajax.reload();
            });

            $('#clear_filters').on('click', function() {
                $('#customer-filter').val('');
                $('#company-filter').val('');
                table.ajax.reload();
            });
        });
    </script>

    <style>
        /* Simple search positioning */
        .dataTables_wrapper .dataTables_filter {
            padding-right: 1rem;
            text-align: right !important;
            margin-bottom: 15px !important;
        }

        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            margin-bottom: 15px !important;
        }

        /* Basic pagination styling */
        .dataTables_paginate {
            text-align: center !important;
            margin-top: 15px !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 5px 10px !important;
            margin: 0 2px !important;
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            background-color: #fff !important;
            color: #007bff !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #f8f9fa !important;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #007bff !important;
            color: #fff !important;
            border-color: #007bff !important;
        }
    </style>
@endsection
