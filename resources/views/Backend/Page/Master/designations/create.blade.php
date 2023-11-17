@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .swal2-popup {
            text-align: center;
        }
    </style>
    <style>
        /* Custom styles for breadcrumbs */
        .breadcrumbs-dark ol.breadcrumbs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumbs-dark ol.breadcrumbs li {
            font-size: 14px;
            /* Adjust font size as needed */
            color: #555;
            /* Adjust text color as needed */
        }

        .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
            content: ">";
            margin-left: 10px;
            margin-right: 10px;
            color: #777;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.active a {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
            color: blue;
        }
    </style>    
@endsection
@section('breadcrumbs')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <ol class="breadcrumbs mb-2">
                        <li class="text-muted">Dashboard</li>
                        <li class="text-muted">Master</li>
                        <li class="text-muted"><a href="{{url('designations')}}" class="text-muted">Designation</a></li>
                        <li class="active"><a href="{{url('designations/create')}}">Add-Designation</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
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