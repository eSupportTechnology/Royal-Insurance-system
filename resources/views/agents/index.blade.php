@extends('AdminDashboard.master')
@section('title', 'Agents')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>All Agents List</h5>
                    <a href="{{ route('agents.create') }}" class="btn btn-primary">Add New Agent</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="dt-ext table-responsive">
                        <table class="table table-bordered" id="agent-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Rep Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
@endsection

@section('script')
    <script src="{{ asset('frontend/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('#agent-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('agents.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'rep_code', name: 'rep_code' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
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
