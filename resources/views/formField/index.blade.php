@extends('AdminDashboard.master')

@section('title', 'Sub Categories')

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

                <div class="card">
                    <div class="card-header">
                        <h5><a href="{{ route('formField.create') }}" class="btn btn-primary mb-3">Add</a></h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="table table-responsive-sm" id="export-button">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Sub Category</th>
                                        <th>Field Name</th>
                                        <th>Field Type</th>
                                        <th>Required</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedSubcategories = $formfields->groupBy('subcategory.name');
                                    @endphp

                                    @foreach ($groupedSubcategories as $subcategoryName => $fields)
                                        @php $first = true; @endphp
                                        @foreach ($fields as $index => $formfield)
                                            <tr class="subcategory-row {{ !$first ? 'd-none' : '' }}" data-subcategory="{{ Str::slug($subcategoryName) }}">
                                                <td>{{ $loop->parent->iteration }}{{ !$first ? '.' . ($index + 1) : '' }}</td>
                                                <td>{{ $formfield->subcategory->name ?? 'N/A' }}</td>
                                                <td>{{ $formfield->field_name }}</td>
                                                <td>{{ $formfield->field_type }}</td>
                                                <td>{{ $formfield->required }}</td>
                                                <td>
                                                    @if ($loop->first && $fields->count() > 1)
                                                    <button class="btn btn-info btn-sm toggle-subcategory" data-subcategory="{{ Str::slug($subcategoryName) }}">
                                                        +
                                                    </button>
                                                @endif
                                                
                                                    <a href="{{ route('formField.edit', $formfield->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="icon-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('formField.delete', $formfield->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </form>


                                                </td>
                                            </tr>
                                            @php $first = false; @endphp
                                        @endforeach
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
        $(document).ready(function () {
        $('.toggle-subcategory').click(function () {
            var subcategory = $(this).data('subcategory');
            var rows = $('tr[data-subcategory="' + subcategory + '"]');
            var firstRow = rows.first();

            if ($(this).text().includes("+")) {
                rows.removeClass('d-none');
                $(this).text("-");
            } else {
                rows.not(firstRow).addClass('d-none');
                $(this).text("+");
            }
        });
    });

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
