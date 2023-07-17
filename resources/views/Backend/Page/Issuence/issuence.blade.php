@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Employee Details</h4>
      </div>
      <div class="card-body">
         <form class="needs-validation" novalidate="">
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-6 mb-4">
                     <label class="form-label" for="employeeId">Employee's ID</label>
                     <input class="form-control" id="employeeId" type="text" required="" data-bs-original-title=""
                        title="" placeholder="Enter Employee's ID">
                  </div>
                  <div class="col-md-6 mb-4">
                     <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label pt-5 scan-text">Scan Barcode :</label>
                        <div class="col-sm-9 pt-4">
                           <input class="form-control qr" type="file" accept="image/*" capture="environment" id="qrInput">
                           <img id="qrImage" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png')}}" alt="QR Code">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-item border mt-3">
               <div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Name:</label>
                     <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title=""
                        title="" placeholder="Abhi" readonly>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Department:</label>
                     <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title=""
                        title="" placeholder="IT Department" readonly>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Location:</label>
                     <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title=""
                        title="" placeholder="Lucknow" readonly>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="card mt-3">
      <div class="card-body">
         <div class="row">
            <div class="col-md-3 mt-2">
               <label class="form-label" for="validationCustom01">Transfer Reason:</label>
            </div>
            <div class="col-md-3 mt-2">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio"
                     value="replacement">
                  <label class="form-check-label" for="replacementRadio">Replacement</label>
               </div>
            </div>
            <div class="col-md-3 mt-2">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio"
                     value="itClearance" required>
                  <label class="form-check-label" for="itClearanceRadio">IT Clearance</label>
               </div>
            </div>
            <div class="col-md-3 mt-2">
               <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                  <option selected>Vacation</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
               </select>
            </div>
         </div>
      </div>
   </div>
   <div class="card mt-3">
      <div class="card-body">
         <div class="card-header pb-0">
         </div>
         <div class="row py-3">
            <!-- First Card -->
            <div class="col-md-3">
               <h5>1. Laptop<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
               <div class="card card-box">
                  <div class="card-body">
                     <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                     <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                  </div>
               </div>
            </div>
            <!-- Second Card -->
            <div class="col-md-3">
               <h5>2. Monitor<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
               <div class="card card-box">
                  <div class="card-body">
                     <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                     <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                  </div>
               </div>
            </div>
            <!-- Third Card -->
            <div class="col-md-3">
               <h5>3. Phone<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
               <div class="card card-box">
                  <div class="card-body">
                     <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                     <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                  </div>
               </div>
            </div>
            <!-- Fourth Card -->
            <div class="col-md-3">
               <h5>4. Phone<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
               <div class="card card-box">
                  <div class="card-body">
                     <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                     <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                     <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card mt-3">
      <div class="card-body">
         <div class="card-item border mt-3">
            <div class="row p-3">
               <div class="col-md-4">
                  <label class="form-label" for="assetTypeSelect">Asset Type</label>
                  <select class="form-select" aria-label="Default select example" id="assetTypeSelect">
                     <option selected>IT Asset</option>
                     <option value="1">One</option>
                     <option value="2">Two</option>
                     <option value="3">Three</option>
                  </select>
               </div>
               <div class="col-md-4">
                  <label class="form-label" for="assetSelect">Asset</label>
                  <select class="form-select" aria-label="Default select example" id="assetSelect">
                     <option selected>Laptop</option>
                     <option value="1">One</option>
                     <option value="2">Two</option>
                     <option value="3">Three</option>
                  </select>
               </div>
               <div class="col-md-4 mb-4">
                  <div class="mb-3 row">
                     <label class="col-sm-6 col-form-label pt-5 scan-text">Scan Barcode :</label>
                     <div class="col-sm-6 pt-4">
                        <input class="form-control qr" type="file" accept="image/*" capture="environment" id="qrInput">
                        <img id="qrImage" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png')}}" alt="QR Code">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-item border mt-4">
            <div class="row py-3">
               <!-- First Card -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                        <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                     </div>
                  </div>
               </div>
               <!-- Second Card -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                        <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                     </div>
                  </div>
               </div>
               <!-- Third Card -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                        <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                     </div>
                  </div>
               </div>
               <!-- Fourth Card -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                        <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                        <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card mt-3">
      <div class="card-body">
         <div class="card-item border">
            <div class="row p-3">
               <div class="col-md-12 mb-4">
                  <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="IT Assets" rows="3"></textarea>
               </div>
            </div>
         </div>
         <div class="card-item border mt-3 pt-2">
            <div class="row p-3">
               <div class="col-md-4 mb-4">
                  <label class="form-label" for="validationCustom01">Issuing Time:</label>
                  <input class="form-control" id="validationCustom01" type="time" required="" data-bs-original-title=""
                     title="">
               </div>
               <div class="col-md-4 mb-4">
                  <label class="form-label" for="validationCustom01">Date of Issuing</label>
                  <input class="form-control" id="validationCustom01" type="date" required="" data-bs-original-title=""
                     title="">
               </div>
               <div class="col-md-4 mb-4">
                  <label class="form-label" for="validationCustom01">Due Date</label>
                  <input class="form-control" id="validationCustom01" type="date" required="" data-bs-original-title=""
                     title="">
               </div>
            </div>
         </div>
         <div class="footer-item mt-3 mb-3">
            <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Allocate Assets</button>
         </div>
      </div>
   </div>
</div>
@endsection