@extends('AdminDashboard.master')
@section('title', 'Customer Responses')

@section('content')
<br>
<div class="card">
    <div class="card-header">
        <a href="{{ route('customerResponses.create') }}" class="btn btn-primary mb-3">Add Response</a>
    </div>
    <div class="dt-ext table-responsive">
        <table class="table table-responsive-sm" id="export-button">
            <thead>
                <tr>
                    <th>SNO</th>
                    <th>Customer</th>
                    <th>Subcategory</th>
                    <th>Field</th>
                    <th>Response</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedResponses = $responses->groupBy('subcategory.name'); // Group by subcategory name
                @endphp

                @foreach ($groupedResponses as $subcategoryName => $subcategoryResponses)
                    @php $first = true; @endphp
                    @foreach ($subcategoryResponses as $index => $response)
                        <tr class="subcategory-row {{ !$first ? 'd-none' : '' }}" data-subcategory="{{ Str::slug($subcategoryName) }}">
                            <td>{{ $loop->parent->iteration }}{{ !$first ? '.' . ($index + 1) : '' }}</td>
                            <td>{{ $response->customer->name ?? 'N/A' }}</td>
                            <td>{{ $subcategoryName }}</td>
                            <td>{{ $response->field->field_name }}</td>
                            <td>{{ $response->value }}</td>
                            <td>
                                @if ($first && $subcategoryResponses->count() > 1)
                                    <button class="btn btn-info btn-sm toggle-subcategory"
                                        data-subcategory="{{ Str::slug($subcategoryName) }}">
                                        +
                                    </button>
                                @endif

                                <a href="{{ route('customerResponses.destroy', $response->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        @php $first = false; @endphp
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script>
@endsection
