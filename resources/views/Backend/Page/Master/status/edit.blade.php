@extends('Backend.Layouts.panel')
@section('Content-Area')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Update Status</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" action="{{url('update-status',$status->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-item">
                    <div class="row p-2">
                        <div class="col-md-12 mb-2">
                            <label class="form-label" for="name">Status Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$status->name}}" placeholder="Status Name">
                        </div>
                        <!-- <div class="col-md-12 mb-2">
                            <label class="form-label" for="status">Status</label>
                            <input class="form-control" id="status" type="text" name="status" value="{{$status->status}}" placeholder="Status">
                            @error('status')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div> -->
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                    <a href="{{route('change-status')}}" class="btn btn-warning mt-3">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection