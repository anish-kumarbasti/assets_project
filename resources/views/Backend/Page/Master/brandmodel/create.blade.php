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
                        {{-- <li class="text-muted"><a href="{{url('department')}}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{url('brand-model')}}">Brand-Models</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('Content-Area')

@if (session('success'))
<div id="alert-success" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Add Brand Model </h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" action="{{ route('brand-model.store') }}" method="post">
                @csrf
                <div class="card-item">
                    <div class="row p-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="validationCustom01">Select Brand</label>
                            <select class="form-select" id="brand_id" name="brand_id" required>
                                <option value="" disabled selected>Select a Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation_name">Brand Model</label>
                            <input class="form-control me-2" id="validationCustom01" type="text" name="name" required="" data-bs-original-title="" title="" placeholder="Enter Model Name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="footer-item">
                        <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title=""> Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@isset($brandmodel)
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0 d-flex">
            <div class="float-left col-sm-6">
                <h4>List Models</h4>
            </div>
            <div class="col-sm-6"><a href="{{route('trash.model')}}" class="btn btn-primary float-end">Trash</a>
            </div>
        </div>
        <div class="card-body">
            {{-- <form action="{{route('import.department')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" class="form-label" placeholder="Select CSV file" name="file">
            <button type="submit" class="btn btn-primary text-end">Import</button>
            </form> --}}
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Model Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- @dd($brandmodel); --}}

                        @foreach($brandmodel as $brandmodel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $brandmodel->Brandmodel->name??''}}</td>
                            <td>{{ $brandmodel->name }}</td>

                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{ $brandmodel->id }}" {{ $brandmodel->status ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </td>
                            {{-- @dd($brandmodel->id); --}}
                            <td>
                                <a class="btn btn-primary" href="{{ url('brand-model/' . $brandmodel->id . '/edit' ) }}"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $brandmodel->id }}"><i class="fa fa-trash-o"></i>&nbsp;Trash</button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endisset
@endsection

@section('Script-Area')
<script>
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const brandId = this.getAttribute('data-id');
            const status = this.checked;

            fetch(`/brands-model/${brandId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status
                })
            }).then(function(response) {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                console.log('Status updated successfully');
            }).catch(function(error) {
                console.error('Error:', error);
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        var alertfun = $('#alert-success');
        setTimeout(function() {
            alertfun.alert('close');
        }, 3000);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const brandId = this.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, trash it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/brand-model/' + brandId, {
                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if ('success' in data && data.success) {
                                Swal.fire(
                                    'Trashed!',
                                    'Your file has been trashed.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    data.message || 'Failed to trash the file.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'An error occurred while trashing the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
@endsection