@extends('Backend.Layouts.panel')

@section('Style-Area')
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
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $department->name) }}" required>
                            @error('name')
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