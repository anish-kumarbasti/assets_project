@extends('Backend.Layouts.panel')
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Edit Maintenance Supplier</h4>
            </div>
            <div class="card-body">
                <form class="needs-validation" action="{{ route('maintenance.suppliers.update',$supplier->id) }}" method="post">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="validationCustom02">Maintenance Supplier Id</label>
                            <input class="form-control" id="validationCustom02" type="text" value="{{$supplier->MaintenanceSupllierID }}" name="MaintenanceSupllierID"
                                required="" data-bs-original-title="" title="" placeholder="Enter Supplier Id">
                            @error('MaintenanceSupllierID')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" autocomplete="new-name" autocorrect="off" autocapitalize="none"
                                placeholder="Enter Name" value="{{ $supplier->name }}" name="name" class="form-control"
                                value="" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" autocomplete="new-email" autocorrect="off" autocapitalize="none"
                                name="email" placeholder="Enter Email" value="{{ $supplier->email }}" class="form-control"
                                value="" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" autocorrect="off" autocapitalize="none" name="phone"
                                placeholder="Enter Phone No" value="{{ $supplier->phone }}" class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required>{{$supplier->address}}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="footer-item">
                        <a href="{{ route('maintenance.suppliers.index') }}" class="btn btn-warning mt-3">Back</a>
                        <button class="btn btn-primary mt-3" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
