@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Add Department</h4>
      </div>
      <div class="card-body">
         <form class="needs-validation" novalidate="">
            <div class="row mb-2">
               <div class="col-md-6">
                  <label class="form-label" for="validationCustom01">Product Info</label>
                  <input class="form-control" id="validationCustom01" type="text" required=""
                     data-bs-original-title="" title="" placeholder="Enter Product Name">
               </div>
               <div class="col-md-6">
                  <div class="mb-3 row">
                     <label class="col-sm-3 col-form-label pt-5 scan-text">Scan Barcode :</label>
                     <div class="col-sm-9 pt-4">
                        <input class="form-control qr" type="file" accept="image/*" capture="environment" id="qrInput">
                        <img id="qrImage" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png')}}" alt="QR Code">
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-item border">
               <div class="row mb-2 p-2">
                  <div class="col-md-6">
                     <label class="form-label" for="validationCustom01">Asset Type</label>
                     <select class="form-select" aria-label="Default select example">
                        <option selected>--Select Asset Type--</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label class="form-label" for="validationCustom01">Asset</label>
                     <select class="form-select" aria-label="Default select example">
                        <option selected>--Select Asset--</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="card">
      <div class="card-header pb-0">
         <h4>Product Details</h4>
      </div>
      <div class="card-body">
         <form class="needs-validation" novalidate="">
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Brand</label>
                     <select class="form-select" aria-label="Default select example">
                        <option selected>--Select Brand --</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Model</label>
                     <select class="form-select" aria-label="Default select example">
                        <option selected>--Select Model--</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Location</label>
                     <select class="form-select" aria-label="Default select example">
                        <option selected>--Select Location--</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-12 mb-4">
                     <label class="form-label" for="validationCustom01"> Configuration</label>
                     <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="" rows="3"></textarea>   
                  </div>
               </div>
            </div>
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Serial number</label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="Enter Product Name"> 
                  </div>
                  <div class="col-md-4">
                     <label class="form-label" for="validationCustom01">Vedor</label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="Enter Product Name"> 
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Price</label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="Enter Product Name"> 
                  </div>
               </div>
            </div>
            <div class="footer-item">
               <button class="btn btn-primary mt-3" type="submit" data-bs-original-title=""
                  title="">ADD</button>
               <button class="btn btn-warning mt-3" type="submit" data-bs-original-title=""
                  title="">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('Script-Area')
<script src="https://unpkg.com/@zxing/library@latest"></script>
@endsection