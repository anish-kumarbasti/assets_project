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
                                <th>Employee ID</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Issuing Time</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $issuence)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $issuence->employee_id }}</td>
                                <td>{{ $issuence->assettype->name??'N/A' }}</td>
                                <td>{{ $issuence->asset->name??'N/A' }}</td>
                                <td>{{$issuence->product->name??'N/A'}}</td>
                                <td>{{ isset($issuence->description) ? $issuence->description : 'N/A' }}</td>
                                <td>{{ isset($issuence->issuing_time_date) ? $issuence->issuing_time_date : 'N/A' }}</td>
                                <td>{{ isset($issuence->due_date) ? $issuence->due_date : 'N/A' }}</td>
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