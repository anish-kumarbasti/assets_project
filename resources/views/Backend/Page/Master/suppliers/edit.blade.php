@extends('Backend.Layouts.panel')
@section('Content-Area')

<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Edit Supplier</h4>
      </div>
      <div class="card-body">
        <form class="needs-validation" action="{{ route('suppliers.update', $supplier->id) }}" method="post">
            @csrf
            <div class="card-item border">
                <div class="row p-3">
                    <div class="col-md-12 mb-4">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
                </div>
            </div>

            <div class="row p-3">
                <div class="col-md-12 mb-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $supplier->email }}" required>
                </div>
            </div>

                <div class="row p-3">
                    <div class="col-md-12 mb-4">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}" required>
                </div>
            </div>

                <div class="row p-3">
                    <div class="col-md-12 mb-4">
                    <label for="address">Address</label>
                    <textarea name="address" class="form-control" required>{{ $supplier->address }}</textarea>
                </div>
            </div>
            <div class="footer-item">
               <button class="btn btn-primary mt-3" type="submit">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection
