@extends('AdminDashboard.master')

@section('title', 'Pending Insurance Requests')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatable-extension.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Sent Insurance Requests</h5>
                </div>
                <div class="card-body">
                    <div class="dt-ext table-responsive">
                        <table class="table table-responsive-sm" id="export-button">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Customer Phone</th>
                                    <th>Insurance Type</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customerResponses as $response)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $response->customer_name }}</td>
                                    <td>{{ $response->customer_email }}</td>
                                    <td>{{ $response->customer_phone }}</td>
                                    <td>{{ $response->insuranceType->name ?? 'N/A' }}</td>
                                    <td>{{ $response->category->name ?? 'N/A' }}</td>
                                    <td>{{ $response->subCategory->name ?? 'N/A' }}</td>
                                    <td>{{ $response->status }}</td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('quotation.show', $response->id) }}" class="btn btn-secondary btn-sm" title="View Quotations">
                                            <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('seemore', $response->id) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <form action="{{ route('deletemotors', $response->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
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
<script src="{{asset('frontend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/jszip.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function () {
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
