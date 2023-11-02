@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
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
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showStatus">Select Status</button>&nbsp;
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showEmp">Employee Code</button>&nbsp;
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showAssetCode">Asset Code</button>&nbsp;
            </div>
            <div class="col-sm-6">
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showAssetCategory">Select Location</button>&nbsp;
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showAssetC">Select Asset Category</button>&nbsp;
                <button class="btn btn-outline-dark" style="margin-top: 2px;" id="showAsset">Select Asset</button>&nbsp;
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
                <button class="btn btn-primary qr_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Category</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="search-form" action="{{route('search-reports')}}" method="GET">
            @csrf
            <div class="row p-3">
                <div class="col-sm-6 mb-3">
                    <label for="start_date">Transaction from</label>
                    <input type="date" class="form-control" name="start_date" id="dateInput">
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="end_date">To Transaction</label>
                    <input type="date" class="form-control" name="end_date" id="dateInputs">
                </div>
                <div class="col-sm-6 mb-3" id="addLocation" style="display: none;">
                    <label for="location">Select Location</label>
                    <select id="location" class="form-select" name="location" aria-label="Default select example">
                        <option value="">All Location</option>
                        @foreach ($location as $locations)
                        <option value="{{$locations->id}}">{{$locations->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3" id="addAssetC" style="display: none;">
                    <label for="asset">Select Asset Category</label>
                    <select id="assettype" class="form-select" name="assettype" aria-label="Default select example">
                        <option value="">All Asset Category</option>
                        @foreach ($assettype as $assettypes)
                        <option value="{{$assettypes->id}}">{{$assettypes->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3" id="addAsset" style="display: none;">
                    <label for="asset">Select Asset </label>
                    <select id="asset" class="form-select" name="asset" aria-label="Default select example">
                        <option value="">All Asset</option>
                        @foreach ($asset as $assets)
                        <option value="{{$assets->id}}">{{$assets->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3" id="addStatus" style="display: none;">
                    <label for="status">Select Status</label>
                    <select id="status" class="form-select" name="status" aria-label="Default select example">
                        <option value="">All Status</option>
                        @foreach ($status as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3" id="addEmp" style="display: none;">
                    <label for="employee_id">Employee Code</label>
                    <input type="text" class="form-control" name="employee_id" id="employee_id">
                </div>
                <div class="col-sm-6 mb-3" id="addAssetcode" style="display: none;">
                    <label for="product_number">Asset Code</label>
                    <input type="text" name="product_number" class="form-control" id="product_number">
                </div>

            </div>
            <div class="col-sm-12 text-end mb-3">
                <button class="btn btn-warning">Search</button>
            </div>
        </form>
    </div>
    @if(isset($data))
    <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between">
            <div class="btn btn-group">
                <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
                <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
                <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data')])}}">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data')])}}"><i class="fas fa-print"></i> Print</a>
            </div>
        </div>
        <div class="card-body">
        <div class="col-sm-12 basic">
        <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
                <thead>
                    <tr class="text-center">
                        <th>SL</th>
                        <th>Asset Code</th>
                        <th>Serial Number</th>
                        <th>Specification</th>
                        <th>Asset Type</th>
                        <th>Asset </th>
                        <th>Model</th>
                        <th>Purchase Date</th>
                        <th>Purchase Cost</th>
                        <th>Location</th>
                        <th>Sub-Location</th>
                        <th>Status</th>
                        <th>Warranty</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach ($data as $asset)
                    <tr class="copy-content text-center">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$asset->product_number??'N/A'}}</td>
                        <td>{{$asset->serial_number??'N/A'}}</td>
                        <td class="ellipsis">{{$asset->specification??'N/A'}} <p>{{$asset->attributes->name??'N/A'}}</p></td>
                        <td>{{$asset->asset_type->name??'N/A'}}</td>
                        <td>{{$asset->assetmain->name??'N/A'}}</td>
                        <td>{{$asset->brandmodel->name??'N/A'}}</td>
                        <td>{{\Carbon\Carbon::parse($asset->created_at)->format('d-m-y')??'N/A'}}</td>
                        <td>{{$asset->price??'N/A'}}</td>
                        <td>{{$asset->location->name??'N/A'}}</td>
                        <td>{{$asset->sublocation->name??'N/A'}}</td>
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
                $('#addEmp').toggle();
            });
            $('#showAssetCode').click(function() {
                $('#addAssetcode').toggle();
            });
            $('#showAssetC').click(function() {
                $('#addAssetC').toggle();
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
