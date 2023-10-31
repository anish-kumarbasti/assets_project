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

        .btna {
            position: relative;
            padding: 10px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #ccc;
            background: #fff;
            color: #333;
        }

        .btna label {
            white-space: nowrap;
            /* Prevent text wrapping */
        }

        input[type="radio"].toggle {
            display: none;
        }

        input[type="radio"].toggle+label {
            min-width: 60px;
            white-space: nowrap;
        }

        input[type="radio"].toggle:checked+label {
            border-color: #11014d;
            color: #11014d;
            background: #e6f7ff;
        }

        input[type="radio"].toggle:checked+label::before {
            content: '';
            position: absolute;
            left: -0px;
            top: -0px;
            width: 100%;
            height: 100%;
            background-color: #11014d;
            color: white;
            transition: transform 0.3s;
        }

        input[type="radio"].toggle-right:checked+label::before {
            content: 'Return';
            padding: 10px;
            color: white;
            font-weight: bold;
            transform: translateX(0);
            border: none;
        }

        input[type="radio"].toggle-left:checked+label::before {
            content: 'Transfer';
            padding: 10px;
            color: white;
            border: none;
            font-weight: bold;
            transform: translateX(0);
        }
    </style>
@endsection
@section('Content-Area')
    @if (session('success'))
        <div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
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
        <div class="card text-center switch-button-container">
            <div class="card-body">
                <b>Choose Type:</b>
                <a href="{{ url('transfer') }}" class="btna">
                    <input type="radio" class="toggle toggle-left" name="transfer-return" value="transfer"
                        id="transfer-radio">
                    <label for="transfer-radio">Transfer</label>
                </a>
                <a href="{{ route('return') }}" class="btna">
                    <input type="radio" class="toggle toggle-right" name="transfer-return" value="return"
                        id="return-radio" checked>
                    <label for="return-radio">Return</label>
                </a>
            </div>
        </div>
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
                                    <div class="card change-card" data-card-id="{{ $asset->id }}"
                                        onclick="selectDeselect(this)">
                                        <div class="card-body">
                                            <h5 class="card-title card-text p-2">{{ $asset->product_info ?? 'N/A' }}</h5>
                                            <p class="card-subtitle mb-2">Type: <span
                                                    class="text-muted">{{ $asset->asset_type->name ?? 'N/A' }}</span></p>
                                            <p class="card-subtitle mb-2">
                                                Brand: <span class="text-muted">{{ $asset->brand->name ?? 'N/A' }}</span>
                                                License Number: <span
                                                    class="text-muted">{{ $asset->license_number ?? 'N/A' }}</span>
                                            </p>
                                            <p class="card-subtitle mb-2">
                                                Brand Model: <span
                                                    class="text-muted">{{ $asset->brandmodel->name ?? 'N/A' }}</span>
                                                Configuration: <span
                                                    class="text-muted">{{ $asset->configuration ?? 'N/A' }}</span>
                                            </p>
                                            <p class="card-subtitle mb-2">Brand Model: <span
                                                    class="text-muted">{{ $asset->supplier }}</p>
                                            <p class="card-subtitle mb-2">Price: <span
                                                    class="text-muted">{{ $asset->price }}</span></p>
                                            @if (isset($selectedCardIds) && in_array($asset->id, $selectedCardIds))
                                                <input type="hidden" value="{{ $asset->id }}"
                                                    name="cardId[{{ $asset->id }}]">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                {{-- <div class="card-footer d-flex text-end">
                    <button class="btn btn-primary" id="next" style="display: none; margin-left: auto;"
                        type="button">Next</button>
                </div> --}}
            </div>
            <div class="card mt-3" id="step2">
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
                <div class="card-footer d-flex justify-content-end">
                    {{-- <button class="btn btn-secondary" id="previous" type="button">Previous</button> --}}
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
        const transferButton = document.querySelector('#transfer-radio');
        const returnButton = document.querySelector('#return-radio');
        transferButton.addEventListener('click', function() {
            window.location.href = "{{ url('transfer') }}";
        });
        returnButton.addEventListener('click', function() {
            window.location.href = "{{ route('return') }}";
        });

        function selectDeselect(card) {
            $(card).toggleClass('selected');
            checkSelection(card);
        }

        function checkSelection(card) {
            if ($(card).hasClass('selected')) {
                $(card).append('<input type="hidden" value="' + $(card).data('card-id') + '" name="cardId[' + $(card).data(
                    'card-id') + ']">');
            } else {
                $(card).find('input[name^="cardId"]').remove();
            }

            if ($('.change-card.selected').length > 0) {
                $('#next').show();
            } else {
                $('#next').hide();
            }
        }

        $('#next').click(function() {
            if ($('.change-card.selected').length > 0) {
                $('#step1').hide();
                $('#step2').show();
            }
        });

        $('#previous').click(function() {
            $('#step1').show();
            $('#step2').hide();
        });



        // function selectDeselect(card) {
        //     card.classList.toggle('selected');

        //     // Check if at least one card is selected, then show the Next button
        //     if ($('.change-card.selected').length > 0) {
        //         $('#next').show();
        //     } else {
        //         $('#next').hide();
        //     }
        // }
    </script>
@endsection