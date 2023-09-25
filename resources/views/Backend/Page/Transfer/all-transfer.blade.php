@extends('Backend.Layouts.panel')
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h3>All Transfers</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="table table-bordered table-striped" id="transfer-table">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Transfer ID</th>
                                <th>Employee</th>
                                <th>Handover Employee</th>
                                <th>Transfer Reason</th>
                                <th>Products</th>
                                <th>Description</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfers as $transfer)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $transfer->id }}</td>
                                <td>{{ $transfer->user->first_name??''}}</td>
                                <td>{{ $transfer->handoverEmployee->employee_id??''}}</td>
                                <td>{{ $transfer->reason->reason??''}}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        {{-- @foreach ($transfer->products as $product)
                                        <li>{{ $product->product_info??''}}</li>
                                        @endforeach --}}
                                    </ul>
                                </td>
                                <td>{{ $transfer->description??''}}</td>
                                <td>{{ $transfer->created_at??''}}</td>
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