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
                <form action="{{ route('attribute-update', $attribute->id) }}" method="POST">
                    @isset($attribute)
                    @method('PUT')
                    @endisset
                    @csrf
                    <div class="card-item border">
                        <div class="row p-4">
                            <div class="col-md-12 mb-1 d-flex align-items-center">
                                <input class="form-control" @error('name') is-invalid @enderror id="name" type="text"
                                    name="name" value="{{ $attribute->name }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="footer-item">
                        <button class="btn btn-primary mt-3" type="submit">Update</button>
                        <a class="btn btn-warning mt-3" href="{{ url('attribute') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('Script-Area')
@endsection
