@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
<div class="col-sm-12">
        <div class="card">
            <form action="{{ url('disposal-update', $disposal->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="card-header pb-0">
                    <h4>Update Depreciation</h4>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="assettype" name="assetType" aria-label="Default select example">
                                    <option value="">--Select Category--</option>
                                    @foreach ($assettype as $assett)
                                    <option value="{{$assett->id}}" @if($disposal->category == $assett->id) selected @endif>{{$assett->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Asset</label>
                                <select class="form-select" id="asset" name="assetName" aria-label="Default select example">
                                    <option value="">--Select Asset--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Product</label>
                                <select class="form-select" id="product" name="product_name" aria-label="Default select example">
                                    <option value="">--Choose Product--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Disposal Code</label>
                                <input type="text" class="form-control" value="{{$disposal->desposal_code}}" name="desposal_code" id="desposal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Period (Month)</label>
                                <input class="form-control" value="{{$disposal->period_months}}" name="period_months" type="text" id="period_months" inputmode="numeric">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Current Asset Value</label>
                                <input type="text" class="form-control" value="{{$disposal->asset_value}}" name="asset_value" id="assetvalue" inputmode="numeric">
                            </div>
                        </div>

                    </div>
                </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary mt-3" type="submit">Update</button>
            <a href="{{route('disposal')}}" class="btn btn-warning mt-3" type="reset">Cancel</a>
        </div>
        </form>
    </div>
</div>
@endsection
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#assettype').change(function() {
            let assettypeId = jQuery(this).val();
            jQuery('#asset').empty();

            if (assettypeId) {
                jQuery.ajax({
                    url: '/get-asset-type/' + assettypeId,
                    type: 'POST',
                    data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                    success: function(data) {
                        jQuery('#asset').append(
                            '<option value="">--Select Asset--</option>');
                        jQuery.each(data.assets, function(key, value) {
                            jQuery('#asset').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
    jQuery(document).ready(function() {
        jQuery('#asset').change(function() {
            let assettypeId = jQuery(this).val();
            jQuery('#product').empty();

            if (assettypeId) {
                jQuery.ajax({
                    url: '/get-product-type/' + assettypeId,
                    type: 'POST',
                    data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                    success: function(data) {
                        jQuery('#product').append(
                            '<option value="">--Select Product--</option>');
                        jQuery.each(data.product, function(key, value) {
                            console.log(value);
                            jQuery('#product').append('<option value="' + value.id +
                                '">' + value.product_info + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
