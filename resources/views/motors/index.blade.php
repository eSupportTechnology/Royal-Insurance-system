@extends('AdminDashboard.master')

@section('title', 'Dashboard')

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
					<h5><a href="{{route('createmotors')}}" class="btn btn-primary mb-3">add</a></h5>
				</div>
				<div class="card-body">
					<div class="dt-ext table-responsive">
						<table class="display" id="export-button">
							<thead>
								<tr>
                                    <th>SNO</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Vehicle_number</th>
                                    <th>Class</th>
                                    <th>Usage</th>
                                    <th>Vehicle Value</th>
                                    <th>Financial Interest</th>
                                    <th>Fuel Type</th>
                                    <th>Name</th>
                                    <th>ID NO</th>
                                    <th>location</th>
                                    <th>other_details</th>
                                    <th>vehicle_copy</th>
                                    <th>id_copy</th>
                                    <th>renewal_copy</th>
                                    <th>vehical_pic</th>
                                    <th>client_letter</th>
                                    <th>other_doc</th>
                                    <th>status</th>
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
                                    <td>{{ $motor->financial_interest }}</td>
                                    <td>{{ $motor->fuel_type }}</td>
                                    <td>{{ $motor->name }}</td>
                                    <td>{{ $motor->id_number }}</td>
                                    <td>{{ $motor->location }}</td>
                                    <td>{{ $motor->other_details }}</td>
                                    {{-- <td>{{ $motor->vehicle_copy }}</td> --}}

                                    <td>
                                        @if($motor->vehicle_copy)
                                            @foreach(json_decode($motor->vehicle_copy, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($motor->id_copy)
                                            @foreach(json_decode($motor->id_copy, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($motor->renewal_copy)
                                            @foreach(json_decode($motor->renewal_copy, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        @if($motor->vehical_pic)
                                            @foreach(json_decode($motor->vehical_pic, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        @if($motor->client_letter)
                                            @foreach(json_decode($motor->client_letter, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        @if($motor->other_doc)
                                            @foreach(json_decode($motor->other_doc, true) ?? [] as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank">View</a>
                                            @endforeach
                                        @endif
                                    </td>


                                    <td>{{ $motor->status }}</td>
                                    <td>
                                        <a href="{{ route('editmotors', $motor->id) }}" title="Edit">
                                            <i class="icon-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('deletemotors', $motor->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background: none;">
                                                <i class="icon-trash text-danger"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('mailmotors', $motor->id) }}" title="Mail">
                                            <i class="icon-email"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

							</tbody>
							{{-- <tfoot>
								<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Age</th>
									<th>Start date</th>
									<th>Salary</th>
								</tr>
							</tfoot> --}}
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/custom.js')}}"></script>

<script>
    $(document).ready(function () {

        if ($.fn.DataTable.isDataTable('#export-button')) {
            $('#export-button').DataTable().destroy();
        }


        var table = $('#export-button').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { targets: [0, 1, 2, 4, 7,21], visible: true },
                { targets: '_all', visible: false }
            ]
        });


        var isDefaultView = true;
        $('<button type="button" class="btn btn-primary mb-3">+</button>')
            .prependTo('#export-button_wrapper')
            .on('click', function () {
                if (isDefaultView) {

                    table.columns().visible(true);
                } else {

                    table.columns().every(function (index) {
                        var column = this;
                        column.visible([0, 1, 2, 4, 7,21].includes(index));
                    });
                }
                isDefaultView = !isDefaultView;
            });
    });
</script>

@endsection
