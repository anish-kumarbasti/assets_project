@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
@if (session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
   <p><b> Well done! </b>{{session('success')}}</p>
   <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-sm-12">
   <form class="needs-validation" method="POST" action="{{ isset($stockedit) ? route('update.stock', $stockedit->id) : route('store.stock') }}">
      @csrf
      <div class="card">
         <div class="card-header pb-0">
            <h4>{{isset($stockedit)?'Update Stock':'Add Stock'}}</h4>
         </div>
         <div class="card-body">
            <div class="row mb-2">
               <div class="col-md-6">
                  <label class="form-label" for="validationCustom01">Product Info</label>
                  <input class="form-control" value="{{isset($stockedit)?$stockedit->product_info:''}}" id="validationCustom01" type="text" name="product_info" required="" data-bs-original-title="" title="" placeholder="Enter Product Info">
               </div>
               <div class="col-md-6">
                  <label class="form-label" style="float: left;">Scan Barcode :</label><a href="#" style="float: left;">Generate Number</a>
                  <input class="form-control" type="text" name="generate_number" placeholder="Number">
                  {{-- <img id="" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png')}}" alt="QR Code"> --}}
               </div>
            </div>
            <div class="card-item border">
               <div class="row mb-2 p-2">
                  <div class="col-md-6">
                     <label class="form-label" for="validationCustom01">Asset Type</label>
                     <select class="form-select" id="assettype" name="asset_type" aria-label="Default select example">
                        <option>--Select Asset Type--</option>
                        @foreach ($asset_type as $asset_type)
                        <option value="{{$asset_type->id}}" {{ isset($stockedit) && $stockedit->asset_type_id == $asset_type->id ? 'selected' : '' }}>{{$asset_type->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label class="form-label" for="validationCustom01">Asset</label>
                     <select class="form-select" id="asset" name="asset" aria-label="Default select example">
                        <option value="">--Select Asset--</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header pb-0">
            <h4>Product Details</h4>
         </div>
         <div class="card-body">
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Brand</label>
                     <select class="form-select" id="brand" name="brand" aria-label="Default select example">
                        <option>--Select Brand --</option>
                        @foreach ($brand as $brand)
                        <option value="{{$brand->id}}" {{ isset($stockedit) && $stockedit->brand_id == $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Brand Model</label>
                     <select id="brand_model" class="form-select" name="brand_model" aria-label="Default select example">
                        <option value="">--Select Model--</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Location</label>
                     <select class="form-select" id="location" name="location" aria-label="Default select example">
                        <option>--Select Location--</option>
                        @foreach ($location as $location)
                        <option value="{{$location->id}}" {{ isset($stockedit) && $stockedit->location_id == $location->id ? 'selected' : '' }}>{{$location->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Sub Location</label>
                     <select id="slocation" class="form-select" name="sublocation" aria-label="Default select example">
                        <option value="">--Select Sub Location--</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Host Name</label>
                     <input class="form-control" id="validationCustom01" name="host_name" type="text" required="" data-bs-original-title="" title="" placeholder="Enter Host Name">
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Warranty </label>
                     <input class="form-control" id="validationCustom01" name="product_warranty" type="date" required="" data-bs-original-title="" title="" placeholder="Enter Warranty Name">
                  </div>
               </div>
            </div>
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-12 mb-4">
                     <label class="form-label" for="validationCustom01"> Configuration</label>
                     <textarea class="form-control" name="configuration" value="{{isset($stockedit)?$stockedit->configuration:''}}" id="exampleFormControlTextarea1" placeholder="" rows="3"></textarea>
                  </div>
               </div>
            </div>
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Serial number</label>
                     <input class="form-control" id="validationCustom01" value="{{isset($stockedit)?$stockedit->serial_number:''}}" name="serial_number" type="text" required="" data-bs-original-title="" title="" placeholder="Enter Serial Number">
                  </div>
                  <div class="col-md-4">
                     <label class="form-label" for="validationCustom01">Vendor</label>
                     <input class="form-control" id="validationCustom01" name="vendor" type="text" required="" data-bs-original-title="" value="{{isset($stockedit)?$stockedit->vendor:''}}" title="" placeholder="Enter Vendor">
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Price</label>
                     <input class="form-control" id="validationCustom01" value="{{isset($stockedit)?$stockedit->price:''}}" type="text" name="price" required="" data-bs-original-title="" title="" placeholder="Enter Price">
                  </div>
               </div>
            </div>
            <div class="footer-item">
               <button class="btn btn-primary mt-3" type="submit">{{isset($stockedit)?'UPDATE':'ADD'}}</button>
               <button class="btn btn-warning mt-3" type="button" data-bs-original-title="" title="">Cancel</button>
            </div>
         </div>
      </div>
   </form>
</div>
@endsection
@section('Script-Area')
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   jQuery(document).ready(function() {
      jQuery('#brand').change(function() {
         let brandId = jQuery(this).val();
         jQuery('#brand_model').empty();

         if (brandId) {
            jQuery.ajax({
               url: '/get-brand-models/' + brandId,
               type: 'POST',
               data: 'brandId' + brandId + '&_token={{csrf_token()}}',
               success: function(data) {
                  jQuery('#brand_model').append('<option value="">--Select Model--</option>');
                  jQuery.each(data.models, function(key, value) {
                     jQuery('#brand_model').append('<option value="' + value.id + '">' + value.name + '</option>');
                  });
               }
            });
         }
      });
   });

   //location
   jQuery(document).ready(function() {
      jQuery('#location').change(function() {
         let locationId = jQuery(this).val();
         jQuery('#slocation').empty();

         if (locationId) {
            jQuery.ajax({
               url: '/get-slocation/' + locationId,
               type: 'POST',
               data: 'locationId' + locationId + '&_token={{csrf_token()}}',
               success: function(data) {
                  jQuery('#slocation').append('<option value="">--Select Sub-location--</option>');
                  jQuery.each(data.locations, function(key, value) {
                     jQuery('#slocation').append('<option value="' + value.id + '">' + value.name + '</option>');
                  });
               }
            });
         }
      });
   });

   jQuery(document).ready(function() {
      jQuery('#assettype').change(function() {
         let assettypeId = jQuery(this).val();
         jQuery('#asset').empty();

         if (assettypeId) {
            jQuery.ajax({
               url: '/get-asset-type/' + assettypeId,
               type: 'POST',
               data: 'assettypeId' + assettypeId + '&_token={{csrf_token()}}',
               success: function(data) {
                  jQuery('#asset').append('<option value="">--Select Sub-location--</option>');
                  jQuery.each(data.assets, function(key, value) {
                     jQuery('#asset').append('<option value="' + value.id + '">' + value.name + '</option>');
                  });
               }
            });
         }
      });
   });
</script>

@endsection