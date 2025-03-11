@extends('AdminDashboard.master')

@section('title', 'Motor Insurance')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatable-extension.css')}}">
@endsection


@section('content')
    <div class="container">
        @if(isset($message))
            <div class="alert alert-warning">{{ $message }}</div>
        @else
            <h2>{{ $subCategory->name }}</h2>

            @if ($formFields->isEmpty())
                <div class="alert alert-warning">No form fields available.</div>
            @else
                <form action="" method="POST">
                    @csrf
                    @foreach ($formFields as $field)
                        <div class="mb-3">
                            <label for="{{ $field->id }}">{{ $field->field_name }}</label>

                            {{-- @if ($field->field_type === 'text')
                                <input type="text" name="fields[{{ $field->id }}]" class="form-control" required="{{ $field->required }}">
                            @elseif ($field->field_type === 'number')
                                <input type="number" name="fields[{{ $field->id }}]" class="form-control" required="{{ $field->required }}">
                            @elseif ($field->field_type === 'checkbox')
                                <input type="checkbox" name="fields[{{ $field->id }}]" value="1">
                            @elseif ($field->field_type === 'select')
                                <select name="fields[{{ $field->id }}]" class="form-control">
                                    <option value="">Select an option</option>
                                    <!-- Populate options dynamically if needed -->
                                </select>
                            @endif --}}
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            @endif
        @endif
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
