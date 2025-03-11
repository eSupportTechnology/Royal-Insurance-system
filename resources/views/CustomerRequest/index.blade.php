@extends('AdminDashboard.master')

@section('title', 'Motor Insurance')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/datatable-extension.css')}}">
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
            <div class="container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>

			<div class="card">
				<div class="card-body">
                    <!-- Search Bar -->
                    <div class="mb-3">
                        <input type="text" id="search-bar" class="form-control" placeholder="Search by Customer Name...">
                    </div>

					<div class="dt-ext table-responsive">
						<table class="table table-responsive-sm" id="export-button">
							<thead>
								<tr>
                                    <th>SNO</th>
                                    <th>Customer Name</th>
                                    <th>Customer NIC</th>
                                    <th>Company Name</th>
                                    <th>Company Mail</th>
                                    <th>Date</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request->customer ? $request->customer->name : 'Unknown' }}</td>
                                    <td>{{ $request->nic }}</td>
                                    <td>{{ $request->company_id }}</td>
                                    <td>
                                        @foreach(explode(',', $request->company_email) as $email)
                                            {{ trim($email) }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $request->created_at }}</td>
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
        // Initialize DataTable
        var table = $('#export-button').DataTable({
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print'],
            "searching": true, // Enable global search functionality
            "columnDefs": [{
                // Make sure to allow searching only on "Customer Name" column
                "targets": [1], // Index 1 is the "Customer Name" column
                "searchable": true
            }]
        });

        // Bind the search input to search the "Customer Name" column (index 1)
        $('#search-bar').on('keyup', function () {
            // Search in the "Customer Name" column (index 1) only
            table.columns(1).search(this.value).draw(); // Index 1 corresponds to "Customer Name"
        });
    });
</script>
@endsection
