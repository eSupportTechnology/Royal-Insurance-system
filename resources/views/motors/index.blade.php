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
				<div class="card-header">
					<h5><a href="{{route('createmotors')}}" class="btn btn-primary mb-3">Add</a></h5>
				</div>
				<div class="card-body">
					<div class="dt-ext table-responsive">
						<table class="table table-responsive-sm" id="export-button">
							<thead>
								<tr>
                                    <th>SNO</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Vehicle Number</th>
                                    <th>Class</th>
                                    <th>Usage</th>
                                    <th>Vehicle Value</th>
                                    <th>Status</th>
                                    <th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($motors as $motor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $motor->make }}</td>
                                    <td>{{ $motor->model }}</td>
                                    <td>{{ $motor->year }}</td>
                                    <td>{{ $motor->vehicle_number }}</td>
                                    <td>{{ $motor->class }}</td>
                                    <td>{{ $motor->usage }}</td>
                                    <td>{{ $motor->vehicle_value }}</td>
                                    <td>{{ $motor->status }}</td>
                                    <td>
                                        <a href="{{ route('mailmotors', $motor->id) }}" class="btn btn-primary btn-sm" title="Send Mail">
                                            <i class="icon-envelope"></i>
                                        </a>
                                        <a href="{{ route('indexxx', $motor->id) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a href="{{ route('editmotors', $motor->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="icon-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('deletemotors', $motor->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="icon-trash"></i>
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
