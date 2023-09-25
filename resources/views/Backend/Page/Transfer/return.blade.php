@extends('Backend.Layouts.panel')
@section('Content-Area')
    @if (session('success'))
        <div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p>{{ session('success') }}</b>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <div class="card-item border card">
                        @foreach ($data as $asset)
                            <div class="col-md-3">
                                <div class="card change-card {{ $isSelected ? 'selected' : '' }}"
                                    data-card-id="{{ $asset->id }}">
                                    <div class="card-body">
                                        <h5 class="card-title card-text p-2">{{ $asset->product_info }}</h5>
                                        <p class="card-subtitle mb-2">Type: <span
                                                class="text-muted">{{ $asset->asset_type->name }}</span></p>
                                        <p class="card-subtitle mb-2">
                                            @if ($allbrand)
                                                Brand: <span class="text-muted">{{ $allbrand->name }}</span>
                                            @else
                                                License Number: <span
                                                    class="text-muted">{{ $asset->license_number ?? 'N/A' }}</span>
                                            @endif
                                        </p>
                                        <p class="card-subtitle mb-2">
                                            @if ($allbrand)
                                                Brand Model: <span
                                                    class="text-muted">{{ $asset->brandmodel->name ?? 'N/A' }}</span>
                                            @else
                                                Configuration: <span
                                                    class="text-muted">{{ $asset->configuration ?? 'N/A' }}</span>
                                            @endif
                                        </p>
                                        <p class="card-subtitle mb-2">Brand Model: <span
                                                class="text-muted">{{ $asset->supplier }}</p>
                                        <p class="card-subtitle mb-2">Price: <span
                                                class="text-muted">{{ $asset->price }}</span></p>
                                        <input type="hidden" value="{{ $asset->id }}" name="cardId[]">
                                        <button class="btn btn-primary"
                                            onclick="selectDeselect(this)">Select/Deselect</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-primary" id="next" type="button">Next</button>
                </div>
            </div>
            <div class="card mt-3" id="step2" style="display: none;">
                <div class="card-body">
                    <div class="card-head">
                        <h4>Asset Return</h4>
                    </div>
                    <div class="card-item border mt-3 card mx-4" id="handoveremployee" style="display: none;">
                        <div class="row p-3">
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Name:</label>
                                <input class="form-control" id="employeename" type="text" data-bs-original-title=""
                                    title="" placeholder="Abhi" readonly>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Department:</label>
                                <input class="form-control" id="department" type="text" data-bs-original-title=""
                                    title="" placeholder="IT Department" readonly>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Designation:</label>
                                <input class="form-control" id="designation" type="text" data-bs-original-title=""
                                    title="" placeholder="HR" readonly>
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
            $('#next').click(function() {
                $('#step1').hide();
                $('#step2').show();
            });
            $('#previous').click(function() {
                $('#step1').show();
                $('#step2').hide();
            });
        });

        function selectDeselect(button) {
            var card = button.closest('.card');
            if (card.classList.contains('selected')) {
                card.classList.remove('selected');
                // update hidden form field to indicate card is deselected
            } else {
                card.classList.add('selected');
                // update hidden form field to indicate card is selected
            }
        }
    </script>
@endsection
