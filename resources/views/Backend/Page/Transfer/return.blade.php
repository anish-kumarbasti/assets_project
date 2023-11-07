@extends('Backend.Layouts.panel')

@section('Style-Area')
    <style>
        .btna {
            position: relative;
            padding: 10px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #ccc;
            background: #fff;
            color: #333;
            border-radius: 10px;
            width: 200px;
            text-align: center;
            /* border-radius: 25px; */
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
            border-radius: 10px;
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

        .selected {
            background-color: #d1f6fe !important;
        }

        .btn-add {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-remove {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
@endsection

@section('Content-Area')
    @if (session('success'))
        <div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert">
            <i class="icon-thumb-up alert-center"></i>
            <p>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div id="alerts" class="alert alert-danger inverse alert-dismissible fade show" role="alert">
            <p>{{ session('error') }}</p>
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
        <div class="card-item border mt-3 card">
            <div class="card-header pb-0 d-flex text-center switch-button-container">
                <div class="float-left col-sm-6 mt-2">
                    <h4>Choose Type:</h4>
                </div>
                <div class="col-sm-6 mb-4 text-end">
                    <a href="{{ url('transfer') }}" class="btna">
                        <input type="radio" class="toggle toggle-left" name="transfer-return" value="transfer"
                            id="transfer-radio">
                        <label for="transfer-radio">Transfer</label>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('return') }}" class="btna">
                        <input type="radio" class="toggle toggle-right" name="transfer-return" value="return"
                            id="return-radio" checked>
                        <label for="return-radio">Return</label>
                    </a>
                </div>
            </div>
        </div>
        <form class="needs-validation" method="post" action="{{ route('submit') }}" novalidate="">
            @csrf
            <div class="card" id="step1">
                <div class="card-header pb-0">
                    <h4>Product Details</h4>
                </div>
                <div class="card-body">
                    <table class="table" id="assetTable">
                        <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Product</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($data)
                                @foreach ($data as $asset)
                                    <tr class="unselected" data-card-id="{{ $asset->id }}">
                                        <td>{{ $asset->product_number ?? 'N/A' }}</td>
                                        {{-- <td>{{ $asset->brand->name ?? 'N/A' }}</td> --}}
                                        <td width="20%;">{{ $asset->product_info ?? 'N/A' }}</td>
                                        <td>{{ $asset->asset_type->name ?? 'N/A' }}</td>
                                        <td>{{ $asset->assetmain->name ?? 'N/A' }}</td>
                                        <td>
                                            <button type="button" class="btn-add" onclick="addRow(this)">Add</button>
                                            <button type="button" class="btn-remove" onclick="removeRow(this)"
                                                style="display: none;">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                {{-- <input type="hidden" name="selectedCardIds[]"> --}}
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

        function addRow(button) {
            const row = button.closest('tr');
            $(row).toggleClass('selected');
            $(button).hide();
            $(row).find('.btn-remove').show();
            var cardId = $(button).closest('tr').data('card-id');
            $('#assetTable').append('<input type="hidden" name="selectedAssets[]" value="' + cardId + '">');
        }

        function removeRow(button) {
            const row = button.closest('tr');
            $(row).toggleClass('selected');
            $(button).hide();
            $(row).find('.btn-add').show();
            updateSelectedCardIds();
        }

        function updateSelectedCardIds() {
            const selectedIds = $('.selected').map(function() {
                return $(this).data('card-id');
            }).get();
            $('#assetTable').append('<input type="hidden" name="selectedAssets[]" value="' + selectedIds + '">');
        }

        $('.select-checkbox').change(function() {
            const row = $(this).closest('tr');
            if (this.checked) {
                addRow(row.find('.btn-add'));
            } else {
                removeRow(row.find('.btn-remove'));
            }
        });

        $('#next').click(function() {
            if ($('.selected').length > 0) {
                $('#step1').hide();
                $('#step2').show();
            }
        });

        $('#previous').click(function() {
            $('#step1').show();
            $('#step2').hide();
        });
    </script>
@endsection
