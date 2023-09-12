@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
@if (session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{session('success')}}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Edit BrandModel</h4>
        </div>
        <div class="card-body">
            {{-- @dd($brandmodel); --}}
            <form action="{{ route('brand-model.update', $brandmodel->id) }}" method="POST">
                @isset($brandmodel)
                @method('PATCH')
                @endisset
                @csrf
                <div class="card-item">
                    <div class="row p-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="validationCustom01">Select Brand</label>
                            <select class="form-select" id="brand_id" name="brand_id" required>
                                <option value="" disabled>Select a Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if($brand->id == $brandmodel->brand_id) selected @endif>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation_name">Brand Model</label>
                            <input class="form-control" id="name" type="text" name="brand" value="{{ $brandmodel->name }}" required>
                        </div>
                    </div>
                    <div class="footer-item">
                        <button class="btn btn-primary mt-3" type="submit">Update</button>
                        <a class="btn btn-warning mt-3" href="{{ url('brand-model') }}">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
@endsection