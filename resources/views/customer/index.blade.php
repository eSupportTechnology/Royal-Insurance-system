@extends('AdminDashboard.master')

@section('title', 'Customers')

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

			<div class="card mt-3">
				<div class="card-header">
					<h5><a href="{{route('create-customer')}}" class="btn btn-primary ">Add</a></h5>
				</div>
				<div class="card-body">
					<div class="dt-ext table-responsive">
						<table class="table table-responsive-sm" id="export-button">
							<thead>
								<tr>
                                    <th>SNO</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>NIC</th>
                                    <th>Location</th>
                                    <th>Insurance Coverages</th>
                                    <th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($newcustomers as $newcustomer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $newcustomer->name }}</td>
                                    <td>{{ $newcustomer->email }}</td>
                                    <td>{{ $newcustomer->phone }}</td>
                                    <td>{{ $newcustomer->nic }}</td>
                                    <td>{{ $newcustomer->address }}</td>
                                    <td>{{ $customerResponses[$newcustomer->id] ?? 0 }}</td>

                                    <td>
                                        <a href="{{ route('view-customer', $newcustomer->id) }}" class="btn btn-primary btn-sm" title="View">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a href="{{ route('edit-customer', $newcustomer->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="icon-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('delete-customer', $newcustomer->id) }}" method="POST" style="display:inline;">
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
