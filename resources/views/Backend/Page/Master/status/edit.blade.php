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
                        <div class="col-md-12 mb-2">
                            <label class="form-label" for="status">Status Color</label>
                            <select name="status" id="status" class="form-select" aria-label="Default select example">
                                <option value="">{{$status->status}}</option>
                                <option value="btn btn-primary">btn btn-primary</option>
                                <option value="btn btn-secondary">btn btn-secondary</option>
                                <option value="btn btn-success">btn btn-success</option>
                                <option value="btn btn-danger">btn btn-danger</option>
                                <option value="btn btn-warning">btn btn-warning</option>
                                <option value="btn btn-info">btn btn-info</option>
                                <option value="btn btn-dark">btn btn-dark</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
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