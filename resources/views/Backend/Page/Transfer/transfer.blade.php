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
            <div class="card mt-3" id="select-asset-step">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="form-label" for="validationCustom01">Transfer Reason:</label>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transferReason" id="replacementRadio"
                                    value="replacement">
                                <label class="form-check-label" for="replacementRadio">Replacement</label>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transferReason" id="itClearanceRadio"
                                    value="itClearance" required>
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
                     <button class="btn btn-secondary" id="prev-asset" data-prev="employee-step"
                     type="button">Previous</button>
                     <button class="btn btn-primary" id="next-assets" data-next="thirdStep"
                     type="button">Next</button>
                 </div>
            </div>
            <div class="card mt-3" id="thirdStep" style="display: none;">
                <div class="card-body">
                    <div class="card-header pb-0">
                    </div>
                    <div class="row py-3">
                        <!-- First Card -->
                        <div class="col-md-3">
                            <h5>1. Laptop<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
                            <div class="card card-box">
                                <div class="card-body">
                                    <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- Second Card -->
                        <div class="col-md-3">
                            <h5>2. Monitor<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
                            <div class="card card-box">
                                <div class="card-body">
                                    <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- Third Card -->
                        <div class="col-md-3">
                            <h5>3. Phone<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
                            <div class="card card-box">
                                <div class="card-body">
                                    <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- Fourth Card -->
                        <div class="col-md-3">
                            <h5>4. Phone<span class="cross-icon"><i class="fa fa-close"></i></span></h5>
                            <div class="card card-box">
                                <div class="card-body">
                                    <h5 class="card-title card-text p-2">Dell Inspiron 5510</h5>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>Dell</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Brand: <span>0123456789</span></p>
                                    <p class="card-subtitle mb-2 text-muted">Price: <span>62,000/-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                  <button class="btn btn-secondary" id="prev-asset" data-prev="select-asset-step"
                  type="button">Previous</button>
                  <button class="btn btn-primary" id="next-assets" data-next="fourthStep"
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
                   <button class="btn btn-secondary" id="prev-asset" data-prev="thirdStep"
                   type="button">Previous</button>
                    <button class="btn btn-primary mt-2" type="submit" data-bs-original-title="" title="">Proceed
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
    </script>
@endsection
