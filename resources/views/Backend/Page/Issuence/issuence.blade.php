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
            background-color: #e6ffe8;
            border: 2px solid rgb(161, 218, 161);
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
        <div id="issue" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p>{{ session('success') }}</b>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div id="issue" class="alert alert-danger inverse alert-dismissible fade show" role="alert">
            <p>{{ session('error') }}</b>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div id="issue" class="alert alert-danger outline" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
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
            </div>
            <div class="card mt-3" id="select-asset-step">
                <div class="card-header">
                    <h4>Select Product</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="card-item border card" style="transform: translateY(-2.5rem);">
                        <div class="row p-3">
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="serialNumber">Asset code:</label>
                                <input class="form-control" id="serialNumber" value="{{ old('serialNumber') }}"
                                    name="serialNumber" type="text" data-bs-original-title="" title=""
                                    placeholder="Enter Asset Number">
                                @error('serialNumber')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-item" id="assetSelect">
                        <div class="card-item ui-sortable" id="draggableMultiple">
                            <div class="row p-3" id="assetdetails">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3" id="selectedAssetCard">
                <input type="hidden" name="selectedAssets[]" value="">
                <div class="card-header pb-0">
                    <h4>Selected Asset Summary</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="selectedAssetTable">
                        <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Product</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3" id="additional-detail-step">
                <div class="card-header">
                    <h4>Additional Details</h4>
                </div>
                <div class="card-body">
                    <div class="card-item border mt-3 pt-2">
                        <div class="row p-3">
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="timePickerInput">Issuing Time:</label>
                                <input class="form-control" name="time" value="{{ old('time') }}"
                                    id="timePickerInput" type="time" data-bs-original-title="" title=""
                                    required>
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Date of Issuing</label>
                                <input class="form-control" name="date" id="datePickerInput" type="date"
                                    value="{{ old('date') }}" data-bs-original-title="" title="" required>
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Due Date</label>
                                <input class="form-control" name="due_date" id="dueDatePickerInput"
                                    value="{{ old('due_date') }}" type="date" data-bs-original-title=""
                                    title="" required>
                                @error('due_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Location</label>
                                <select name="location_id" class="form-control" id="locationchange">
                                    <option value="">Select Location</option>
                                    @foreach ($location as $locations)
                                        <option value="{{ $locations->id }}">{{ $locations->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Sub Location</label>
                                <select name="sublocation_id" class="form-control" id="sublocation">
                                    <option value="">Select Sub-Location</option>
                                </select>
                                @error('sublocation_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-item border">
                        <div class="row p-3">
                            <div class="col-md-12 mb-4">
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                                    placeholder="Issuance Description" rows="3" value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" id="allocate-assets-btn" type="button">Allocate Assets</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            var alert = $('#issue');
            setTimeout(function() {
                alert.alert('close');
            }, 3000);
        });
    </script>
    <script>
        function storeStepData(step) {
            const inputs = step.querySelectorAll("input, select, textarea");
            const data = {};

            inputs.forEach(input => {
                data[input.name] = input.value;
            });
            sessionStorage.setItem(step.id, JSON.stringify(data));
        }

        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Set the current time in #timePickerInput
        document.getElementById('timePickerInput').value = getCurrentTime();
    </script>
    <script>
        var selectedCards = {};
        $(document).ready(function() {
            $('#assetSelect').hide();
            // Listen for changes in the serialNumber input
            $("#serialNumber").on("input", function() {
                var serialNumber = $(this).val();
                if (serialNumber) {
                    $.ajax({
                        type: "POST",
                        url: "/get-asset-all-details/" +
                            serialNumber, // Make sure this URL is correct
                        data: {
                            _token: "{{ csrf_token() }}",
                            _cache: new Date().getTime(),
                            serialNumber: serialNumber,
                        },
                        success: function(response) {
                            // console.log(response);
                            renderAssetCards(response);
                        }
                    });
                } else {
                    // Clear the asset details if the input is empty
                    $('#assetdetails').empty();
                }
            });

            function renderAssetCards(asset) {
                $('#assetSelect').show();
                $('#draggableMultiple').show();
                var assetDetailsContainer = $('#assetdetails');
                assetDetailsContainer.show();

                if (asset != null) {
                    var allbrand = asset.brand;
                    var isSelected = selectedCards[asset.id];
                    var assetCard = `
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Product</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>${asset.product_number}</td>
                                <td>${asset.product_info}</td>
                                <td>${asset.asset_type.name}</td>
                                <td>${asset.assetmain.name}</td>
                                <td>${asset.price}</td>
                                <td class="add">
                                    <button class="btn btn-success btn-sm add-asset" data-card-id="${asset.id}">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
        `;
                    assetDetailsContainer.html(assetCard);
                } else {
                    var empty = `
            <div class="col-md-12">
                <h4>There is no Product of this Serial Number.</h4>
            </div>
        `;
                    assetDetailsContainer.html(empty);
                }
            }
        });
        $(document).on("click", ".add-asset", function() {
            const assetDetails = $("#assetdetails").find("td"); // Get all <td> elements
            const addassetDetails = $("#assetdetails").find(".add"); // Get all <td> elements

            if (assetDetails.length > 0) {
                const tableBody = $("#selectedAssetTable tbody");
                const assetRow = $("<tr></tr>");

                assetDetails.each(function() {
                    const clonedTd = $(this).clone();
                    addassetDetails.hide();
                    assetRow.append(clonedTd);
                });

                const removeButton = $(
                    "<td><button class='btn btn-danger btn-sm remove-asset'>Remove</button></td>");
                assetRow.append(removeButton);

                tableBody.append(assetRow);

                // Store asset.id in the hidden input field
                const assetId = $(this).data("card-id"); // Get asset.id from the "Add" button's data
                const hiddenInput = $("#selectedAssetCard input[name='selectedAssets[]']");
                const currentAssetIds = hiddenInput.val().split(',').filter(
                    Boolean); // Retrieve current asset.ids as an array
                currentAssetIds.push(assetId); // Add the new asset.id to the array
                hiddenInput.val(currentAssetIds.join(',')); // Update the hidden input field value
            }
        });

        // Add event handler for the "Remove" button in the selected assets table
        $(document).on("click", ".remove-asset", function() {
            const removedAssetId = $(this).closest("tr").find("td:first").text(); // Get the asset.id to be removed
            const hiddenInput = $("#selectedAssetCard input[name='selectedAssets[]']");
            const currentAssetIds = hiddenInput.val().split(',').filter(
                Boolean); // Retrieve current asset.ids as an array
            const indexToRemove = currentAssetIds.indexOf(removedAssetId);
            if (indexToRemove !== -1) {
                currentAssetIds.splice(indexToRemove, 1); // Remove the asset.id from the array
                hiddenInput.val(currentAssetIds.join(',')); // Update the hidden input field value
            }
            $(this).closest("tr").remove(); // Remove the row from the table
        });
    </script>
    <script>
        const form = document.querySelector(".f1");

        function showDiv() {
            var inputField = document.getElementById('employeeId');
            var div = document.getElementById('myDiv');
            var button = document.getElementById('next-employee');
            if (inputField.value.trim() !== '') {
                div.style.display = 'block';
                button.style.display = 'block';
            } else {
                div.style.display = 'none';
                button.style.display = 'none';
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
        $("#locationchange").change(function() {
            var locationId = $(this).val();
            if (locationId) {
                $.ajax({
                    url: '/get-locations/' + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sublocation').empty();
                        $('#sublocation').append('<option value="">Select sublocation</option>');
                        $.each(data, function(key, value) {
                            $('#sublocation').append('<option value="' + key +
                                '">' + value + '</option>');
                        });
                    }
                });
            }
        });
        // $('#allocate-assets-btn').click(function() {
        //     form.submit();
        // });
        $('#allocate-assets-btn').click(function(event) {
            var employeeId = $('#employeeId').val().trim();
            var serialNumber = $('#serialNumber').val().trim();
            var time = $('#timePickerInput').val().trim();
            var date = $('#datePickerInput').val().trim();
            var dueDate = $('#dueDatePickerInput').val().trim();
            var locationId = $('#locationchange').val();
            var subLocationId = $('#sublocation').val();
            var exampleFormControlTextarea1 = $('#exampleFormControlTextarea1').val()

            if (employeeId === '' || serialNumber === '' || time === '' || date === '' || dueDate === '' ||
                locationId === '' || subLocationId === '' || exampleFormControlTextarea1 === '') {
                alert('Please fill in all required fields.');
                return;
            }

            $.ajax({
                url: 'update/stock/status',
                method: 'POST',
                data: {
                    asset_id: $('#serialNumber').val(),
                    new_status: '2',
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        form.submit();
                    } else {
                        console.log('Status update failed:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        });

        form.addEventListener("submit", function(event) {
            event.preventDefault();
            storeStepData(steps[steps.length - 1]);
            form.submit();
        });
    </script>
    <script>
        $('#datePickerInput, #dueDatePickerInput').click(function(event) {
            event.stopPropagation();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#timePickerDiv').click(function() {
                // Trigger a click on the time input element to open the time picker
                $('#validationCustom01').click();
            });
        });
    </script>
@endsection
