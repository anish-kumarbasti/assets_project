@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .change-card.selected {
        border: 2px solid #1774f7 !important;
        background-color: #d1f6fe !important;
    }

    .change-card:hover {
        transform: scale(.9);
    }
</style>
@endsection
@section('Content-Area')
@if (session('success'))
<div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div id="alerts" class="alert alert-danger inverse alert-dismissible fade show" role="alert">
    <p>{{ session('error') }}</b>
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
    <form class="needs-validation" method="post" action="{{ route('submit') }}" novalidate="">
        @csrf
        <div class="card" id="step1">
            <div class="card-header pb-0">
                <h4>Product Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5>No Asset for Returning</h5>
                    </div>
                    {{-- {{dd($data)}} --}}
                    @isset($data)
                    @foreach ($data as $asset)
                    <div class="col-md-3">
                        <div class="card change-card" data-card-id="{{ $asset->id }}" onclick="selectDeselect(this)">
                            <div class="card-body">
                                <h5 class="card-title card-text p-2">{{ $asset->product_info??'N/A'}}</h5>
                                <p class="card-subtitle mb-2">Type: <span class="text-muted">{{ $asset->asset_type->name??'N/A'}}</span></p>
                                <p class="card-subtitle mb-2">
                                    Brand: <span class="text-muted">{{ $asset->brand->name??'N/A'}}</span>
                                    License Number: <span class="text-muted">{{ $asset->license_number ?? 'N/A' }}</span>
                                </p>
                                <p class="card-subtitle mb-2">
                                    Brand Model: <span class="text-muted">{{ $asset->brandmodel->name ?? 'N/A' }}</span>
                                    Configuration: <span class="text-muted">{{ $asset->configuration ?? 'N/A' }}</span>
                                </p>
                                <p class="card-subtitle mb-2">Brand Model: <span class="text-muted">{{ $asset->supplier }}</p>
                                <p class="card-subtitle mb-2">Price: <span class="text-muted">{{ $asset->price }}</span></p>
                                <input type="hidden" value="{{ $asset->id }}" name="cardId[]">
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                </div>
            </div>
            <div class="card-footer d-flex text-end">
                <button class="btn btn-primary" id="next" style="display: none; margin-left: auto;" type="button">Next</button>
            </div>
        </div>
        <div class="card mt-3" id="step2" style="display: none;">
            <div class="card-body">
                <div class="card-head">
                    <h4>Asset Return</h4>
                </div>
                <div class="card-item border mt-3 card">
                    <div class="row p-3">
                        <div class="col-md-12 p-3">
                            <label for="text">Reason for Return</label>
                            <textarea name="description" id="text" placeholder="reason.." class="form-control" cols="20" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-secondary" id="previous" type="button">Previous</button>
                <button class="btn btn-primary" type="submit">Next</button>
            </div>
        </div>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var alerts = $('#alerts');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
<script>
    $(document).ready(function() {
        $('#next').click(function() {
            $('#step1').hide();
            $('#step2').show();
        });
        $('#previous').click(function() {
            $('#step1').show();
            $('#step2').hide();
        });
    });

    function selectDeselect(card) {
        card.classList.toggle('selected');

        // Check if at least one card is selected, then show the Next button
        if ($('.change-card.selected').length > 0) {
            $('#next').show();
        } else {
            $('#next').hide();
        }
    }
</script>
@endsection
