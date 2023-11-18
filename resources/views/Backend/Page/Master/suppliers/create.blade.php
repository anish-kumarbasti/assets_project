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
                        <li class="text-muted"><a href="{{ url('suppliers') }}" class="text-muted">Suppliers</a></li>
                        <li class="active"><a href="{{ url('suppliers/create') }}">Add-Supllier</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            Upload Validation Error<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Add Supplier</h4>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#importModal">
                    Import Data
                </button>
            </div>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('import.store.supplier') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="select_file">Choose File:</label>
                                    <input type="file" name="select_file" class="form-control" accept=".xls, .xlsx">
                                </div>
                                <a href="{{ route('import.download-format-supplier') }}"
                                    class="btn btn-secondary">Download
                                    Format</a>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="needs-validation" action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="validationCustom02">Supplier Id</label>
                            <input class="form-control" id="validationCustom02" type="text" value="SUP" name="unique"
                                required="" data-bs-original-title="" title="" placeholder="Enter Supplier Id">
                            @error('unique')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" autocomplete="new-name" autocorrect="off" autocapitalize="none"
                                placeholder="Enter Name" value="{{ old('name') }}" name="name" class="form-control"
                                value="" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" autocomplete="new-email" autocorrect="off" autocapitalize="none"
                                name="email" placeholder="Enter Email" value="{{ old('email') }}" class="form-control"
                                value="" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" autocorrect="off" autocapitalize="none" name="phone"
                                placeholder="Enter Phone No" value="{{ old('phone') }}" class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="address">Address</label>
                            <textarea name="address" autocomplete="new-address" autocorrect="off" autocapitalize="none"
                                placeholder="Enter Address" value="{{ old('address') }}" class="form-control" required></textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

            </div>
            <div class="footer-item d-flex justify-content-end mt-3">
                <button class="btn btn-primary mt-3" type="submit">Add</button>&nbsp;
                <a href="{{ route('suppliers.index') }}" class="btn btn-warning mt-3">Back</a>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
