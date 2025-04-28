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
                <div class="card-header d-flex justify-content-between">
                    <h5>Customer Insurance Details</h5>
                    <a href="{{ route('customerinsurance.create') }}" class="btn btn-primary">Add </a>
                </div>
				<div class="card-body">
					<div class="dt-ext table-responsive">
						<table class="table table-responsive-sm" id="export-button">
							<thead>
								<tr>
                                    <th>ID</th>
                                    <th>INV</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Policy</th>
                                    <th>D/N</th>
                                    <th>Vehicle</th>
                                    <th>Class</th>
                                    <th>Ins./Comp</th>
                                    <th>Rep</th>
                                    <th>Basic</th>
                                    <th>SRCC</th>
                                    <th>TC</th>
                                    <th>Others</th>
                                    <th>Total</th>
                                    <th>Sum Insured</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Introducer Code</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($customerinsurances as $insurance)
                                <tr>
                                    <td>{{ $insurance->id }}</td>
                                    <td>{{ $insurance->inv }}</td>
                                    <td>{{ $insurance->date }}</td>
                                    <td>{{ $insurance->name }}</td>
                                    <td>{{ $insurance->policy }}</td>
                                    <td>{{ $insurance->dn }}</td>
                                    <td>{{ $insurance->vehicle }}</td>
                                    <td>{{ $insurance->class }}</td>
                                    <td>{{ $insurance->insurance_company }}</td>
                                    <td>{{ $insurance->rep }}</td>
                                    <td>{{ $insurance->basic }}</td>
                                    <td>{{ $insurance->srcc }}</td>
                                    <td>{{ $insurance->tc }}</td>
                                    <td>{{ $insurance->others }}</td>
                                    <td>{{ $insurance->total }}</td>
                                    <td>{{ $insurance->sum_insured }}</td>
                                    <td>{{ $insurance->from_date }}</td>
                                    <td>{{ $insurance->to_date }}</td>
                                    <td>{{ $insurance->contact }}</td>
                                    <td>{{ $insurance->address }}</td>
                                    <td>{{ $insurance->introducer_code }}</td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('customerinsurance.show', $insurance->id) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('customerinsurance.edit', $insurance->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('customerinsurance.destroy', $insurance->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($customerinsurances->isEmpty())
                                <tr>
                                    <td colspan="22" class="text-center">No records found.</td>
                                </tr>
                            @endif
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
