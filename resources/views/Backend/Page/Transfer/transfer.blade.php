@extends('Backend.Layouts.panel')

@section('Style-Area')
    <style>
        #myDiv {
            display: none;
        }

        .change-card {
            transform: none;
            transition: all ease .5s;
        }

        .change-card:hover {
            transition: all ease .5s;
            cursor: pointer;
        }

        .selected {
            background-color: #e6f7ff;
            border: 2px solid #007bff;
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
@if (session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
        class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger inverse alert-dismissible fade show" role="alert">
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
        <form class="needs-validation" method="post" action="{{ route('transfer-store') }}" novalidate="">
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
                                    placeholder="Enter Employee's ID" onkeydown="return event.key != 'Enter';" required>
                                    @error('employeeId')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                    @enderror
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
                    <div id="myDiv" style="display: none;">
                        <div class="card-item border mt-3 card">
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
                        <div class="card-item mt-3">
                           <input type="hidden" name="cardId[]" id="selectedCardIds" value="fsfs">
                            <div class="row py-3" id="assetdetail">
                                <h2>Assets</h2>
                                <ul>
                                 <!-- Products will be displayed here dynamically in the success callback -->
                                </ul>
                            </div>
                            <div class="card-footer d-flex justify-content-between float-end">
                                <button class="btn btn-primary next-step" id="next-assets" data-step="select-asset-step"
                                    type="button">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3" id="select-asset-step" style="display: none;">
                <div class="card-body">
                    <div class="card-head">
                        <h4>Transfer Reason</h4>
                    </div>
                    <div class="row mx-4">
                        <div class="col-md-12 mt-2 mb-4">
                            <label class="form-label" for="validationCustom01">Transfer Reason:</label>
                            <select class="form-control" aria-label="Default select example" name="reason"
                                id="transferTypeSelect">
                                <option selected>Select Reason</option>
                                @foreach ($reason as $reasons)
                                    <option value="{{ $reasons->id }}">{{ $reasons->reason }}</option>
                                @endforeach
                            </select>
                            @error('reason')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                            
                        </div>
                        <div class="col-md-12 mb-4">
                           <label class="form-label" for="employeeId">Handover to Employee's</label>
                           <input class="form-control"name="handoverId" data-bs-original-title="" title=""
                               placeholder="Enter Employee's ID" id="handoveremployeeId" oninput="handover()" onkeydown="return event.key != 'Enter';" required>
                               @error('handoverId')
                               <span class="text-danger">
                                   {{ $message }}
                               </span>
                               @enderror
                       </div>
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
                    <button class="btn btn-secondary prev-step" id="prev-asset" data-step="employee-step"
                        type="button">Previous</button>
                    <button class="btn btn-primary next-step" id="next-assets" data-step="additional-details-step"
                        type="button">Next</button>
                </div>
            </div>
            <div class="card mt-3" id="additional-details-step" style="display: none;">
               <div class="card-header"><h4>Description</h4></div>
                <div class="row px-5">
                    <div class="col-md-12 mb-4">
                        <label class="form-label" for="validationCustom01">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="" name="description" rows="3"></textarea>
                        @error('description')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="footer-item mt-3 mb-3 d-flex justify-content-end">
                    <button class="btn btn-secondary prev-step" id="prev-asset" data-step="select-asset-step"
                        type="button">Previous</button>
                    <button class="btn btn-primary mt-2" type="submit" data-bs-original-title="" title="">Proceed
                        Request</button>
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
            const steps = ["employee-step", "select-asset-step", "additional-details-step"];
            let currentStep = 0;

            $(".next-step").click(function() {
                $("#" + steps[currentStep]).hide();
                currentStep++;
                $("#" + steps[currentStep]).show();
            });

            $(".prev-step").click(function() {
                $("#" + steps[currentStep]).hide();
                currentStep--;
                $("#" + steps[currentStep]).show();
            });
        });
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
        function handover() {
            var inputField = document.getElementById('handoveremployeeId');
            var div = document.getElementById('handoveremployee');

            if (inputField.value.trim() !== '') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        }

        var selectedCards = {};

        $(document).ready(function() {
            $("#employeeId").on("input", function() {
                var employeeId = $(this).val();

                // Make an AJAX request to fetch employee and product data
                $.ajax({
                    url: "/server_asset_script",
                    method: "GET",
                    data: {
                        employeeId: employeeId,
                    },
                    dataType: "json",
                    success: function(data) {
                        // Update the employee and product data in the UI
                        if (data.employee) {
                            $("#name").val(data.employee.first_name);
                            $("#depart").val(data.employee.department.name);
                            $("#location").val(data.employee.designation.name);
                        } else {
                            $("#name").val('');
                            $("#depart").val('');
                            $("#location").val('');
                        }

                        // Populate the products list
                        var productList = $("#assetdetail ul");
                        productList.empty();

                        if (data.products && data.products.length > 0) {
                            // Create a row div to contain the products
                            var productRow = $("<div>", {
                                class: "row",
                            });

                            data.products.forEach(function(product) {
                                var colDiv = $("<div>", {
                                    class: "col-sm-3",
                                });

                                var card = $("<div>", {
                                    class: "card change-card",
                                    "data-card-id": product.id,
                                });

                                var cardBody = $("<div>", {
                                    class: "card-body",
                                });

                                cardBody.append($("<h5>", {
                                    class: "card-title card-text p-2",
                                    text: product.product_info,
                                }));

                                cardBody.append($("<p>", {
                                    class: "card-subtitle mb-2",
                                    text: "Type: " + product.asset_type
                                        .name,
                                }));

                                var brandInfo = "Brand: " + (product.brand ? product
                                    .brand.name : 'N/A');
                                brandInfo += " License Number: " + (product
                                    .liscense_number ? product.liscense_number :
                                    'N/A');
                                cardBody.append($("<p>", {
                                    class: "card-subtitle mb-2",
                                    html: brandInfo,
                                }));

                                var brandModelConfigInfo = "Brand Model: " + (product
                                    .brandmodel ? product.brandmodel.name : 'N/A');
                                brandModelConfigInfo += " Configuration: " + (product
                                    .configuration ? product.configuration : 'N/A');
                                cardBody.append($("<p>", {
                                    class: "card-subtitle mb-2",
                                    html: brandModelConfigInfo,
                                }));

                                cardBody.append($("<p>", {
                                    class: "card-subtitle mb-2",
                                    text: "Supplier: " + product.getsupplier
                                        .name,
                                }));

                                cardBody.append($("<p>", {
                                    class: "card-subtitle mb-2",
                                    text: "Price: " + product.price,
                                }));

                                card.append(cardBody);
                                colDiv.append(card);
                                productRow.append(colDiv);
                                card.on("click", function() {
                                    var cardId = product.id;
                                    if (selectedCards[cardId]) {
                                        // Deselect the card
                                        card.removeClass("selected");
                                        delete selectedCards[cardId];
                                    } else {
                                        // Select the card
                                        card.addClass("selected");
                                        selectedCards[cardId] = true;
                                    }
                                    updateSelectedCardsList();
                                });
                            });
                            productList.append(productRow);
                            $("#next-assets").show();
                        } else {
                            productList.append($("<p>", {
                                text: "No products found for the employee.",
                            }));
                            $("#next-assets").hide();
                        }
                    },
                    error: function() {
                        console.error("AJAX request failed: " + error.statusText);
                        $("#next-assets").hide();
                    },
                });
            });
        });

        function updateSelectedCardsList() {
            var listContainer = $("#assetdetail");
            var selectedCardIds = []; // Array to store selected card IDs
            for (var cardId in selectedCards) {
                if (selectedCards.hasOwnProperty(cardId)) {
                   selectedCardIds.push(cardId); // Add the selected card ID to the array
                  }
               }
               var type = $("#selectedCardIds").val(selectedCardIds.join(',')); // Join the IDs with a comma
               console.log(type);
            // Update the hidden input field with the selected card IDs
        }
        $(document).ready(function() {
            $("#handoveremployeeId").on("input", function() {
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
                        $("#employeename").val(data.first_name);
                        if (data.department) {
                            $("#department").val(data.department.name);
                        } else {
                            $('#department').val("");
                        }
                        if (data.designation) {
                            $("#designation").val(data.designation.designation);
                        } else {
                            $("#designation").val("");
                        }
                    }
                });
            });
        });
    </script>
@endsection
