@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .text-p {
            font-size: 15px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css') }}">
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
                        <li class="active"><a href="{{ url('assets-software') }}">Assets Software</a></li>
                    </ol>
                </div>
            </div>
        </div>
     </div>
     @endsection
@section('Content-Area')
    <div class="modal fade" id="columnSelectionModal" tabindex="-1" role="dialog" aria-labelledby="columnSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnSelectionModalLabel">Select Columns to Display</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="columnSelectionForm">
                        @foreach ($columns as $columnName)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="column_{{ $loop->index }}"
                                    name="column[]" value="{{ $columnName }}" checked>
                                <label class="form-check-label" for="column_{{ $loop->index }}">{{ $columnName }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applyColumns">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row ">
                    <div class="col-md-6 p-4">
                        <h4>Assets Software</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn"><img
                                src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Asset</th>
                                <th>Liscence Number</th>
                                <th>Configuration</th>
                                <th>Age</th>
                                <th>Quantity</th>
                                <th>In-stock</th>
                                <th>Allocate</th>
                                <th>Allocations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($softwareData as $key => $software)
                                <tr>
                                    <td>{{ $software->id }}</td>
                                    <td>{{ $software->product_number ?? '' }}</td>
                                    <td>{{ $software->product_info ?? '' }}</td>
                                    <td>{{ $software->liscence_number ?? '' }}</td>
                                    <td>{{ $software->configuration ?? '' }}</td>
                                    <td>{{ $software->ageInYears }} years and {{ $software->ageInMonths }} months</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $software->quantity ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $availableQuantity[$key] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill badge-light-success">{{ $allottedCount }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('show.allocation', $software->id) }}" method="post">
                                            @csrf
                                            <button class="btn btn-primary btn-view" type="submit"
                                                data-bs-original-title="" title="">View</button>
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
@endsection
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.qr_btn').click(function () {
            $('#columnSelectionModal').modal('show');
        });
        $('#applyColumns').click(function () {
            var selectedColumns = $('#columnSelectionForm input:checked').map(function () {
                return $(this).val();
            }).get();
            $('#basic-1 th').each(function (index, th) {
                var columnName = $(th).text();
                if (selectedColumns.includes(columnName)) {
                    $(th).show();
                    $('td:nth-child(' + (index + 1) + ')').show();
                } else {
                    $(th).hide();
                    $('td:nth-child(' + (index + 1) + ')').hide();
                }
            });
            $('#columnSelectionModal').modal('hide');
        });
    });
</script>
@endsection
