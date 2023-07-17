@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         User Info
      </div>
      <div class="card-body">
         <form>
            <div class="card-item border ">
               <div class="row p-3">
                  <div class="col-md-6 ">
                     <label class="form-label" for="validationCustom01">First Name</label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="First Name">
                  </div>
                  <div class="col-md-6 ">
                     <label class="form-label" for="validationCustom01">Last Name</label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="Last Name">
                  </div>
               </div>
               <div class="row p-3">
                  <div class="col-md-6 mb-4">
                     <label class="form-label" for="validationCustom01">profile Photo</label>
                     <input class="form-control" id="validationCustom01" type="file" required=""
                        data-bs-original-title="" title="" >
                  </div>
                  <div class="col-md-6 mb-4">
                     <label class="form-label" for="validationCustom01">Cover Photo</label>
                     <input class="form-control" id="validationCustom01" type="file" required=""
                        data-bs-original-title="" title="" >
                  </div>
               </div>
            </div>
            <div class="card-item border ">
               <div class="row p-3">
                  <div class="col-md-6 ">
                     <label class="form-label" for="validationCustom01">Department</label>
                     <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                        <option selected> Enter Department </option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
                  <div class="col-md-6 ">
                     <label class="form-label" for="validationCustom01">Department</label>
                     <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                        <option selected> Enter Department </option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                     </select>
                  </div>
               </div>
               <div class="footer-item mt-3 mb-3">
                  <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Add</button>
                  <button class="btn btn-warning mt-3" type="submit" data-bs-original-title="" title="">Cancel</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection