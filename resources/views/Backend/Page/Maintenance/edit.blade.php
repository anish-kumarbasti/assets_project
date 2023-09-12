@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <form action="{{ url('maintainans-update', $maintainance->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="card-header pb-0">
                <h4>Update Maintenance</h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Asset Number</label>
                            <input class="form-control" id="product_number" type="search" data-bs-original-title="" title="" name="product_id" value="{{$maintainance->product_id}}" placeholder="Enter Asset Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Product</label>
                            <input class="form-control" value="{{$maintainance->asset}}" id="product_info" name="asset" type="text" data-bs-original-title="" title="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Asset Price</label>
                            <input class="form-control" value="{{$maintainance->asset_price}}" id="price" name="asset_price" type="text" data-bs-original-title="" title="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Supplier</label>
                            <select class="form-select" id="supplier" name="supplier" aria-label="Default select example">
                                @foreach ($supplier as $suppliers)
                                <option value="{{$suppliers->id}}" {{$maintainance->supplier == $suppliers->id ? 'selected':''}}>{{$suppliers->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" value="{{$maintainance->start_date}}" name="start_date" id="start_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" value="{{$maintainance->end_date}}" name="end_date" id="end_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="Status" name="status" aria-label="Default select example">
                                @foreach ($status as $status)
                                <option value="{{$status->id}}" {{$maintainance->status == $status->id ? 'selected':''}}>{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary mt-3" type="submit">Update</button>
                <a href="{{route('assets-maintenances')}}" class="btn btn-warning mt-3" type="reset">Cancel</a>
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