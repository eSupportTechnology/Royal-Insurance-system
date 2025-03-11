
@extends('AdminDashboard.master')
@section('title', 'Submit Customer Response')

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

                <div class="card">
                    <div class="card-header">
                        <h5>Submit Customer Response</h5>
                    </div>

                    <form action="{{ route('customerResponses.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Subcategory</label>
                                        <div class="col-sm-9">
                                            <select name="sub_category_id" id="sub_category" class="form-select" required>
                                                <option value="">Select Subcategory</option>
                                                @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select name="customer_id" class="form-select" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <h5 class="mt-3">Responses</h5>
                                <div id="responseFields"></div>

                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('customerResponses.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function () {
    $('#sub_category').change(function () {
        var subCategoryId = $(this).val();
        if (subCategoryId) {
            $.ajax({
                url: "{{ route('customerResponses.create') }}",
                type: "GET",
                data: { sub_category_id: subCategoryId },
                success: function (data) {
                    $('#responseFields').empty(); // Clear previous fields

                    $.each(data, function (index, field) {
                        $('#responseFields').append(`
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">${field.field_name}</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="responses[${index}][field_id]" value="${field.id}">
                                    <input type="text" name="responses[${index}][value]" class="form-control" oninput="this.value = this.value || '';"/>
                                </div>
                            </div>
                        `);
                    });
                }
            });
        } else {
            $('#responseFields').empty();
        }
    });
});

    </script>
@endsection
