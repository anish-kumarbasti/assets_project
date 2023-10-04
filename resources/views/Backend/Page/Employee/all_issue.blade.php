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
                                <td>{{ isset($issuence->asset_type) ? $issuence->asset_type->name : 'N/A' }}</td>
                                <td>{{ isset($issuence->serial_number) ? $issuence->serial_number : 'N/A' }}</td>
                                <td>
                                    @if (isset($issuence->product))
                                    @foreach (json_decode($issuence->product) as $product)
                                    {{ $product->name }}
                                    @if (!$loop->last)
                                    ,
                                    @endif
                                    @endforeach
                                    @else
                                    N/A
                                    @endif
                                </td>
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