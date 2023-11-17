@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .swal2-popup {
            text-align: center;
        }
    </style>
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
                        <li class="text-muted">Master</li>
                        <li class="text-muted"><a href="{{url('assets')}}" class="text-muted">Assets</a></li>
                        <li class="active"><a href="{{url('assets/create')}}">Add-Asset</a></li>
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
            <h4>Add Asset</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" method="POST" action="{{ route('assets.store') }}">
                @csrf
                <div class="card-item">
                    <div class="row p-3">
                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="assetName">Select Asset Type </label>
                            <select class="form-select" id="" name="asset_type_id" required>
                                <option value="" disabled selected>Select type</option>
                                @foreach ($assettype as $assettype)
                                <option value="{{ $assettype->id }}">{{ $assettype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="assetName">Asset Name </label>
                            <input class="form-control" id="assetName" name="name" type="text" required="" placeholder="Enter Asset Name ">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit">ADD</button>
                    <a href="{{route('assets.index')}}" class="btn btn-warning mt-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection