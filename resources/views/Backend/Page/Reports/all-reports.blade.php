@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
     .add-category-button {
            background-color: transparent;
            border: 1px solid #37236B;
            color: #37236B;
            padding: 10px 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 10px;
        }

        .add-category-button:hover {
            background-color: #37236B;
            color: #fff;
        }
    .status-tab {
        text-align: center;
        font-size: 10px;
        transform: translateY(5px);

    }
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }
    .ellipsis {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 150px;
   }
   #basic {
    display: none;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
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
                    <li class="text-muted">Reports</li>
                    {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                    <li class="active"><a href="{{ url('all-reports') }}">All Reports</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Content-Area')
<div class="col-sm-12">
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Search Type Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
            <div class="col-sm-6">
                <button class="add-category-button" style="margin-top: 2px;" id="showStatus">Select Status</button>&nbsp;
                {{-- <button class="add-category-button" style="margin-top: 2px;" id="showEmp">Employee Code</button>&nbsp; --}}
                <button class="add-category-button" style="margin-top: 2px;" id="showAssetCode">Employee & Asset Code</button>&nbsp;
            </div>
            <div class="col-sm-6">
                <button class="add-category-button" style="margin-top: 2px;" id="showAssetCategory">Select Location</button>&nbsp;
                {{-- <button class="add-category-button" style="margin-top: 2px;" id="Transaction">Transaction Code</button>&nbsp; --}}
                <button class="add-category-button" style="margin-top: 2px;" id="showAsset">Select Asset</button>&nbsp;
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="card">
    <div class="card-header pb-0">
        <div class="row">
            <div class="col-sm-6 p-3">
                <h4>Reports</h4>
            </div>
            <div class="col-sm-6 p3 text-end">
                <button class="add-category-button qr_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Category</button>
            </div>
        </div>
    </div>
    {{-- @dd(session('data1','data2','data3','data4')) --}}
    <div class="card-body">
        <form class="search-form" action="{{route('search-reports')}}" method="GET">
            @csrf
            <div class="row p-3">
                <div class="col-sm-4 mb-3">
                    <label for="asset">Select Asset Type <b style="color: red;">*</b></label>
                    <select id="assettype" class="form-select" name="assettype" aria-label="Default select example">
                        <option value="">All Asset Type</option>
                        @foreach ($assettype as $assettypes)
                        <option value="{{$assettypes->id}}">{{$assettypes->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="start_date">Transaction From</label>
                    <input type="date" class="form-control" name="start_date" id="dateInput">
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="end_date">To Transaction</label>
                    <input type="date" class="form-control" name="end_date" id="dateInputs">
                </div>
                <div class="col-sm-4 mb-3" id="addLocation" style="display: none;">
                    <label for="location">Select Location</label>
                    <select id="location" class="form-select" name="location" aria-label="Default select example">
                        <option value="">All Location</option>
                        @foreach ($location as $locations)
                        <option value="{{$locations->id}}">{{$locations->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mb-3" id="addAsset" style="display: none;">
                    <label for="asset">Select Asset </label>
                    <select id="asset" class="form-select" name="asset" aria-label="Default select example">
                        <option value="">All Asset</option>
                        @foreach ($asset as $assets)
                        <option value="{{$assets->id}}">{{$assets->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mb-3" id="addStatus" style="display: none;">
                    <label for="status">Select Status</label>
                    <select id="status" class="form-select" name="status" aria-label="Default select example">
                        <option value="">All Status</option>
                        @foreach ($status as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mb-3" id="addEmp" style="display: none;">
                    <label for="employee_id">Employee Code</label>
                    <input type="text" class="form-control" name="employee_id" id="employee_id">
                </div>
                <div class="col-sm-4 mb-3" id="addAssetcode" style="display: none;">
                    <label for="product_number">Asset Code</label>
                    <input type="text" name="product_number" class="form-control" id="product_number">
                </div>
                {{-- <div class="col-sm-4 mb-3" id="transaction" style="display: none;">
                    <label for="transaction_code">Transaction Code</label>
                    <input type="text" name="transaction_code" class="form-control" id="transaction_code">
                </div> --}}
            </div>
            <div class="col-sm-12 text-end mb-3">
                <button class="btn btn-warning">Search</button>
            </div>
        </form>
    </div>
@if(isset($data1))
<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between">
        <div class="btn btn-group">
            <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
            <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
            <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data1')])}}">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data1')])}}"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <div class="card-body">
    <div class="col-sm-12 basic">
    <div class="table-responsive theme-scrollbar">
        <table class="display" id="basic-1">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Asset Code</th>
                    <th>Serial Number</th>
                    <th>Asset Type</th>
                    <th>Asset</th>
                    <th>Brand</th>
                    <th>Brand Model</th>
                    <th>Attribute</th>
                    <th>Configuration</th>
                    {{-- <th>Age</th> --}}
                    <th>Price</th>
                    <th>Status</th>
                    <th>Warranty</th>
                    {{-- <th>Timeline</th> --}}
                </tr>
            </thead>
            <tbody>

                @foreach ($data1 as $asset)
                <tr class="copy-content text-center">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$asset->product_number??'N/A'}}</td>
                    <td>{{$asset->serial_number??'N/A'}}</td>
                    <td>{{$asset->asset_type->name??'N/A'}}</td>
                    {{-- <td class="ellipsis">{{$asset->specification??'N/A'}} <p>{{$asset->attributes->name??'N/A'}}</p></td> --}}
                    <td>{{$asset->assetmain->name??'N/A'}}</td>
                    <td>{{$asset->brand->name??'N/A'}}</td>
                    <td>{{$asset->brandmodel->name??'N/A'}}</td>
                    {{-- <td>{{\Carbon\Carbon::parse($asset->created_at)->format('d-m-y')??'N/A'}}</td> --}}
                    <td>{{ $asset->attributes->name??'N/A' }} {{ $asset->atribute_value??'' }}</td>
                    <td class="ellipsis">{{ $asset->configuration ?? 'N/A' }}</td>
                    {{-- <td>{{ $stock->ageInYears }} years and {{ $stock->ageInMonths }} months</td> --}}
                    <td> ₹{{ $asset->price ?? 'N/A' }}</td>
                    <td><span class=" custom-btn  {{$asset->statuses->status??''}}"> {{$asset->statuses->name??'N/A'}}</span></td>
                    <td>{{$asset->product_warranty??'N/A'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endif
@if(isset($data2))
<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between">
        <div class="btn btn-group">
            <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
            <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
            <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data2')])}}">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data2')])}}"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <div class="card-body">
    <div class="col-sm-12 basic">
    <div class="table-responsive theme-scrollbar">
        <table class="display" id="basic-1">
            <thead>
                <tr>
                   <th>SL</th>
                   <th>Asset Code</th>
                   <th>Asset</th>
                   <th>Asset Type</th>
                   <th>Brand</th>
                   <th>Brand Model</th>
                   <th>Specification</th>
                   <th>Age</th>
                   <th>Quantity</th>
                   <th>In-stock</th>
                   <th>Allocate</th>
                   <th>Under Repair</th>
                   <th>Stolen</th>
                   <th>Scraped</th>
                   {{-- <th>Status</th> --}}
                </tr>
             </thead>
             <tbody>
                @foreach ($data2 as $key => $nonit)
                <tr>
                   <td>{{$nonit->id}}</td>
                   <td>{{$nonit->product_number??''}}</td>
                   <td>{{$nonit->assetmain->name??'' }}</td>
                   <td>{{$nonit->asset_type->name??'' }}</td>
                   <td>{{$nonit->brand->name??'' }}</td>
                   <td>{{$nonit->brandmodel->name??'' }}</td>
                   <td class="ellipsis">{{$nonit->specification??''}}</td>
                   <td>{{ $nonit->ageInYears }} years and {{ $nonit->ageInMonths }} months</td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$nonit->quantity??''}}</span>
                   </td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$availableQuantity[$key]}}</span>
                   </td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$allottedCount}}</span>
                   </td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$underRepairCount}}</span>
                   </td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$scrappedCount}}</span>
                   </td>
                   <td>
                      <span class="badge rounded-pill badge-light-success">{{$scrappedCount}}</span>
                   </td>
                   {{-- <td><span class=" custom-btn  {{$nonit->statuses->status??''}}"> {{$nonit->statuses->name??'N/A'}}</span></td> --}}
                </tr>
                @endforeach

             </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endif
