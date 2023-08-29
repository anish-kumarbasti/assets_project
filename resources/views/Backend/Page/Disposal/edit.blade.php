@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Update Depreciation</h4>
            <hr>
        </div>
        <div class="card">
            <form action="{{ url('disposal-update', $disposal->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" aria-label="Default select example">
                                    <option value="">--Select Category--</option>
                                    @foreach ($assettype as $assett)
                                    <option value="{{$assett->name}}">{{$assett->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Asset</label>
                                <select class="form-select" id="asset" name="asset" aria-label="Default select example">
                                    <option value="">--Select Asset--</option>
                                    @foreach ($asset as $assets)
                                    <option value="{{$assets->name}}">{{$assets->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Desposal Code</label>
                                <input type="text" class="form-control" value="{{$disposal->desposal_code}}" name="desposal_code" id="desposal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Period (Month)</label>
                                <input class="form-control" value="{{$disposal->period_months}}" name="period_months" type="text" id="period_months" inputmode="numeric">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Asset Value</label>
                                <input type="text" class="form-control" value="{{$disposal->asset_value}}" name="asset_value" id="assetvalue" inputmode="numeric">
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        <div class="footer-item text-end">
            <button class="btn btn-primary mt-3" type="submit">Update</button>
            <a href="{{route('disposal')}}" class="btn btn-warning mt-3" type="reset">Cancel</a>
        </div>
        </form>
    </div>
</div>
</div>
@endsection