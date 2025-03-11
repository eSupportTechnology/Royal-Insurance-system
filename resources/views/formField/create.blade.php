
@extends('AdminDashboard.master')
@section('title', 'Create Sub Category')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Form Controls</li>
    <li class="breadcrumb-item active">Insurance Form Field</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h5>Add Details</h5>

                    </div>

                    <form action="{{ route('formField.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <div class="mb-3 col-6">
                                <select class="form-select" name="sub_category_id" id="sub_category_id" required>
                                    <option value="">Select Insurance Sub Category</option>
                                    @foreach ($subcategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="dt-ext table-responsive">
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Field Name</th>
                                            <th>Field Type</th>
                                            <th class="text-center">Required</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="formFields">
                                        <tr>
                                            <td>
                                                <input type="text" name="field_name[]" class="form-control"
                                                    placeholder="Enter field name" required />
                                            </td>
                                            <td>
                                                <select name="field_type[]" class="form-control">
                                                    <option value="text">Text</option>
                                                    <option value="number">Number</option>
                                                    <option value="password">Password</option>
                                                    <option value="email">Email</option>
                                                    <option value="tel">Phone</option>
                                                    <option value="date">Date</option>
                                                    <option value="time">Time</option>
                                                    <option value="datetime-local">Date & Time</option>
                                                    <option value="month">Month</option>
                                                    <option value="week">Week</option>
                                                    <option value="url">URL</option>
                                                    <option value="hidden">Hidden</option>
                                                    <option value="select">Dropdown</option>
                                                    <option value="checkbox">Checkbox</option>
                                                    <option value="radio">Radio</option>
                                                    <option value="file">File Upload</option>
                                                    <option value="color">Color Picker</option>
                                                    <option value="range">Range Slider</option>
                                                    <option value="search">Search Box</option>
                                                    <option value="textarea">Textarea</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="required[]" value="1"
                                                    class="form-check-input" />
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger remove-row">X</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-end">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="button" id="addRow" class="btn btn-success">
                                        + Add Field
                                    </button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formFields = document.getElementById("formFields");
        const addRowButton = document.getElementById("addRow");

        // Function to add new row
        addRowButton.addEventListener("click", function() {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
              <td><input type="text" name="field_name[]" class="form-control" placeholder="Enter field name" required></td>
              <td>
                  <select name="field_type[]" class="form-control">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="email">Email</option>
                    <option value="tel">Phone</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="datetime-local">Date & Time</option>
                    <option value="month">Month</option>
                    <option value="week">Week</option>
                    <option value="url">URL</option>
                    <option value="hidden">Hidden</option>
                    <option value="select">Dropdown</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                    <option value="file">File Upload</option>
                    <option value="color">Color Picker</option>
                    <option value="range">Range Slider</option>
                    <option value="search">Search Box</option>
                    <option value="textarea">Textarea</option>
                </select>

              </td>
              <td class="text-center">
                  <input type="checkbox" name="required[]" value="1" class="form-check-input">
              </td>
              <td class="text-center">
                  <button type="button" class="btn btn-danger remove-row">X</button>
              </td>
          `;
            formFields.appendChild(newRow);
        });

        // Remove row when clicking "X" button
        formFields.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-row")) {
                event.target.closest("tr").remove();
            }
        });

        // Form submission (basic validation)
        document
            .getElementById("dynamicForm")
            .addEventListener("submit", function(event) {
                event.preventDefault();

                let isValid = true;
                let inputs = document.querySelectorAll(
                    "#dynamicForm input[name='field_name[]']"
                );

                inputs.forEach((input) => {
                    if (input.value.trim() === "") {
                        isValid = false;
                    }
                });

                if (isValid) {
                    document
                        .getElementById("successMessage")
                        .classList.remove("d-none");
                    document.getElementById("errorMessage").classList.add("d-none");
                } else {
                    document.getElementById("successMessage").classList.add("d-none");
                    document
                        .getElementById("errorMessage")
                        .classList.remove("d-none");
                }
            });
    });
</script>

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
