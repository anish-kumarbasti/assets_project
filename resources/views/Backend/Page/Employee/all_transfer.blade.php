@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h3>All Return</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Product ID</th>
                                <th>Return By User</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @foreach ($return as $returns)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ is_string($returns->product_id) ? (json_decode($returns->product_id, true)[0] ?? 'N/A') : 'N/A' }}</td>
                                <td>{{ $returns->username->first_name??'N/A'}} {{ $returns->username->last_name??''}}</td>
                                <td>{{ $returns->reason ??'N/A' }}</td>
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
