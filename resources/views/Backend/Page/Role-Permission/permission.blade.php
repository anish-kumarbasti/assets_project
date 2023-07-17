@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         Admin Permissions
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr class="w-30">
                     <th>Module</th>
                     <th>Permissions</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>Permissions</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Role</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Stock</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Assets</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>user</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Issuence</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Department</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Designation</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Setting</td>
                     <td>
                        <div class="row">
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Manage</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Create</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Edit</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div style="display: flex; align-items: center;">
                                 <span class="mt-2" style="order: 1;">Delete</span>
                                 <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                 <input type="checkbox" checked=""><span class="switch-state"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection