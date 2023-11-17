@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }

    .swal2-popup {
        text-align: center;
    }
</style>
@endsection
@section('Content-Area')
@if (session('success'))
<div id="btn" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger outline" role="alert">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0 d-flex">
            <div class="float-left col-sm-6">
                <h4>All Status</h4>
            </div>
            <div class="col-sm-6"><a href="{{route('trash.status')}}" class="btn btn-danger float-end" style="margin-left: 5px;">Trash</a><a class="btn btn-primary float-end m-b-30" id="openModalButton" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                    Add Status</a>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content date-picker">
                    <div class="modal-header border-bottom">
                        <h4 class="modal-title text-primary" id="exampleModalLabel">Add Status</h4>
                        <button type="button" class="close ml-auto rounded float-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('status-save') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Status Name</label>
                                <input class="form-control" value="{{old('name')}}" oninput="showDiv()" id="name" type="text" data-bs-original-title="" title="" name="name" placeholder="Status Name" required>
                                @error('name')
                                <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Status Color</label>
                                <select name="status" id="status" class="form-select" aria-label="Default select example">
                                    <option value="">--Select Color--</option>
                                    <option value="btn btn-primary">btn btn-primary</option>
                                    <option value="btn btn-secondary">btn btn-secondary</option>
                                    <option value="btn btn-success">btn btn-success</option>
                                    <option value="btn btn-danger">btn btn-danger</option>
                                    <option value="btn btn-warning">btn btn-warning</option>
                                    <option value="btn btn-info">btn btn-info</option>
                                    <option value="btn btn-dark">btn btn-dark</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                            <tr class="text-center">
                                <td>{{$datas->id}}</td>
                                <td><span class=" custom-btn {{$datas->status}}">{{$datas->name}}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('status-edit', $datas->id)}}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>&nbsp;&nbsp;
                                        <button class="btn btn-danger delete-button" data-id="{{ $datas->id }}" type="button"><i class="fa fa-trash-o"></i> Trash</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        var alerts = $('#btn');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {

        button.addEventListener('click', function() {
            const Id = this.getAttribute('data-id');
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
                    fetch('status-delete/' + Id, {

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
                                    'Trash!',
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