@if(isset($data3))
<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between">
        <div class="btn btn-group">
            <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
            <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
            <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data3')])}}">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data3')])}}"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <div class="card-body">
    <div class="col-sm-12 basic">
    <div class="table-responsive theme-scrollbar">
        <table class="display" id="basic-1">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Asset Code</th>
                    <th>Asset</th>
                    <th>Asset Type</th>
                    <th>Liscence Number</th>
                    <th>Configuration</th>
                    <th>Age</th>
                    <th>Quantity</th>
                    <th>In-stock</th>
                    <th>Allocate</th>
                    {{-- <th>Status</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data3 as $key => $software)
                    <tr>
                        <td>{{ $software->id }}</td>
                        <td>{{ $software->product_number ?? '' }}</td>
                        <td>{{ $software->assetmain->name ?? '' }}</td>
                        <td>{{$software->asset_type->name??'' }}</td>
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
                        {{-- <td><span class=" custom-btn  {{$software->statuses->status??''}}"> {{$software->statuses->name??'N/A'}}</span></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endif
@if(isset($data4))
<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between">
        <div class="btn btn-group">
            <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
            <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
            <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data4')])}}">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data4')])}}"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <div class="card-body">
    <div class="col-sm-12 basic">
    <div class="table-responsive theme-scrollbar">
        <table class="display" id="basic-1">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Asset Code</th>
                    <th>Asset</th>
                    <th>Asset Type</th>
                    <th>Brand</th>
                    <th>Brand Model</th>
                    <th>Specification</th>
                    <th>Age</th>
                    <th>Quantity</th>
                    <th>In-stock</th>
                    <th>Allocate</th>
                    <th>Under Repair</th>
                    <th>Stolen</th>
                    <th>Scraped</th>
                    {{-- <th>Allocations</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data4 as $key => $component)
                    <tr>
                        <td>{{ $component->id }}</td>
                        <td>{{ $component->product_number ?? '' }}</td>
                        <td>{{ $component->assetmain->name ?? '' }}</td>
                        <td>{{$component->asset_type->name??'' }}</td>
                        <td>{{ $component->brand->name ?? '' }}</td>
                        <td>{{ $component->brandmodel->name ?? '' }}</td>

                        <td class="ellipsis">{{ $component->specification ?? '' }}</td>
                        <td>{{ $component->ageInYears }} years and {{ $component->ageInMonths }} months</td>
                        <td>
                            <span
                                class="badge rounded-pill badge-light-success">{{ $component->quantity ?? '' }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill badge-light-success">{{$availableQuantity[$key]}}</span>
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
                            <span class="badge rounded-pill badge-light-success">{{ $scrappedCount }}</span>
                        </td>
                        <td>
                            <span
                                class="badge rounded-pill badge-light-success">{{ $scrappedCount }}<span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endif
</div>
</div>
@endsection
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
    $(document).ready(function() {
            // Initialize Bootstrap tooltip
            $('[data-toggle="tooltip"]').tooltip();

            $('#showAsset').click(function() {
                $('#addAsset').toggle();
            });
            $('#showStatus').click(function() {
                $('#addStatus').toggle();
            });
            $('#showEmp').click(function() {
            });
            $('#showAssetCode').click(function() {
                $('#addEmp').toggle();
                $('#addAssetcode').toggle();
            });
            $('#Transaction').click(function() {
                $('#transaction').toggle();
            });
            $('#showAssetCategory').click(function(){
                $('#addLocation').toggle();
            });
        });
</script>
<script>
    document.getElementById("SelectId").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }
    };
</script>
<script>
    function showTable() {
        document.getElementById('basic-1').style.display = 'table';
    }
    document.querySelector('.search-form').addEventListener('submit', function() {
        showTable();
    });
</script>
<script>
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0');
    let yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById('dateInput').value = today;
    document.getElementById('dateInputs').value = today;
</script>
@endsection
