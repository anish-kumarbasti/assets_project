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
        }

        .border-right {
            border-right: 3px solid #55555533;
        }

        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .custom-btn {
            font-size: 11px;
            padding: 5px 10px;
            line-height: 1.5;
            pointer-events: none;
        }
    </style>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Assets Components</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header pb-0">
                <div class="row ">
                    <div class="col-md-6 p-4">
                        <h4>Assets Components</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><img
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
                                <th>Specification</th>
                                <th>Age</th>
                                <th>Quantity</th>
                                <th>Allotted</th>
                                <th>Under Repair</th>
                                <th>Scrapped</th>
                                <th>Transferred</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assteComponent as $component)
                                <tr>
                                    <td>{{ $component->id }}</td>
                                    <td>{{ $component->product_number ?? '' }}</td>
                                    <td>{{ $component->assetmain->name ?? '' }}</td>
                                    <td class="ellipsis">{{ $component->specification ?? '' }}</td>
                                    <td>{{ $component->ageInYears }} years and {{ $component->ageInMonths }} months</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $component->quantity ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $allottedCount[$component->product_number] ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $underRepairCount[$component->product_number] ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $scrappedCount }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill badge-light-success">{{ $transferredCount[$component->product_number] ?? 0 }}</span>
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
