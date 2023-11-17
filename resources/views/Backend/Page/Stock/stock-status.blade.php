@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .btn-view {
        background: #BB4F00 !important;
        border: 2px solid #BB4F00 !important;
    }

    .qr_btn {
        border-radius: 10px;
        padding: 10px;
    }

    .stock-item {
        border: 3px solid #55555533 !important;
        margin-top: 17px;
        border-radius: 28px;
        background-color: #F5F6FE;
        position: relative;
        left: 20px;
        white-space: nowrap;
        overflow-x: inherit;
        transform: translateX(-13px);
    }

    .border-right {
        border-right: 3px solid #55555533;
    }

    .status-tab.selected {
        font-weight: bold;
        text-decoration: underline;
    }

    .status-tab {
        text-align: center;
        transform: translateY(5px);

    }

    .sc {
        transform: translateY(-11px);
    }

    .ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }
</style>
<style>
    /* Custom styles for breadcrumbs */
    .breadcrumbs-dark ol.breadcrumbs {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .breadcrumbs-dark ol.breadcrumbs li {
        font-size: 14px;
        /* Adjust font size as needed */
        color: #555;
        /* Adjust text color as needed */
    }

    .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
        content: ">";
        margin-left: 10px;
        margin-right: 10px;
        color: #777;
    }

    .breadcrumbs-dark ol.breadcrumbs li.text-muted {
        color: #333;
        font-weight: bold;
    }

    .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
        color: #333;
        font-weight: bold;
    }

    .breadcrumbs-dark ol.breadcrumbs li.active a {
        color: #333;
        font-weight: bold;
    }

    .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
        color: blue;
    }
</style>
@endsection
@section('breadcrumbs')
<div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s10 m6 l6">
                <ol class="breadcrumbs mb-2">
                    <li class="text-muted">Dashboard</li>
                    <li class="text-muted">Assets</li>
                    {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                    <li class="active"><a href="{{ url('it-assets-stock') }}">IT-Assets</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">IT Asset</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="product_number">Product Number</label>
                            <input type="text" class="form-control" name="product_number" placeholder="Product Number" id="product_number">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 p-4">
                    <b class="p-4 fs-5">IT ASSET</b>
                </div>
                <div class="col-md-6 text-end p-4">
                    <button class="btn btn-primary qr_btn" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                    <button class="btn btn-primary qr_btn" id="openModalBtn"><img src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>
                    <!-- <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}" alt='...'></button> -->
                </div>
            </div>
            <!-- </div> -->
            <!-- <div class="card-body"> -->
            <div class="row d-flex justify-content-center">
                <!-- Add the tab navigation links -->
                <div class="btn btn-group">
                    <a class="nav-link active status-tab btn btn-primary" href="#danger-instock" aria-selected="true" data-toggle="tab" data-status="in-stock">In Stock</a>
                    <a class="nav-link status-tab btn btn-secondary" href="#danger-allocated" aria-selected="true" data-toggle="tab" data-status="allocated">Allocated</a>
                    <a class="nav-link status-tab btn btn-success" href="#danger-underrepair" aria-selected="true" data-toggle="tab" data-status="underrepair">Under Repair</a>
                    <a class="nav-link status-tab btn btn-info" href="#danger-stolen" aria-selected="true" data-toggle="tab" data-status="stolen">Stolen</a>
                    <a class="nav-link status-tab btn btn-danger" href="#danger-scrapped" aria-selected="true" data-toggle="tab" data-status="scrapped">Scrapped</a>
                    <a class="nav-link status-tab btn btn-warning" href="#danger-lost" aria-selected="true" data-toggle="tab" data-status="scrapped">Transfer</a>

                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
            <!-- </div> -->
            <!-- </div> -->
            <div id="calendarModal" tabindex="-1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Date Range</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="startDate">Start Date:</label>
                                <input type="date" class="form-control" id="modal_start_date" placeholder="Start Date">
                            </div>
                            <div id="modal_calendar"></div>
                            <div class="form-group">
                                <label for="endDate">End Date:</label>
                                <input type="date" class="form-control" id="modal_end_date" placeholder="End Date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="applyFilterBtn">Apply Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Add the tab content container -->
            <div class="tab-content" id="danger-tabContent">
                <!-- Add the tab content for each tab -->
                <div id="danger-instock" class="tab-pane fade show active">
                    <!-- Your table content for "In Stock" tab -->
                    <table class="table table-bordered" id="table-instock">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($stock as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stock->product_number ?? 'N/A' }}</td>
                                <td>{{ $stock->serial_number ?? 'N/A' }}</td>
                                <td>{{ $stock->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $stock->brand->name ?? 'N/A' }}</td>
                                <td>{{ $stock->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $stock->attributes->name??'N/A' }} {{ $stock->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $stock->configuration ?? 'N/A' }}</td>
                                <td>{{ $stock->ageInYears }} years and {{ $stock->ageInMonths }} months</td>
                                <td> ₹{{ $stock->price ?? 'N/A' }}</td>
                                <td>{{$stock->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{ url('timeline', $stock->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="danger-allocated" class="tab-pane fade">
                    <!-- Your table content for "In Stock" tab -->
                    <table class="table table-bordered" id="table-allocated">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allocated as $allocateds)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $allocateds->product_number ?? 'N/A' }}</td>
                                <td>{{ $allocateds->serial_number ?? 'N/A' }}</td>
                                <td>{{ $allocateds->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $allocateds->brand->name ?? 'N/A' }}</td>
                                <td>{{ $allocateds->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $allocateds->attributes->name??'N/A' }} {{ $allocateds->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $allocateds->configuration ?? 'N/A' }}</td>
                                <td>{{ $allocateds->ageInYears }} years and {{ $allocateds->ageInMonths }} months</td>
                                {{-- <td>{{$allocateds->serial_number??''}}</td>
                                <td>{{$allocateds->serial_number??''}}</td>
                                <td>{{$allocateds->serial_number??''}}</td>
                                <td>{{$allocateds->serial_number??''}}</td> --}}
                                <td> ₹{{ $allocateds->price ?? 'N/A' }}</td>
                                <td>{{$allocateds->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{ url('timeline', $allocateds->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="danger-underrepair" class="tab-pane fade">
                    <!-- Your table content for "In Stock" tab -->
                    <table class="table table-bordered" id="table-underrepair">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unrepair as $unrepairs)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unrepairs->product_number ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->serial_number ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->brand->name ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->attributes->name??'N/A' }} {{ $unrepairs->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $unrepairs->configuration ?? 'N/A' }}</td>
                                <td>{{ $unrepairs->ageInYears }} years and {{ $unrepairs->ageInMonths }} months</td>
                                <td> ₹{{ $unrepairs->price ?? 'N/A' }}</td>
                                <td>{{$unrepairs->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{ url('timeline', $unrepairs->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="danger-stolen" class="tab-pane fade">
                    <!-- Your table content for "In Stock" tab -->
                    <table class="table table-bordered" id="table-stolen">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th> Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scrapped as $scrappeds)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $scrappeds->product_number ?? 'N/A' }}</td>
                                <td>{{ $scrappeds->serial_number ?? 'N/A' }}</td>
                                <td>{{ $scrappeds->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $scrappeds->brand->name ?? 'N/A' }}</td>
                                <td>{{ $scrappeds->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $scrappeds->attributes->name??'N/A' }} {{ $scrappeds->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $scrappeds->configuration ?? '' }}</td>
                                <td>{{ $scrappeds->ageInYears }} years and {{ $scrappeds->ageInMonths }} months</td>
                                <td> ₹{{ $scrappeds->price ?? 'N/A' }}</td>
                                <td>{{$scrappeds->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{url('timeline',$scrappeds->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Your table content for "In Stock" tab -->
                <div id="danger-scrapped" class="tab-pane fade">
                    <table class="table table-bordered" id="table-scrapped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stolen as $stolens)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stolens->product_number ?? 'N/A' }}</td>
                                <td>{{ $stolens->serial_number ?? 'N/A' }}</td>
                                <td>{{ $stolens->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $stolens->brand->name ?? 'N/A' }}</td>
                                <td>{{ $stolens->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $stolens->attributes->name??'N/A' }} {{ $stolens->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $stolens->configuration ?? 'N/A' }}</td>
                                <td>{{ $stolens->ageInYears }} years and {{ $stolens->ageInMonths }} months</td>
                                <td> ₹{{ $stolens->price ?? 'N/A' }}</td>
                                <td>{{$stolens->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{url('timeline',$stolens->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="danger-lost" class="tab-pane fade">
                    <table class="table table-bordered" id="table-lost">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Brand Model</th>
                                <th>Attribute</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Price</th>
                                <th>Warranty</th>
                                <th>Timeline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfer as $transfers)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transfers->product_number ?? 'N/A' }}</td>
                                <td>{{ $transfers->serial_number ?? 'N/A' }}</td>
                                <td>{{ $transfers->assetmain->name ?? 'N/A' }}</td>
                                <td>{{ $transfers->brand->name ?? 'N/A' }}</td>
                                <td>{{ $transfers->brandmodel->name ?? 'N/A' }}</td>
                                <td>{{ $transfers->attributes->name??'N/A' }} {{ $transfers->atribute_value??'' }}</td>
                                <td class="ellipsis">{{ $allocateds->configuration ?? 'N/A' }}</td>
                                <td>{{ $transfers->ageInYears }} years and {{ $transfers->ageInMonths }} months</td>
                                <td> ₹{{ $transfers->price ?? 'N/A' }}</td>
                                <td>{{$transfers->product_warranty??'N/A'}}</td>
                                <td>
                                    <form action="{{url('timeline',$transfers->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Repeat the same structure for other tabs -->
            </div>
        </div>
    </div>
</div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection
@section('Script-Area')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    ('.mbtn').on('click', function() {
        ('.modal').alert();
    })
</script>
<script>
$(document).ready(function() {
    $("#openModalBtn").click(function() {
        $("#calendarModal").modal("show");
    });

    $("#applyFilterBtn").click(function() {
        const startDate = $("#modal_start_date").val();
    const endDate = $("#modal_end_date").val();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: "{{ route('filter.data') }}",
        data: {
            start_date: startDate,
            end_date: endDate,
            _token: csrfToken
        },

        success: function(response) {
            $("#calendarModal").modal("hide");

            // Destroy the existing DataTable
            $('#table-instock').DataTable().destroy();

            // Clear the table body
            $('#table-body').empty();

            if (response.length > 0) {
                $.each(response, function(index, data) {
                    var newRow = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + data.product_number + '</td>' +
                        '<td>' + data.assetmain.name + '</td>' +
                        '<td>' + data.brand.name + '</td>' +
                        '<td>' + data.brandmodel.name + '</td>' +
                        '<td>' + data.serial_number + '</td>' +
                        '<td class="ellipsis">' + data.configuration +
                        '</td>' +
                        '<td> ₹' + data.price + '</td>' +
                        '<td><a class="btn btn-primary btn-view" href="' + window.location.origin + '/timeline/' + data.id + '" data-bs-original-title="" title="">View</a></td>';

                    $("#table-body").append(newRow);
                });

                // Reinitialize the DataTable
                $('#table-instock').DataTable();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
    });
});

</script>
<script>
    $(document).ready(function() {
        $('#table-instock').DataTable();
        $('#table-allocated').DataTable();
        $('#table-underrepair').DataTable();
        $('#table-stolen').DataTable();
        $('#table-scrapped').DataTable();
        $('#table-lost').DataTable();
        $('.status-tab').on('click', function(e) {
            e.preventDefault();
            $('.status-tab').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('show active');

            var targetTab = $(this).attr('href');
            $(targetTab).addClass('show active');
        });
        $('.status-tab').on('click', function(e) {
            e.preventDefault();

            $('.status-tab').removeClass('selected');
            $(this).addClass('selected');

            var targetTab = $(this).attr('href');
        });
    });
</script>
@endsection
{{-- @endsection --}}
