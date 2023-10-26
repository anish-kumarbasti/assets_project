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
@endsection

@section('Content-Area')
<div class="col-sm-12">
<div class="card">
    <div class="card-header pb-0">
        <h4>Reports</h4>
        <hr>
    </div>
    <div class="card-body">
        <form class="search-form" action="{{route('search-reports')}}" method="GET">
            @csrf
            <div class="row p-3">
                <div class="col-sm-6 mb-3">
                    <label for="start_date">Transaction from</label>
                    <input type="date" class="form-control" name="start_date" id="start_date">
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="end_date">To Transaction</label>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="location">Select Location</label>
                    <select id="location" class="form-select" name="location" aria-label="Default select example">
                        <option value="">All Location</option>
                        @foreach ($location as $locations)
                        <option value="{{$locations->id}}">{{$locations->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="asset">Select Asset Category</label>
                    <select id="assettype" class="form-select" name="assettype" aria-label="Default select example">
                        <option value="">All Asset Category</option>
                        @foreach ($assettype as $assettypes)
                        <option value="{{$assettypes->id}}">{{$assettypes->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="asset">Select Asset </label>
                    <select id="asset" class="form-select" name="asset" aria-label="Default select example">
                        <option value="">All Asset</option>
                        @foreach ($asset as $assets)
                        <option value="{{$assets->id}}">{{$assets->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="status">Select Status</label>
                    <select id="status" class="form-select" name="status" aria-label="Default select example">
                        <option value="">All Status</option>
                        @foreach ($status as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="employee_id">Employee Code</label>
                    <input type="text" class="form-control" name="employee_id" id="employee_id">
                </div>
                <div class="col-sm-6 mb-3">
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
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

@endsection
