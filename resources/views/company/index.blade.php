@extends('AdminDashboard.master')
@section('title', 'Insurance Companies')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/datatable-extension.css') }}">
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

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Insurance Company List</h5>
            <a href="{{ route('company.create') }}" class="btn btn-primary btn-sm">+ Add New Company</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="export-button">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>SNO</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Toggle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    <img src="{{ asset($company->logo) }}" alt="Logo" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $company->address }}</td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->contact_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $company->status ? 'success' : 'warning' }}">
                                        {{ $company->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('company.status', $company->id) }}" class="btn btn-sm btn-outline-{{ $company->status ? 'danger' : 'success' }}">
                                        <i class="fa {{ $company->status ? 'fa-bell-slash-o' : 'fa-bell-o' }}"></i>
                                    </a>
                                </td>
                                <td class="d-flex justify-content-center gap-1 flex-wrap">
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
                                    <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="icon-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('company.delete', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Delete">
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
            $('#export-button').DataTable({
                dom: 'Bfrtip',
                buttons: ['csv', 'excel', 'pdf', 'print'],
                responsive: true
            });
        });
    </script>
@endsection
