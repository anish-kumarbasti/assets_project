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
    @isset($jsonData)
        @php
            $data = json_decode($jsonData);
        @endphp
    @endisset
    <div class="col-sm-12">
        <form class="needs-validation" novalidate="">
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
                                @if (isset($data->employee))
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label" for="validationCustom01">Name:</label>
                                        <input class="form-control" id="name" value="{{ $data->employee->first_name }}"
                                            type="text" data-bs-original-title="" title="" placeholder="Abhi"
                                            readonly>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label" for="validationCustom01">Department:</label>
                                        <input class="form-control" id="depart"
                                            value="{{ $data->employee->department->name }}" type="text"
                                            data-bs-original-title="" title="" placeholder="IT Department" readonly>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label" for="validationCustom01">Designation:</label>
                                        <input class="form-control" id="location"
                                            value="{{ $data->employee->designation->name }}" type="text"
                                            data-bs-original-title="" title="" placeholder="HR" readonly>
                                    </div>
                                @else
                                    <p>No employee found for the given criteria.</p>
                                @endif
                            </div>
                        </div>
                        <div class="card-item mt-3">
                            <div class="row py-3" id="assetdetail">
                                @if (isset($data->products) && count($data->products) > 0)
                                    <h2>Products</h2>
                                    <ul>
                                        @foreach ($data->products as $product)
                                            <div class="col-md-3">
                                                <div class="card change-card" data-card-id="{{ $product->id }}">
                                                    <div class="card-body">
                                                        <h5 class="card-title card-text p-2">{{ $product->product_info }}
                                                        </h5>
                                                        <p class="card-subtitle mb-2">Type: <span
                                                                class="text-muted">{{ $product->asset_type->name }}</span>
                                                        </p>
                                                        <p class="card-subtitle mb-2">
                                                            Brand: <span
                                                                class="text-muted">{{ $product->brand->name ?? 'N/A' }}</span>
                                                            License Number: <span
                                                                class="text-muted">{{ $product->liscense_number ?? 'N/A' }}</span>
                                                        </p>
                                                        <p class="card-subtitle mb-2">
                                                            Brand Model: <span
                                                                class="text-muted">{{ $product->brandmodel->name ?? 'N/A' }}</span>
                                                            Configuration: <span
                                                                class="text-muted">{{ $product->configuration ?? 'N/A' }}</span>
                                                        </p>
                                                        <p class="card-subtitle mb-2">Supplier: <span
                                                                class="text-muted">{{ $product->supplier->name }}</span>
                                                        </p>
                                                        <p class="card-subtitle mb-2">Price: <span
                                                                class="text-muted">{{ $product->price }}</span></p>
                                                        <input type="hidden" value="{{ $product->id }}" name="cardId[]">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No products found for the employee.</p>
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button class="btn btn-secondary prev-step" id="prev-asset" type="button">Previous</button>
                                <button class="btn btn-primary next-step" id="next-assets" data-step="thirdStep"
                                    type="button">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3" id="thirdStep" style="display: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label class="form-label" for="validationCustom01">Transfer Reason:</label>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="transferReason"
                                        id="replacementRadio" value="replacement">
                                    <label class="form-check-label" for="replacementRadio">Replacement</label>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="transferReason"
                                        id="itClearanceRadio" value="itClearance" required>
                                    <label class="form-check-label" for="itClearanceRadio">IT Clearance</label>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                                    <option selected>Vacation</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-secondary prev-step" id="prev-asset" data-step="employee-step"
                            type="button">Previous</button>
                        <button class="btn btn-primary next-step" id="next-assets" data-step="fourthStep"
                            type="button">Next</button>
                    </div>
                </div>
                {{-- <div class="card mt-3 mb-3">
      <div class="card-body">
         <div class="row">
            <div class="col-md-3 mt-2 text-center">
               <label class="form-label scan-text" for="validationCustom01">1.Laptop</label>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio" value="replacement">
                  <label class="form-check-label scan-text" for="replacementRadio">Will Keep With IT</label>
               </div>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio" value="itClearance" required>
                  <label class="form-check-label scan-text" for="itClearanceRadio">Handover To </label>
               </div>
            </div>
            <div class="col-md-3">
               <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                  <option selected>Vacation</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 mt-2 text-center cart-2">
               <label class="form-label scan-text" for="validationCustom01">2.Monitor</label>
            </div>
            <div class="col-md-3 mt-2 text-center cart-2">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio" value="replacement">
                  <label class="form-check-label scan-text" for="replacementRadio">Will Keep With IT</label>
               </div>
            </div>
            <div class="col-md-3 mt-2 text-center cart-2">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio" value="itClearance" required>
                  <label class="form-check-label scan-text" for="itClearanceRadio">Handover To</label>
               </div>
            </div>
            <div class="col-md-3 mt-2 cart-2">
               <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                  <option selected>Vacation</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 mt-2 text-center">
               <label class="form-label scan-text" for="validationCustom01">3. Phone:</label>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio" value="replacement">
                  <label class="form-check-label scan-text" for="replacementRadio">Will Keep With IT</label>
               </div>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio" value="itClearance" required>
                  <label class="form-check-label scan-text" for="itClearanceRadio">Handover To</label>
               </div>
            </div>
            <div class="col-md-3 mt-2">
               <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                  <option selected>Vacation</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 mt-2 text-center">
               <label class="form-label scan-text" for="validationCustom01">4.Phone</label>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio" value="replacement">
                  <label class="form-check-label scan-text" for="replacementRadio">Will Keep With IT</label>
               </div>
            </div>
            <div class="col-md-3 mt-2 text-center">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio" value="itClearance" required>
                  <label class="form-check-label scan-text" for="itClearanceRadio">IT Clearance</label>
               </div>
            </div>
            <div class="col-md-3 mt-2">
               <select class="form-select" aria-label="Default select example" id="transferTypeSelect">
                  <option selected>Vacation</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
               </select>
            </div>
         </div>
      </div>
   </div> --}}
                <div class="card-item border mt-3 card" id="fourthStep" style="display: none;">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="footer-item mt-3 mb-3 d-flex justify-content-end">
                        <button class="btn btn-secondary prev-step" id="prev-asset" data-step="thirdStep"
                            type="button">Previous</button>
                        <button class="btn btn-primary mt-2" type="submit" data-bs-original-title=""
                            title="">Proceed
                            Request</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const steps = ["employee-step", "select-asset-step", "thirdStep", "fourthStep"];
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
        var selectedCards = {};
        $(document).ready(function() {
            $("#employeeId").on("input", function() {
                var employeeId = $(this).val();
                //  alert(employeeId);
                $.ajax({
                    url: "/server_asset_script",
                    method: "GET",
                    data: {
                        employeeId: employeeId,
                    },
                    dataType: "json",
                });
            });
        });
    </script>
@endsection
