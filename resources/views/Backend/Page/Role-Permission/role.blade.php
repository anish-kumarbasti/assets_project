@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <button class="btn btn-outline-primary role-btn" type="button" data-original-title="btn btn-outline-danger-2x" title="" data-bs-toggle="modal" data-bs-target="#exampleModal">
         <i class="fa fa-plus"></i> Add Role
         </button>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog d-flex align-items-center">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form class="needs-validation" novalidate="">
                     <div class="card-item border">
                        <div class="row p-3">
                           <div class="col-md-12 mb-4">
                              <label class="form-label" for="validationCustom01">Add Role</label>
                              <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title="" title="" placeholder="Role Name">
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Add</button>
               </div>
            </div>
         </div>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr class="text-center">
                     <th>SL</th>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr class="text-center">
                     <td>1</td>
                     <td>1</td>
                     <td>Admin</td>
                     <td>Created At</td>
                     <td>
                        <button class="btn btn-warning" type="submit" data-bs-original-title="" title="">Permission</button>
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Edit</button>
                        <button class="btn btn-danger" type="submit" data-bs-original-title="" title="">Delete</button>
                     </td>
                  </tr>
                  <tr class="text-center">
                     <td>2</td>
                     <td>2</td>
                     <td>Manager</td>
                     <td>Created At</td>
                     <td>
                        <button class="btn btn-warning" type="submit" data-bs-original-title="" title="">Permission</button>
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Edit</button>
                        <button class="btn btn-danger" type="submit" data-bs-original-title="" title="">Delete</button>
                     </td>
                  </tr>
                  <tr class="text-center">
                     <td>3</td>
                     <td>3</td>
                     <td>User</td>
                     <td>Created At</td>
                     <td>
                        <button class="btn btn-warning" type="submit" data-bs-original-title="" title="">Permission</button>
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Edit</button>
                        <button class="btn btn-danger" type="submit" data-bs-original-title="" title="">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection