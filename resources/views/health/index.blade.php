@extends('AdminDashboard.master')

@section('title', 'HTML 5 Data Export')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatable-extension.css')}}">
@endsection

@section('breadcrumb-title')
<h3></h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Data Tables</li>
<li class="breadcrumb-item active"></li>
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
				<div class="card-header">
					<h5><a href="{{route('health.create')}}" class="btn btn-primary mb-3">add</a></h5>
				</div>

				<div class="card-body">
					<div class="dt-ext table-responsive">
						<table class="table table-responsive-sm" id="export-button">
							<thead>
								<tr>
                                    <th>SNO</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>NIC</th>
                                    <th>Address</th>
                                    <th>Weight</th>
                                    <th>Contact</th>
                                    <th>Blood Group</th>
                                    <th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($helths as $helth)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $helth->name }}</td>
                                    <td>{{ $helth->age }}</td>
                                    <td>{{ $helth->nic }}</td>
                                    <td>{{ $helth->address }}</td>
                                    <td>{{ $helth->weight }}</td>
                                    <td>{{ $helth->contact_number }}</td>
                                    <td>{{ $helth->blood_group }}</td>
                                    <td>
                                        <a href="{{ route('health.edit', $helth->id) }}" title="Edit">
                                            <i class="icon-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('health.delete', $helth->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background: none;">
                                                <i class="icon-trash text-danger"></i>
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
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/datatable/datatable-extension/custom.js')}}"></script>
@endsection
