@extends('AdminDashboard.master')
@section('title', 'Request Details- Motor Insurance')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Request Details- Motor Insurance</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Request Details- Motor Insurance</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-sm-12">
		<div class="container">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

     @if ($errors->any())
    <div class="alert alert-danger">
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
			<h5>Mail Request Details</h5>
		  </div>
          <form action="{{ route('storemailmotors', $motors->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Company</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="company_id" required>
                                    <option value="" disabled selected>Select Company</option>
                                    @foreach($companies->unique('name') as $company)
                                        <option value="{{ $company->name }}" data-email="{{ $company->email }}">
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Company Email</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="company_email" name="company_email_dropdown">
                                    <option value="" disabled selected>Select Email</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->email }}">
                                            {{ $company->email }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="hidden_company_email" name="company_email" value="">
                                <div id="selected_emails" class="mt-3"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Make</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="make" value="{{ $motors->make }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Year</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="year" value="{{ $motors->year }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="vehicle_number" value="{{ $motors->vehicle_number }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Usage</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="usage" value="{{ $motors->usage }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Vehicle Value (Rs.)</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" id="vehicle_val" name="vehicle_value" type="number" value="{{ $motors->vehicle_value }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Financial Interest (LB Finance)</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="financial_interest" value="{{ $motors->financial_interest }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Fuel Type</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="fuel_type" value="{{ $motors->fuel_type }}" readonly>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="name" value="{{ $motors->name }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">ID Number</label>
                            <div class="col-sm-9">
                                <input class="form-control digits" type="text" name="id_number" value="{{ $motors->id_number }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="col-sm-9 offset-sm-3">
                    <button class="btn btn-primary" type="submit">Send Mail</button>
                    <a href="{{ route('indexxx') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </form>
		</div>
	  </div>
	</div>
  </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const emailSelect = document.getElementById('company_email');
    const selectedEmailsContainer = document.getElementById('selected_emails');
    const hiddenInput = document.getElementById('hidden_company_email');
    let selectedEmails = [];

    emailSelect.addEventListener('change', function () {
        const selectedEmail = emailSelect.value;

        if (!selectedEmails.includes(selectedEmail)) {
            selectedEmails.push(selectedEmail);
            updateHiddenInput();
            displaySelectedEmails();
        }
    });

    function displaySelectedEmails() {
        selectedEmailsContainer.innerHTML = '';
        selectedEmails.forEach(email => {
            const badge = document.createElement('span');
            badge.classList.add('badge', 'badge-info', 'me-2', 'p-2');
            badge.textContent = email;

            const closeButton = document.createElement('button');
            closeButton.classList.add('btn-close', 'btn-sm', 'ms-2');
            closeButton.type = 'button';
            closeButton.onclick = function () {
                selectedEmails = selectedEmails.filter(e => e !== email);
                updateHiddenInput();
                displaySelectedEmails();
            };

            badge.appendChild(closeButton);
            selectedEmailsContainer.appendChild(badge);
        });
    }

    function updateHiddenInput() {
        hiddenInput.value = selectedEmails.join(',');
    }
});

</script>
@endsection
