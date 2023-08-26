@extends('Backend.Layouts.panel')

@section('Content-Area')

<div class="col-sm-12">
    @if (session('success'))
    <div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
        <p>{{ session('success') }}</b>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
        <div class="card-header pb-0">
            <h4>
                Users
                <a href="{{ route('users.create') }}" class="btn btn-primary float-right">Add User</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profile Photo</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo" style="width: 100px; height: 100;">
                            </td>
                            <td>{{$user->department->name??''}}</td>
                            <td> {{ $user->designation->designation??'' }} </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger sweet-5" type="submit" style="display: inline-block;" onclick="return  confirm('Are you sure')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
