@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }

    .custom {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
    }
</style>
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Receive Maintenance</h4>
            <hr>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>S.No</th>
                                <th>Asset Type</th>
                                <th>Asset Name</th>
                                <th>Product Number</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maintain as $maintenance)
                            <tr class="copy-content">
                                <td>{{ $maintenance->id }}</td>
                                <td>{{ $maintenance->type ?? 'N/A' }}</td>
                                <td>{{ $maintenance->asset ?? 'N/A' }}</td>
                                <td>{{ $maintenance->product_id ?? 'N/A' }}</td>
                                <td>{{ $maintenance->asset_price ?? 'N/A' }}</td>
                                <td><span class=" custom-btn {{$maintenance->statuss->status ?? 'N/A'}}">{{$maintenance->statuss->name ?? 'N/A'}}</span></td>
                                <td>{{ $maintenance->start_date }}</td>
                                <td>{{ $maintenance->end_date }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('maintenance-print', $maintenance->id) }}" target="_blank" class="btn btn-primary custom"><i class="fa fa-print "></i> Receive </a>&nbsp;
                                        <!-- <button class="btn btn-danger delete-button" data-id="{{ $maintenance->id }}" type="button"><i class="fa fa-trash-o"></i> Delete</button> -->
                                    </div>
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

@section('Script-Area')

@endsection