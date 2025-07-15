@extends('AdminDashboard.master')

@section('title', 'Customers')
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

    .action-btn {
        height: 31px !important;
        width: 31px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        border: none !important;
        font-size: 14px !important;
    }

    .action-btn i {
        margin: 0 !important;
    }

    /* Delete button specific positioning - slightly lower */
    .delete-btn {
        margin-top: 1rem !important;
    }

    /* Optional: Add hover effects for better user experience */
    .action-btn:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }
</style>
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
                <div class="container">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Customer Insurance Details</h5>
                        <a href="{{ route('customerinsurance.create') }}" class="btn btn-primary">Add </a>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="customer_filter" class="form-label">Filter by Customer:</label>
                                <select id="customer_filter" class="form-select">
                                    <option value="">All Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="company_filter" class="form-label">Filter by Company:</label>
                                <select id="company_filter" class="form-select">
                                    <option value="">All Companies</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->name ?? $company->insurance_company }}</option>
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
                    </div>

                    <div class="d-flex justify-content-between flex-wrap mb-2">
                        <div id="export-button_info" class="dataTables_info"></div>
                        <div id="export-button_filter" class="dataTables_filter"></div>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="export-button">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>INV</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>WhatsApp</th>
                                        <th>Address</th>
                                        <th>Policy</th>
                                        <th>D/N</th>
                                        <th>Vehicle</th>
                                        <th>Company</th>
                                        <th>Insurance Type</th>
                                        <th>Category</th>
                                        <th>SubCategory</th>
                                        <th>Form Field</th>
                                        <th>Basic</th>
                                        <th>SRCC</th>
                                        <th>TC</th>
                                        <th>Others</th>
                                        <th>Total</th>
                                        <th>Sum Insured</th>
                                        <th>Paid</th>
                                        <th>Outstanding</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Agent</th>
                                        <th>Subagent</th>
                                        <th>Premium Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="d-flex justify-content-between flex-wrap mt-2">
                                <div id="export-button_length" class="dataTables_length"></div>
                                <div id="export-button_paginate" class="dataTables_paginate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script type="text/javascript">
        $(function() {
            var table = $('#export-button').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customerinsurance.index') }}",
                    data: function(d) {
                        d.name = $('#customer_filter').val();
                        d.insurance_company = $('#company_filter').val();

                        // ✅ Add these lines to send the date range
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'inv',
                        name: 'inv'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'whatsapp',
                        name: 'whatsapp'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'policy',
                        name: 'policy'
                    },
                    {
                        data: 'dn',
                        name: 'dn'
                    },
                    {
                        data: 'vehicle',
                        name: 'vehicle'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'insurance_type',
                        name: 'insurance_type'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subcategory',
                        name: 'subcategory'
                    },
                    {
                        data: 'form_field',
                        name: 'form_field'
                    },
                    {
                        data: 'basic',
                        name: 'basic'
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
                        data: 'others',
                        name: 'others'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'sum_insured',
                        name: 'sum_insured'
                    },
                    {
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        data: 'outstanding_amount',
                        name: 'outstanding_amount'
                    },
                    {
                        data: 'from_date',
                        name: 'from_date'
                    },
                    {
                        data: 'to_date',
                        name: 'to_date'
                    },
                    {
                        data: 'agent',
                        name: 'agent'
                    },
                    {
                        data: 'subagent_code',
                        name: 'subagent_code'
                    },
                    {
                        data: 'premium_type',
                        name: 'premium_type'
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
                    },
                ]
            });

            // Reload on filter button
            $('#apply_filters').click(function() {
                table.ajax.reload();
            });

            // Clear filters
            $('#clear_filters').click(function() {
                $('#customer_filter').val('');
                $('#company_filter').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                table.ajax.reload();
            });

            // ✅ Auto-apply filter when customer or company changes
            $('#customer_filter, #company_filter').change(function() {
                table.ajax.reload();
            });

            // ✅ Auto-apply filter when date changes
            $('#from_date, #to_date').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
@endsection
