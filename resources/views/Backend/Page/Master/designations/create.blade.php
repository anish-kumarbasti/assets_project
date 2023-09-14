@extends('Backend.Layouts.panel')
@section('Content-Area')

<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Add Designation</h4>
      </div>
      <div class="card-body">
         <form class="needs-validation" action="{{ route('designations.store') }}" method="POST">
            @csrf
            <div class="row p-3">
               <div class="col-md-6 mb-4">
                  <label class="form-label" for="department_id">Select Department</label>
                  <select class="form-control" id="department_id" name="department_id" required>
                     <option value="">Select Department</option>
                     @foreach($departments as $department)
                     <option value="{{ $department->id }}">
                        {{ $department->name }}
                     </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-6">
                  <label class="form-label" for="designation_name">Designation Name</label>
                  <input class="form-control" value="{{old('designation_name')}}" id="designation_name" type="text" name="designation_name" required placeholder="Enter Designation Name">
                  @error('designation_name')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
               </div>
            </div>
            <div class="footer-item d-flex justify-content-end mt-3">
               <button class="btn btn-primary" type="submit">Add</button>&nbsp;
               <a href="{{ route('designations.index') }}" class="btn btn-warning">Back</a>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection