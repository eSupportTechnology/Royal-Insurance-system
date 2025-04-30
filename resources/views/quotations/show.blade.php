@extends('AdminDashboard.master')

@section('title', 'Quotation Comparison')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .table thead th {
        background-color: #f8f9fa;
        text-align: center;
    }
    td, th {
        vertical-align: middle !important;
    }
    .add-row-btn {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Quotation Comparison - {{ $response->customer_name }}</h4>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $response->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $response->customer_phone }}</p>
            <p><strong>Insurance Type:</strong> {{ $response->insuranceType->name ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $response->category->name ?? 'N/A' }}</p>
            <p><strong>Subcategory:</strong> {{ $response->subCategory->name ?? 'N/A' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('quotation.save', $response->id) }}">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="quotationTable">
                <thead>
                    <tr>
                        <th style="width: 150px;">Package Name</th>
                        @foreach($companies as $company)
                            <th>
                                <img src="{{ asset($company->logo) }}" class="company-logo mb-1" style="height:40px;"><br>
                                {{ $company->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="quotationBody">
                    @php
                        $grouped = $details->groupBy('package_name');
                    @endphp
                    @forelse($grouped as $packageName => $group)
                        <tr>
                            <td>
                                <input type="text" name="packages[{{ $packageName }}][label]" class="form-control" value="{{ $packageName }}">
                            </td>
                            @foreach($companies as $company)
                                @php
                                    $cell = $group->where('company_id', $company->id)->first();
                                @endphp
                                <td>
                                    <textarea name="packages[{{ $packageName }}][{{ $company->id }}]" class="form-control" rows="4">{{ $cell->package_description ?? '' }}</textarea>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <input type="text" name="packages[Package 1][label]" class="form-control" value="Package 1">
                            </td>
                            @foreach($companies as $company)
                                <td>
                                    <textarea name="packages[Package 1][{{ $company->id }}]" class="form-control" rows="4"></textarea>
                                </td>
                            @endforeach
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <button type="button" class="btn btn-outline-primary" id="addRowBtn"><i class="bi bi-plus-circle"></i> Add Row</button>
            <button type="submit" class="btn btn-primary float-end">Save Quotations</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    let rowIndex = {{ $grouped->count() + 1 }};
    const companies = @json($companies);

    document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('quotationBody');
        const newRow = document.createElement('tr');
        const packageKey = `Package ${rowIndex}`;

        let rowHtml = `<td><input type="text" name="packages[${packageKey}][label]" class="form-control" value="${packageKey}"></td>`;
        companies.forEach(company => {
            rowHtml += `<td><textarea name="packages[${packageKey}][${company.id}]" class="form-control" rows="4"></textarea></td>`;
        });

        newRow.innerHTML = rowHtml;
        tbody.appendChild(newRow);
        rowIndex++;
    });
</script>
@endsection
