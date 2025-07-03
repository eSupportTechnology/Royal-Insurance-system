@extends('AdminDashboard.master')

@section('title', 'Profit Margin')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            {{-- Alert messages --}}
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

            {{-- DataTable card --}}
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between">
                    <h5>Profit Margin List</h5>
                    <a href="{{ route('profitMargin.create') }}" class="btn btn-primary">Add Profit Margin</a>
                </div>
                <div class="card-body">
                    <div class="dt-ext table-responsive">
                        <table class="table table-bordered" id="profit-table">
                            <thead>
                                <tr>
                                    <th>SNO</th>
                                    <th>Company</th>
                                    <th>Insurance Type</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Variety Field</th>
                                    <th>Profit Type</th>
                                    <th>Total</th>
                                    <th>RIB</th>
                                    <th>Main Agent</th>
                                    <th>Sub Agent</th>
                                    <th>Actions</th>
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

<script>
    $(document).ready(function () {
        $('#profit-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('profitMargin.index') }}",
            // dom: 'Bfrtip',
            // buttons: ['csv', 'excel', 'pdf', 'print'],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'company', name: 'company.name' },
                { data: 'insurance_type', name: 'insurance_type.name' },
                { data: 'category', name: 'category.name' },
                { data: 'sub_category', name: 'sub_category.name' },
                { data: 'form_field', name: 'form_field.field_name' },
                { data: 'profit_type', name: 'profit_type' },
                { data: 'total', name: 'total' },
                { data: 'rib', name: 'rib' },
                { data: 'main_agent', name: 'main_agent' },
                { data: 'sub_agent', name: 'sub_agent' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
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
