@extends('RepDashboard.master')

@section('title', 'Agent Commission Details')

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
                        <h5>Agent Commissions and Insurance Details</h5>
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
                        </div>


                    <div class="container">

                    </div>


                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="agent-commission-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Insurance ID</th>
                                        <th>Customer Name</th>
                                        <th>Company Name</th>
                                        <th>Agent ID</th>
                                        <th>Net Premium Commission</th>
                                        <th>SRCC Premium Commission</th>
                                        <th>TC Premium Commission</th>
                                        <th>Total Commission</th>
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
            var table = $('#agent-commission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('rep.commissions.agent') }}',
                    data: function(d) {
                        d.customer_id = $('#customer-filter').val();
                        d.company_id = $('#company-filter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'customer_id',
                        name: 'customer_id'
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
                        data: 'agent_id',
                        name: 'agent_id'
                    },
                    {
                        data: 'net',
                        name: 'net'
                    },
                    {
                        data: 'srcc',
                        name: 'srcc'
                    },
                    {
                        data: 'tc',
                        name: 'tc'
                    },
                    {
                        data: 'total',
                        name: 'total'
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

            // Apply Filters button reloads table with filters
            $('#apply_filters').on('click', function() {
                table.ajax.reload();
            });

            // Clear Filters button resets selects and reloads table
            $('#clear_filters').on('click', function() {
                $('#customer-filter').val('');
                $('#company-filter').val('');
                table.ajax.reload();
            });
        });
    </script>
    <style>
        /* Position search bar (top right) */
        .dataTables_wrapper .dataTables_filter {
            padding-right: 1rem;
            text-align: right !important;
            margin-bottom: 15px !important;
        }

        /* Position 'Show entries' (top left) */
        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            margin-bottom: 15px !important;
        }

        /* Make "Show entries" appear in one line */
        .dataTables_wrapper .dataTables_length label {
            display: flex !important;
            align-items: center !important;
            gap: 5px;
            /* Optional spacing */
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_length select {
            margin: 0 5px;
            width: 60px !important;
            /* Adjust as needed */
            padding: 4px 6px;
        }



        /* Move pagination to right */
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
