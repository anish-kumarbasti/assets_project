@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .status-tab {
        text-align: center;
        font-size: 10px;
        transform: translateY(5px);

    }
</style>
@endsection

@section('Content-Area')
<div class="card">
    <div class="card-header pb-0">
        <h4>All Reports</h4>
        <hr>
    </div>
    <div class="card-body">
        <div class="row d-flex justify-content-center">
            <div class="btn btn-group">
                <a class="nav-link active status-tab btn btn-primary" href="{{route('activity-reports')}}" aria-selected="true" data-toggle="tab" data-status="in-stock">Asset register report</a>
                <a class="nav-link status-tab btn btn-secondary" href="{{route('component-activity-reports')}}" aria-selected="true" data-toggle="tab" data-status="allocated">Component activity report</a>
                <a class="nav-link status-tab btn btn-success" href="{{route('maintenance-report')}}" aria-selected="true" data-toggle="tab" data-status="underrepair">Maintenance report</a>
                <a class="nav-link status-tab btn btn-info" href="{{route('report-type')}}" aria-selected="true" data-toggle="tab" data-status="stolen">Report by Asset type</a>
                <a class="nav-link status-tab btn btn-danger" href="{{route('report-supplier')}}" aria-selected="true" data-toggle="tab" data-status="scrapped">Report by supplier</a>
                <a class="nav-link status-tab btn btn-warning" href="{{route('report-location')}}" aria-selected="true" data-toggle="tab" data-status="scrapped">Report by location</a>

            </div>
        </div>
        {{-- <select name="" id="SelectId" class="form-control">
            <option value="">--Chose Reports--</option>
            <option value="/asset-activity-report">Asset activity report</option>
            <option value="/component-reports">Component activity report</option>
            <option value="/maintenance-report">Maintenance report</option>
            <option value="/reports-types">Report by Asset type</option>
            <option value="/reports-suppliers">Report by supplier</option>
            <option value="/reports-locations">Report by location</option>
        </select> --}}
    </div>
</div>
@endsection
@section('Script-Area')
<script>
    document.getElementById("SelectId").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }
    };
</script>

@endsection
