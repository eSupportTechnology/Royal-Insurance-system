@extends('AdminDashboard.master')

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
                <div class="card">
                    <div class="card-header">
                        <h5>Sub Agent Commission Details</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-4">
                                <label for="filter_customer" class="form-label">Customer</label>
                                <select id="filter_customer" class="form-control">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter_company" class="form-label">Company</label>
                                <select id="filter_company" class="form-control">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                               <button id="clear_filters" class="btn btn-secondary me-2">Clear Filters</button>
                               <button id="apply_filters" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </form>

                        <div class="dt-ext mt-4 table-responsive">
                            <table class="table table-bordered" id="subagent-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Insurance ID</th>
                                        <th>Customer Name</th>
                                        <th>Company Name</th>
                                        <th>Sub Agent ID</th>
                                        <th>Net Premium</th>
                                        <th>SRCC Premium</th>
                                        <th>TC Premium</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
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

    <script>
        $(document).ready(function () {
        let table = $('#subagent-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('commissions.subagent') }}",
                data: function (d) {
                    d.customer_id = $('#filter_customer').val();
                    d.company_id = $('#filter_company').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'customer_id', name: 'customer_id' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'company_name', name: 'company_name' },
                { data: 'sub_agent_id', name: 'sub_agent_id' },
                { data: 'net', name: 'net' },
                { data: 'srcc', name: 'srcc' },
                { data: 'tc', name: 'tc' },
                { data: 'total', name: 'total' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#apply_filters').click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });

        $('#clear_filters').click(function (e) {
            e.preventDefault();
            $('#filter_customer').val('');
            $('#filter_company').val('');
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
