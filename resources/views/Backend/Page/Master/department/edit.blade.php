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
                        <li class="text-muted"><a href="#" class="text-muted">Department</a></li>
                        <li class="active fw-bold">Edit-Department</li>
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
                <h4>Edit Department</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('departments.update', ['id' => $department->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-item">
                        <div class="row p-3">
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="name">Department Name</label>
                                <input class="form-control @error('name') is-invalid @enderror mb-2" id="name"
                                    type="text" name="name" value="{{ old('name', $department->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label class="form-label" for="unique">Department ID</label>
                                <input class="form-control @error('unique') is-invalid @enderror" id="unique"
                                    type="text" name="unique" value="{{ old('name', $department->unique_id) }}"
                                    required>
                                @error('unique')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="footer-item">
                        <button class="btn btn-primary mt-3" type="submit">Update</button>
                        <a class="btn btn-warning mt-3" href="{{ route('departments-index') }}">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('Script-Area')
@endsection
