@extends('Backend.Layouts.panel')
@section('Style-Area')
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
                    <li class="text-muted">Maintenance</li>
                    {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                    <li class="active"><a href="{{ url('receive-maintenance') }}">Recive Maintenance</a></li>
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
            <h3>Recieve Maintenance</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Transaction ID</th>
                                <th>Maintaining User</th>
                                {{-- <th>Asset Code</th>
                                <th>Asset Type</th>
                                <th>Asset </th>
                                <th>Product</th> --}}
                                <th>Description</th>
                                <th>Start Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maintenance as $maintain)
                                <tr class="text-center">
                                    @php
                                    $product=json_decode($maintain->product_id)
                                    @endphp
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$maintain->transaction_id??'N/A'}}</td>
                                    <td>{{ $maintain->maintenance_user_id??'N/A' }}</td>
                                    {{-- <td>{{ isset(App\Models\Stock::find($product[0])->product_number) ? (App\Models\Stock::find($product[0]))->product_number : 'N/A' }}</td>
                                    <td>{{ isset(App\Models\AssetType::find($issuence->asset_type_id)->name) ? App\Models\AssetType::find($issuence->asset_type_id)->name : 'N/A' }}</td>
                                    <td>{{ isset(App\Models\AssetType::find($issuence->asset_id)->name) ? App\Models\Asset::find($issuence->asset_id)->name : 'N/A' }}</td>
                                    <td>{{ isset(App\Models\Stock::find($product[0])->product_info) ? (App\Models\Stock::find($product[0]))->product_info : 'N/A' }}</td> --}}
                                    <td>{{ isset($maintain->description) ? $maintain->description : 'N/A' }}</td>
                                    <td>{{ isset($maintain->start_date) ? $maintain->start_date : 'N/A' }}</td>
                                    <td>
                                    <a class="btn btn-primary" href="{{route('recieve.product',$maintain->id)}}">View</a>&nbsp;
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
