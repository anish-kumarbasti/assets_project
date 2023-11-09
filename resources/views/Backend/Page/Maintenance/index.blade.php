@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h3>All Issuances</h3>
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
