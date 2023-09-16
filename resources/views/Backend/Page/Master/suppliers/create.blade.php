@extends('Backend.Layouts.panel')
@section('Content-Area')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Add Supplier</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input type="text" autocomplete="new-name" autocorrect="off" autocapitalize="none" placeholder="Enter Name" value="{{ old('name') }}" name="name" class="form-control" value="" required>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" autocomplete="new-email" autocorrect="off" autocapitalize="none" name="email" placeholder="Enter Email" value="{{ old('email') }}" class="form-control" value="" required>
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" autocorrect="off" autocapitalize="none" name="phone" placeholder="Enter Phone No" value="{{ old('phone') }}" class="form-control" required>
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="address">Address</label>
                        <textarea name="address" autocomplete="new-address" autocorrect="off" autocapitalize="none" placeholder="Enter Address" value="{{ old('address') }}" class="form-control" required></textarea>
                        @error('address')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

        </div>
        <div class="footer-item d-flex justify-content-end mt-3">
            <button class="btn btn-primary mt-3" type="submit">Add</button>&nbsp;
            <a href="{{route('suppliers.index')}}" class="btn btn-warning mt-3">Back</a>
        </div>
        </form>
    </div>
</div>
</div>

@endsection