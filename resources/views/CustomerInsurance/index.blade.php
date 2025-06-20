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
                                    <th>RIB INV Number</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Contact Number</th>
                                    <th>Whatsapp Number</th>
                                    <th>Address</th>
                                    <th>Policy Number</th>
                                    <th>D/N/INV Number</th>
                                    <th>Vehicle/ChassiNo</th>
                                    <th>Company</th>
                                    <th>Insurance Type</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Variety Field</th>
                                    <th>Net Premium</th>
                                    <th>SRCC Premium</th>
                                    <th>TC Premium</th>
                                    <th>Others</th>
                                    <th>Total</th>
                                    <th>Sum Insured</th>
                                    <th>Commencement Date</th>
                                    <th>Expiry Date</th>
                                    <th>Agent Code</th>
                                    <th>SubAgent Code</th>
                                    <th>Premium Type</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($customerinsurances as $insurance)
                                <tr>
                                    <td>{{ $insurance->id }}</td>
                                    <td>{{ $insurance->inv }}</td>
                                    <td>{{ $insurance->date }}</td>
                                    <td>{{ $insurance->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->contact }}</td>
                                    <td>{{ $insurance->whatsapp }}</td>
                                    <td>{{ $insurance->address }}</td>
                                    <td>{{ $insurance->policy }}</td>
                                    <td>{{ $insurance->dn }}</td>
                                    <td>{{ $insurance->vehicle }}</td>
                                    <td>{{ $insurance->company->name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->insuranceType->name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->categories?->name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->subCategory?->name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->formField?->field_name ?? 'N/A' }}</td>
                                    <td>{{ $insurance->basic }}</td>
                                    <td>{{ $insurance->srcc }}</td>
                                    <td>{{ $insurance->tc }}</td>
                                    <td>{{ $insurance->others }}</td>
                                    <td>{{ $insurance->total }}</td>
                                    <td>{{ $insurance->sum_insured }}</td>
                                    <td>{{ $insurance->from_date }}</td>
                                    <td>{{ $insurance->to_date }}</td>
                                    <td>{{ $insurance->agent?->rep_code ?? 'N/A' }}</td>
                                    <td>{{ $insurance->subagent_code }}</td>
                                    <td>{{ $insurance->premium_type }}</td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('customerinsurance.show', $insurance->id) }}" class="btn btn-sm btn-primary">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a href="{{ route('customerinsurance.edit', $insurance->id) }}" class="btn btn-sm btn-warning">
                                            <i class="icon-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('customerinsurance.destroy', $insurance->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <i class="icon-trash"></i>
                                            </button>
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
