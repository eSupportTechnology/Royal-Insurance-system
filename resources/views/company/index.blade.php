@extends('AdminDashboard.master')
@section('title', 'Insurance Companies')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Insurance Companies</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data Tables</li>
    <li class="breadcrumb-item active">Insurance Companies</li>
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
                        <h5>Insurance Company List</h5>
                        <a href="{{ route('company.create') }}" class="btn btn-primary">Add New Company</a>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="export-button">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Name</th>
                                        <th>Logo</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Active/Inactive</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td><img src="{{ asset($company->logo) }}" alt="Company Logo" width="50">
                                            </td>
                                            <td>{{ $company->address }}</td>
                                            <td>{{ $company->email }}</td>
                                            <td>{{ $company->contact_number }}</td>

                                            <td>
                                                @if ($company->status == 0)
                                                    <span class="badge bg-warning">Inactive</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($company->status == 0)
                                                    <a href="{{ route('company.status', $company->id) }}"
                                                        class="btn btn-success btn-sm" title="Activate">
                                                        <i class="fa fa-bell-slash-o"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('company.status', $company->id) }}"
                                                        class="btn btn-success btn-sm" title="Deactivate">
                                                        <i class="fa fa-bell-o"></i>
                                                    </a>
                                                @endif

                                            </td>
                                            <td class="d-flex align-items-center gap-2">
                                                @if (!$company->pinned)
                                                    <a href="{{ route('company.pin', $company->id) }}"
                                                        class="btn btn-primary btn-sm" title="Pin">
                                                        <i class="icon-pin-alt"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('company.pin', $company->id) }}"
                                                        class="btn btn-primary btn-sm" title="Unpin">
                                                        <i class="fa fa-thumb-tack"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('company.edit', $company->id) }}"
                                                    class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="icon-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('company.delete', $company->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')" title="Delete">
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
