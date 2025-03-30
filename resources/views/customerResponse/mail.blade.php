@extends('AdminDashboard.master')

@section('title', 'Send Quotation Request')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Send Quotation Request</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('sendQuotationMail') }}" method="POST">
                @csrf

                <input type="hidden" name="customer_response_id" value="{{ $response->id }}">

                <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Select Companies</label>
                <div class="col-sm-9">
                    <select id="companySelect" class="form-control" name="companies[]" multiple="multiple" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->email }}">{{ $company->name }} ({{ $company->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>


                <div class="mt-4 p-4 border rounded bg-light shadow-sm text-black">
                    <h6 class='mb-3'>Customer Responses</h6>
                    <ul class="list-group">
                        @foreach($response->responseFields as $field)
                            <li class="list-group-item">
                                <strong>{{ $field->formField->field_name }}:</strong>
                                @if($field->formField->field_type === 'file')
                                    <a href="{{ asset('storage/' . $field->response) }}" target="_blank">Download File</a>
                                @else
                                    {{ $field->response }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Send Quotation Request</button>
            </form>

        </div>
    </div>
</div>
@endsection
