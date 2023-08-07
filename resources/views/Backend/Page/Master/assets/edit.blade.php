@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Edit Asset</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" method="POST" action="{{ route('assets.update', $asset->id) }}">
                @csrf
                @method('PUT')
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="assetName">Asset Name </label>
                            <input class="form-control" id="assetName" name="name" type="text" required="" value="{{ $asset->name }}">
                        </div>
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                    <button class="btn btn-warning mt-3" type="reset">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
