@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="card">
    <div class="card-header pb-0">
        <h4>All Reports</h4>
        <hr>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('activity-reports')}}">
                        <h5>Asset activity report</h5>
                    </a>
                    <hr>
                    <a href="#">
                        <h5>Component activity report</h5>
                    </a>
                    <hr>
                    <a href="#">
                        <h5>Maintenance report</h5>
                    </a>
                    <hr>
                    <a href="#">
                        <h5>Report by type</h5>
                    </a>
                    <hr>
                </div>
                <div class="col-md-6">
                    <a href="{{route('report-status')}}">
                        <h5>Report by status</h5>
                    </a>
                    <hr>
                    <a href="#">
                        <h5>Report by supplier</h5>
                    </a>
                    <hr>
                    <a href="#">
                        <h5>Report by location</h5>
                    </a>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection