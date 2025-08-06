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

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Sub Agent Commissions and Insurance Details</h5>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body row">
                            <div class="col-md-4">
                                <label>Filter by Customer</label>
                                <select id="customer-filter" class="form-control">
                                    <option value="">All Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Filter by Company</label>
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

                            <div class="col-md-3" style="margin-top: 12px;">
                                <label for="from_date">From Date:</label>
                                <input type="date" id="from_date" class="form-control">
                            </div>
                            <div class="col-md-3" style="margin-top: 12px;">
                                <label for="to_date">To Date:</label>
                                <input type="date" id="to_date" class="form-control">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="dt-ext table-responsive">
                                <table class="table table-responsive-sm" id="subagent-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Insurance ID</th>
                                            <th>Customer Name</th>
                                            <th>Company Name</th>
                                            <th>Sub Agent ID</th>
                                            <th>Net Premium Commission</th>
                                            <th>SRCC Premium Commission</th>
                                            <th>TC Premium Commission</th>
                                            <th>Total Commission</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
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
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'customer_insurance_id',
                        name: 'customer_insurance_id'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'sub_agent_id',
                        name: 'sub_agent_id'
                    },
                    {
                        data: 'net_premium',
                        name: 'net_premium'
                    },
                    {
                        data: 'srcc_premium',
                        name: 'srcc_premium'
                    },
                    {
                        data: 'tc_premium',
                        name: 'tc_premium'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return data ? data.substring(0, 10) : '';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $('#apply_filters').click(function() {
                table.ajax.reload();
            });

            $('#clear_filters').click(function() {
                $('#customer-filter').val('');
                $('#company-filter').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                table.ajax.reload();
            });

            $('#customer-filter, #company-filter, #from_date, #to_date').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_filter {
            padding-right: 1rem;
            text-align: right !important;
            margin-bottom: 15px !important;
        }

        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            margin-bottom: 15px !important;
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex !important;
            align-items: center !important;
            gap: 5px;
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_length select {
            margin: 0 5px;
            width: 60px !important;
            padding: 4px 6px;
        }

        .dataTables_wrapper .dataTables_paginate {
            display: flex !important;
            justify-content: flex-end !important;
            margin-top: 15px !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 5px 10px !important;
            margin: 0 2px !important;
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            background-color: #fff !important;
            color: #007bff !important;
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
