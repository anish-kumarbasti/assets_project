@extends('Backend.Layouts.panel')
@section('Content-Area')

<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Edit Designation</h4>
      </div>
      <div class="card-body">
         <form class="needs-validation" action="{{ route('designations.update', $designation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-item border">
               <div class="row p-3">
                  <div class="row p-3">
                     <div class="col-md-12 mb-4">
                        <label class="form-label" for="department_id">Select Department</label>
                        <select class="form-control" id="department_id" name="department_id" required>
                           <option value="">Select Department</option>
                           @foreach($departments as $department)
                           <option value="{{ $department->id }}" {{ $designation->department_id == $department->id ? 'selected' : '' }}>
                              {{ $department->name }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label class="form-label" for="designation_name">Designation Name</label>
                     <input class="form-control" id="designation_name" type="text" name="designation_name" required value="{{ $designation->designation }}" placeholder="Enter Designation Name">
                     @error('designation_name')
                     <span class="text-danger">{{$message}}</span>
                     @enderror
                  </div>
               </div>
            </div>
            <div class="footer-item">
               <button class="btn btn-primary mt-3" type="submit">Update</button>
               <a href="{{route('designations.index')}}" class="btn btn-warning mt-3">Back</a>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection