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
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input type="text" autocomplete="new-name" autocorrect="off" autocapitalize="none" placeholder="Enter Name" value="{{ $supplier->name }}" name="name" class="form-control" value="" required>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" autocomplete="new-email" autocorrect="off" autocapitalize="none" name="email" placeholder="Enter Email" value="{{ $supplier->email }}" class="form-control" value="" required>
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" autocorrect="off" autocapitalize="none" name="phone" placeholder="Enter Phone No" value="{{ $supplier->phone }}" class="form-control" required>
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="address">Address</label>
                        <textarea name="address" value="{{$supplier->address }}" class="form-control" required></textarea>
                        @error('address')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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