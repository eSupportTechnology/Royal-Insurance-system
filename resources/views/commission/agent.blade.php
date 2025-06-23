@extends('AdminDashboard.master')

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
                <div class="container">

                </div>

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Agent Commission Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="export-button">
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

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commissionRecords as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->customer_insurance_id }}</td>
                                        <td>{{ $data->customerInsurance->customer->name ?? '-' }}</td>
                                            <td>{{ $data->customerInsurance->company->name ?? '-' }}</td>
                                        <td>{{ $data->agent_rep_code ?? 'N/A' }}</td>
                                        <td>Rs.{{ number_format($data->net_premium, 2) }}</td>
                                        <td>Rs.{{ number_format($data->srcc_premium, 2) }}</td>
                                        <td>Rs.{{ number_format($data->tc_premium, 2) }}</td>
                                        <td><strong>Rs.{{ number_format($data->total, 2) }}</strong></td>
                                        <td>
                                            <span class="badge {{ $data->status == 'Completed' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $data->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- @if ($commissions->!isEmpty())
                                        <tr>
                                            <td colspan="22" class="text-center">No records found.</td>
                                        </tr>
                                    @endif --}}
                                </tbody>
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
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#export-button')) {
                $('#export-button').DataTable().destroy();
            }
            $('#export-button').DataTable({
                dom: 'Bfrtip',
                buttons: ['csv', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endsection
