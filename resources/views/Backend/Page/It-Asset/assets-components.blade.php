@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .btn-view {
        background: #BB4F00 !important;
        border: 2px solid #BB4F00 !important;
    }

    .qr_btn {
        border-radius: 10px;
        padding: 10px;
    }

    .stock-item {
        border: 3px solid #55555533 !important;
        margin-top: 17px;
        border-radius: 28px;
        background-color: #F5F6FE;
        position: relative;
        left: 20px;
    }

    .border-right {
        border-right: 3px solid #55555533;
    }

    .ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }
</style>
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="card">
                <div class="row ">
                    <div class="col-md-6 p-4">
                        <h4>Assets Components</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}" alt='...'></button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Code</th>
                            <th>Asset</th>
                            <th>Specification</th>
                            <th>Opening Stack</th>
                            <th>Purchased</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Balanced</th>
                            <th>Allocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assteComponent as $component)
                        <tr>
                            <td>{{$component->id}}</td>
                            <td>{{$component->product_number??''}}</td>
                            <td>{{$component->product_info??''}}</td>
                            <td class="ellipsis">{{$component->specification??''}}</td>
                            <td>20</td>
                            <td>15</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">{{$component->quantity??''}}</span>
                            </td>
                            <td> <span class="custom-btn {{$component->statuses->status}}">{{$component->statuses->name??''}}</span></td>
                            <td>{{$component->price??''}}</td>
                            <td>
                                <a href="{{url('assets-component-timeline',$component->id)}}" class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection