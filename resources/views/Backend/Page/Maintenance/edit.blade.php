@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Update Maintenance</h4>
            <hr>
        </div>
        <div class="card">
            <form action="{{ url('maintainans-update', $maintainance->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Asset</label>
                                <select class="form-select" id="asset" name="asset" aria-label="Default select example">
                                    @foreach ($asset as $assets)
                                    <option value="{{ $assets->name }}" {{ $maintainance->asset == $assets->id ? 'selected' : '' }}>
                                        {{ $assets->name }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-2">
                                <label class="form-label">Supplier</label>
                                <select class="form-select" id="supplier" name="supplier" aria-label="Default select example">
                                    @foreach ($supplier as $suppliers)
                                    <option value="{{$suppliers->name}}" {{$maintainance->supplier == $suppliers->id ? 'selected':''}}>{{$suppliers->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Asset Type</label>
                                <select class="form-select" id="type" name="type" aria-label="Default select example">
                                    @foreach ($assettype as $assettypes)
                                    <option value="{{$assettypes->name}}" {{$maintainance->type == $assettypes->id ? 'selected':''}}>{{$assettypes->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" value="{{$maintainance->start_date}}" name="start_date" id="start_date">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" value="{{$maintainance->end_date}}" name="end_date" id="end_date">
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        <div class="footer-item">
            <button class="btn btn-primary mt-3" type="submit">Update</button>
            <a href="{{route('assets-maintenances')}}" class="btn btn-warning mt-3" type="reset">Cancel</a>
        </div>
        </form>
    </div>
</div>
</div>
@endsection