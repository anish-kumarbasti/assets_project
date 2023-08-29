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
            overflow-x:inherit;
            transform: translateX(-13px);
        }

        .border-right {
            border-right: 3px solid #55555533;
        }

        .status-tab.selected {
            /* background-color: #ffffff; */
            /* Set the background color you want for selected tab */
            font-weight: bold;
            text-decoration: underline;
            /* Optional: Adjust the style as needed */
            /* Add any other styles to indicate selection */
        }
        .status-tab{
            text-align: center;
            transform: translateY(5px);

        }
        .sc{
            transform: translateY(-11px);
        }
    </style>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card">
                    <div class="card-head">
                    <div class="row">
                        <div class="col-md-6 p-4">
                            <b class="p-4 fs-5">IT ASSET</b>
                        </div>
                        <div class="col-md-6 text-end p-4">
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                            <button class="btn btn-primary qr_btn" id="openModalBtn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}"
                                    alt='...'></button>
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}"
                                    alt='...'></button>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="row d-flex justify-content-center stock-item mb-3">
                                <!-- Add the tab navigation links -->
                                <div class="col-md-12 d-flex justify-content-center flex-nowrap">
                                    <div class="col-md-2 border-right">
                                        <a class="nav-link active status-tab" href="#danger-instock" aria-selected="true"
                                            data-toggle="tab" data-status="in-stock">In Stock</a>
                                    </div>
                                    <div class="col-md-2 border-right">
                                        <a class="nav-link status-tab" href="#danger-allocated" aria-selected="true"
                                            data-toggle="tab" data-status="allocated">Allocated</a>
                                    </div>
                                    <div class="col-md-2 border-right">
                                        <a class="nav-link status-tab" href="#danger-underrepair" aria-selected="true"
                                            data-toggle="tab" data-status="underrepair">Under Repair</a>
                                    </div>
                                    <div class="col-md-2 border-right">
                                        <a class="nav-link status-tab" href="#danger-stolen" aria-selected="true"
                                            data-toggle="tab" data-status="stolen">Stolen
                                    </div>
                                    <div class="col-md-2 border-right">
                                        <a class="nav-link status-tab sc" href="#danger-scrapped" aria-selected="true"
                                            data-toggle="tab" data-status="scrapped">Scrapped</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="nav-link status-tab" href="#danger-lost" aria-selected="true"
                                            data-toggle="tab" data-status="scrapped">Lost</a>
                                    </div>
                                    <!-- Repeat the same structure for other tabs -->
                                </div>
                            </div>
                            </div>
                </div>
                <div class="modal" id="calendarModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Date Range</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="modal_start_date" placeholder="Start Date">
                                <input type="text" id="modal_end_date" placeholder="End Date">
                                <div id="modal_calendar"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>

                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stock as $stock)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>a23</td>
                                    <td>{{$stock->assetmain->name??''}}</td>
                                    <td>{{$stock->brandmodel->name??''}}</td>

                                    <td>{{$stock->serial_number}}</td>

                                    <td>{{$stock->configuration}}</td>
                                    <td> ₹{{$stock->price}}</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
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
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>
                                    <th>User ID</th>
                                    <th>User</th>
                                    <th>Deparment</th>
                                    <th>Designation</th>

                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>
                                    <td>125a5</td>
                                    <td>Anoop</td>
                                    <td>IT</td>
                                    <td>CEO</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>
                                    <td>125a5</td>
                                    <td>Anoop</td>
                                    <td>IT</td>
                                    <td>CEO</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>
                                    <td>125a5</td>
                                    <td>Anoop</td>
                                    <td>IT</td>
                                    <td>CEO</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="danger-underrepair" class="tab-pane fade">
                        <!-- Your table content for "In Stock" tab -->
                        <table class="table table-bordered" id="table-underrepair">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>
                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="danger-stolen" class="tab-pane fade">
                        <!-- Your table content for "In Stock" tab -->
                        <table class="table table-bordered" id="table-stolen">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>
                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Your table content for "In Stock" tab -->
                    <div id="danger-scrapped" class="tab-pane fade">
                        <table class="table table-bordered" id="table-scrapped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>

                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="danger-lost" class="tab-pane fade">
                        <table class="table table-bordered" id="table-lost">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Asset</th>
                                    <th>Model</th>
                                    <th>Brand</th>

                                    <th>Serial Number</th>
                                    <th>Configuration</th>

                                    <th>Price</th>
                                    <th>Timeline</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>a23</td>
                                    <td>Laptop</td>
                                    <td>Inspiron</td>
                                    <td>Dell</td>
                                    <td>0123456789</td>

                                    <td>Processor: Intel Core i5-1235U
                                        12th Generation
                                        (up to 4.40 GHz, 12MB 10 Cores)
                                        RAM & Storage: 8GB</td>
                                    <td> ₹62,443</td>

                                    <td>
                                        <a class="btn btn-primary btn-view" href="{{url('timeline')}}" data-bs-original-title=""
                                            title="">View</a>
                                    </td>
                                </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables for each tab
            $('#table-instock').DataTable();
            $('#table-allocated').DataTable();
            $('#table-underrepair').DataTable();
            $('#table-stolen').DataTable();
            $('#table-scrapped').DataTable();
            $('#table-lost').DataTable();
            // Repeat this for other tables

            // Handle tab switching
            $('.status-tab').on('click', function(e) {
                e.preventDefault();

                // Remove 'active' class from all tabs
                $('.status-tab').removeClass('active');
                // Add 'active' class to the clicked tab
                $(this).addClass('active');

                // Hide all tables
                $('.tab-pane').removeClass('show active');

                // Show the corresponding table based on the clicked tab's data-status attribute
                var targetTab = $(this).attr('href');
                $(targetTab).addClass('show active');
            });
            $('.status-tab').on('click', function(e) {
                e.preventDefault();

                // Remove 'selected' class from all tabs
                $('.status-tab').removeClass('selected');
                // Add 'selected' class to the clicked tab
                $(this).addClass('selected');

                // Handle tab content switching (if required)
                var targetTab = $(this).attr('href');
                // ... Your code to switch tab content ...
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#openModalBtn").click(function() {
                $("#calendarModal").modal("show");
                initDatePicker();
            });

            $("#applyFilterBtn").click(function() {
                const startDate = $("#modal_start_date").val();
                const endDate = $("#modal_end_date").val();

                // Perform filtering based on startDate and endDate
                console.log("Selected date range:", startDate, "to", endDate);

                // Close the modal
                $("#calendarModal").modal("hide");
            });

            function initDatePicker() {
                $("#modal_start_date").datepicker({
                    onSelect: function(selectedDate) {
                        $("#modal_end_date").datepicker("option", "minDate", selectedDate);
                    }
                });

                $("#modal_end_date").datepicker({
                    onSelect: function(selectedDate) {
                        $("#modal_start_date").datepicker("option", "maxDate", selectedDate);
                    }
                });

                $("#modal_calendar").datepicker({
                    onSelect: function(dateText) {
                        // Update the input fields when a date is selected
                        $("#modal_start_date").datepicker("setDate", dateText);
                        $("#modal_end_date").datepicker("setDate", dateText);
                    }
                });
            }
        });
    </script>
@endsection


{{-- @endsection --}}
