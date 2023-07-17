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
            <div class="card-item border">
               <div class="row p-3">
                  <div class="col-md-12 mb-4">
                     <label class="form-label" for="validationCustom01">Add Department </label>
                     <input class="form-control" id="validationCustom01" type="text" required=""
                        data-bs-original-title="" title="" placeholder="Enter Department Name ">
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
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>1</td>
                     <td>1</td>
                     <td>IT Department</td>
                     <td class="w-20">
                        <label class="mb-0 switch">
                        <input type="checkbox" checked=""><span class="switch-state"></span>
                        </label>
                     </td>
                     <td>
                        <button class="btn btn-primary" type="submit" data-bs-original-title=""
                           title="">Edit</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('Script-Area')
@endsection