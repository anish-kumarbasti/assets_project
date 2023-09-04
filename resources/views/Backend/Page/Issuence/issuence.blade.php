@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #myDiv {
            display: none;
        }

        .change-card {
            transition: all ease .5s;
        }

        .change-card:hover {
            transform: scale(1.1);
            transition: all ease .5s;
            cursor: pointer;
        }

        .selected {
            border: 2px solid green;
        }

        .locked {
            pointer-events: none;
            opacity: 0.7;

        }

        .card-footer {
            background-color: white;
            border-top: none;
            padding: 1rem;

        }

        .card-footer button {
            margin: 0;
        }


        .d-flex.justify-content-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-head {
            padding: 1rem;
            border-bottom: 1px solid black;
            margin-bottom: 0;
        }

        .card-body {
            padding-top: 0;
            padding-bottom: 1rem;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('Content-Area')
@if(session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div class="col-sm-12">
        <form class="needs-validation f1" action="{{ route('issuence.store') }}" method="POST" novalidate="">
            @csrf
            <div class="card" id="employee-step">
                <div class="card-header pb-0">
                    <h4>Employee Details</h4>
                </div>
                <div class="card-body">
                    <div class="card-item border card">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3"></div>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="employeeId">Employee's ID</label>
                                <input class="form-control" oninput="showDiv()" id="employeeId" type="search"
                                    name="employeeId" data-bs-original-title="" title=""
                                    placeholder="Enter Employee's ID" onkeydown="return event.key != 'Enter';"  required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label pt-5 scan-text">Scan Barcode :</label>
                                    <div class="col-sm-9 pt-4">
                                        <input class="form-control qr" type="file" accept="image/*" capture="environment"
                                            id="qrInput">
                                        <img id="qrImage"
                                            src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png') }}"
                                            alt="QR Code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-item border mt-3 card" id="myDiv" style="display: none;">
                        <div class="row p-3">
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Name:</label>
                                <input class="form-control" id="name" type="text" data-bs-original-title=""
                                    title="" placeholder="Abhi" readonly>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Department:</label>
                                <input class="form-control" id="depart" type="text" data-bs-original-title=""
                                    title="" placeholder="IT Department" readonly>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Designation:</label>
                                <input class="form-control" id="location" type="text" data-bs-original-title=""
                                    title="" placeholder="HR" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-item p-5">
                    <button class="btn btn-primary float-end" id="next-employee" data-next="select-asset-step"
                        type="button">Next</button>
                </div>
            </div>
            <div class="card" id="select-asset-step" style="display: none;">
                <div class="card-head">
                    <div class="row d-flex p-3">
                        <div class="col-sm-6 p-3">
                            <h4>Asset Details</h4>
                        </div>
                        <div class="col-sm-6 p-3 text-end">
                            <button class="btn btn-outline-primary role-btn" type="button"
                                data-original-title="btn btn-outline-danger-2x" id="addasset">
                                <i class="fa fa-plus"></i> Add Asset
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0" id="assetSelect">
                    <div class="card-item border">
                        <div class="row p-3">
                            <div class="col-md-4">
                                <label class="form-label" for="assetTypeSelect">Asset Type</label>
                                <select name="asset_type" class="form-select" aria-label="Default select example"
                                    id="assettype">
                                    <option selected>Select Asset Type</option>
                                    @foreach ($assettype as $assettype)
                                        <option value="{{ $assettype->id }}">{{ $assettype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="assetSelect">Asset</label>
                                <select class="form-select" name="asset" aria-label="Default select example"
                                    id="asset">
                                    <option selected>Select Asset</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="mb-3 row">
                                    <label class="col-sm-6 col-form-label pt-5 scan-text">Scan Barcode :</label>
                                    <div class="col-sm-6 pt-4">
                                        <input class="form-control qr" type="file" accept="image/*"
                                            capture="environment" id="qrInput">
                                        <img id="qrImage"
                                            src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png') }}"
                                            alt="QR Code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-item border mt-4 ui-sortable" id="draggableMultiple">
                            <div class="row p-3" id="assetdetails">

                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-secondary" id="prev-asset" data-prev="employee-step"
                            type="button">Previous</button>
                        <button class="btn btn-primary" id="next-assets" data-next="thirdStep"
                            type="button">Next</button>
                    </div>
                </div>
            </div>

            <div class="card" id="thirdStep" style="display: none;">
                <div class="card-header pb-0">
                    <h4>Selected Asset Summary</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="selectedAssetTable">
                        <thead>
                            <tr>
                                <th>Asset</th>
                                <th>Brand</th>
                                <th>Serial Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="footer-item p-5">
                    <button class="btn btn-secondary" id="prev-third" data-prev="select-asset-step"
                        type="button">Previous</button>
                    <button class="btn btn-primary" id="next-third" data-next="additional-detail-step"
                        type="button">Next</button>
                </div>
            </div>

            <div class="card mt-3" id="additional-detail-step" style="display: none;">
                <div class="card-body">

                    <div class="card-item border mt-3 pt-2">
                        <div class="row p-3">
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Issuing Time:</label>
                                <input class="form-control" name="time" id="validationCustom01" type="time"
                                    data-bs-original-title="" title="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Date of Issuing</label>
                                <input class="form-control" name="date" id="validationCustom01" type="date"
                                    data-bs-original-title="" title="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Due Date</label>
                                <input class="form-control" name="due_date" id="validationCustom01" type="date"
                                    data-bs-original-title="" title="">
                            </div>
                        </div>
                    </div>
                    <div class="card-item border">
                        <div class="row p-3">
                            <div class="col-md-12 mb-4">
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" placeholder="IT Assets"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-secondary" id="prev-detail" data-prev="thirdStep"
                            type="button">Previous</button>
                        <button class="btn btn-primary" id="allocate-assets-btn" type="button">Allocate Assets</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#assetSelect').hide();
            $('#addasset').on("click", function() {
                $('#assetSelect').show();
            });
        });
        jQuery(document).ready(function() {
            jQuery('#assettype').change(function() {
                let assettypeId = jQuery(this).val();
                // alert(assettypeId);
                jQuery('#asset').empty();

                if (assettypeId) {
                    jQuery.ajax({
                        url: '/get-asset-type/' + assettypeId,
                        type: 'POST',
                        data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function(data) {
                            jQuery('#asset').append('<option value="">Select Asset</option>');
                            jQuery.each(data.assets, function(key, value) {
                                jQuery('#asset').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            jQuery('#asset').trigger('change');
                        }

                    });

                }
            });
        });

        function storeStepData(step) {
            const inputs = step.querySelectorAll("input, select, textarea");
            const data = {};

            inputs.forEach(input => {
                data[input.name] = input.value;
            });
            sessionStorage.setItem(step.id, JSON.stringify(data));
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#draggableMultiple,#CardChange').hide();

            var selectedCards = {};

            function updateSelectedCards(cardId, isSelected) {
                if (isSelected) {
                    selectedCards[cardId] = true;
                } else {
                    delete selectedCards[cardId];
                }
            }

            function renderAssetCards(assets) {
                var assetDetailsContainer = $('#assetdetails');
                $('#draggableMultiple').show();
                assetDetailsContainer.empty();

                $.each(assets, function(index, asset) {
                    var allbrand = asset.brand;
                    var isSelected = selectedCards[asset.id];
                    var deselectButton = isSelected ? '<div class="deselect-button"></div>' : '';
                    var assetCard = `
                <div class="col-md-3">
                    <div class="card change-card ${isSelected ? 'selected' : ''}" data-card-id="${asset.id}">
                        <div class="card-body">
                            <h5 class="card-title card-text p-2">${asset.product_info}</h5>
                            <p class="card-subtitle mb-2">${allbrand ? 'Brand: <span class="text-muted">' + allbrand.name + '</span>' : 'Liscence Number: <span class="text-muted">' + (asset.liscence_number || 'N/A')}</span></p>
                            <p class="card-subtitle mb-2">${allbrand ? 'Brand Model : <span class="text-muted">' + (asset.brandmodel.name || 'N/A') + '</span>' : 'Configuration: <span class="text-muted">' + (asset.configuration || 'N/A')}</span></p>
                            <p class="card-subtitle mb-2">Price: <span class="text-muted">${asset.price}</span></p>
                            <input type="hidden" value="${asset.id}" name=cardId[] />
                            ${deselectButton}
                        </div>
                    </div>
                </div>
            `;
                    assetDetailsContainer.append(assetCard);
                });
            }

            $('#asset').change(function() {
                var assetId = $(this).val();
                if (assetId) {
                    $.ajax({
                        type: "POST",
                        url: "/get-asset-all-details/" + assetId,
                        data: {
                            _token: "{{ csrf_token() }}",
                            _cache: new Date().getTime()
                        },
                        success: function(response) {
                            renderAssetCards(response);
                        }
                    });
                }
            });

            $(document).on("click", ".change-card", function() {
                var card = $(this);
                var cardId = card.data("card-id");

                if (selectedCards[cardId]) {
                    updateSelectedCards(cardId, false);
                    card.removeClass("selected");
                    card.find(".deselect-button").remove();
                } else {
                    updateSelectedCards(cardId, true);
                    card.addClass("selected");
                    card.find(".card-body").append('<div class="deselect-button"></div>');
                }
            });

            $(document).on("click", ".deselect-button", function() {
                var card = $(this).closest(".change-card");
                var cardId = card.data("card-id");

                updateSelectedCards(cardId, false);
                card.removeClass("selected");
                $(this).remove();
            });
            const selectedAssetCards = {};

            function updateSelectedAssetCards(cardId, isSelected) {
                const selectedAssetCards = JSON.parse(sessionStorage.getItem('selectedAssetCards')) || {};

                if (isSelected) {
                    selectedAssetCards[cardId] = true;
                } else {
                    delete selectedAssetCards[cardId];
                }
                sessionStorage.setItem('selectedAssetCards', JSON.stringify(selectedAssetCards));
            }

            function renderSelectedAssetCards() {
                const tableBody = $('#selectedAssetTable tbody');
                tableBody.empty();
                const selectedCards = JSON.parse(sessionStorage.getItem('selectedAssetCards'));

                if (selectedCards) {
                    $.each(selectedCards, function(cardId, isSelected) {
                        if (isSelected) {
                            const assetCard = $(`.change-card[data-card-id="${cardId}"]`);
                            if (assetCard.length) { // Check if the card still exists
                                const assetName = assetCard.find('.card-title').text();
                                const brand = assetCard.find('.card-subtitle:eq(0) span').text();
                                const serialNumber = assetCard.find('.card-subtitle:eq(1) span').text();

                                const tableRow = `
                            <tr>
                                <td>${assetName}</td>
                                <td>${brand}</td>
                                <td>${serialNumber}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-asset" data-card-id="${cardId}">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        `;

                                tableBody.append(tableRow);
                            }
                        }
                    });
                }

                $('.remove-asset').click(function() {
                    const cardIdToRemove = $(this).data('card-id');
                    updateSelectedAssetCards(cardIdToRemove, false);
                    renderSelectedAssetCards();
                });
            }

            $('#next-assets').click(function() {
                selectedAssetCardsData = [];
                var selectedCards = JSON.parse(sessionStorage.getItem('selectedAssetCards'));
                console.log(selectedCards);
                if (selectedCards) {
                    renderSelectedAssetCards();
                }
            });
            $(document).on("click", ".change-card", function() {
                const cardId = $(this).data("card-id");
                const isSelected = selectedAssetCards[cardId];
                updateSelectedAssetCards(cardId, !isSelected);
                $(this).toggleClass("selected", !isSelected);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector(".f1");
            const steps = form.querySelectorAll(".card");
            const nextButtons = form.querySelectorAll("[data-next]");
            const prevButtons = form.querySelectorAll("[data-prev]");

            nextButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const currentStep = button.closest(".card");
                    const nextStepId = button.getAttribute("data-next");
                    const nextStep = form.querySelector(`#${nextStepId}`);

                    storeStepData(currentStep);

                    currentStep.style.display = "none";
                    nextStep.style.display = "block";
                });
            });
            prevButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const currentStep = button.closest(".card");
                    const prevStepId = button.getAttribute("data-prev");
                    const prevStep = form.querySelector(`#${prevStepId}`);
                    storeStepData(currentStep);
                    currentStep.style.display = "none";
                    prevStep.style.display = "block";
                });
            });
        });
    </script>
    <script>
        const form = document.querySelector(".f1");

        function showDiv() {
            var inputField = document.getElementById('employeeId');
            var div = document.getElementById('myDiv');

            if (inputField.value.trim() !== '') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        }
        $(document).ready(function() {
            $("#employeeId").on("input", function() {
                var employeeId = $(this).val();
                $.ajax({
                    url: "/server_script",
                    method: "GET",
                    data: {
                        employeeId: employeeId
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#name").val(data.first_name);
                        if (data.department) {
                            $("#depart").val(data.department.name);
                        } else {
                            $('#depart').val("");
                        }
                        if (data.designation) {
                            $("#location").val(data.designation.designation);
                        } else {
                            $("#location").val("");
                        }
                    }
                });
            });
        });

        $('#allocate-assets-btn').click(function() {
            form.submit();
        });
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            storeStepData(steps[steps.length - 1]);
            form.submit();
        });
    </script>
@endsection
