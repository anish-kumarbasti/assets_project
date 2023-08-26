@extends('Backend.Layouts.panel')

@section('Content-Area')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Add Asset</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" method="POST" action="{{ route('assets.store') }}">
                @csrf
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="assetName">Select Asset Type </label>
                            <select class="form-select" id="" name="assettype_id" required>
                                <option value="" disabled selected>Select type</option>
                                @foreach ($assettype as $assettype)
                                <option value="{{ $assettype->id }}">{{ $assettype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="assetName">Asset Name </label>
                            <input class="form-control" id="assetName" name="name" type="text" required="" placeholder="Enter Asset Name ">
                        </div>
                    </div>

                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit">ADD</button>
                    <button class="btn btn-warning mt-3" type="reset">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection