@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .add-more-field {
            display: inline-block;
            margin-right: -10px;
            padding-top: 20px;
        }

        .add-category-button {
            background-color: transparent; 
            border: 1px solid #37236B; 
            color: #37236B; 
            padding: 10px 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s; 
            border-radius: 10px;
        }

        .add-category-button:hover {
            background-color: #37236B; 
            color: #fff;
        }

        .button-text {
            font-weight: bold;
        }

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

        .added-row {
            background-color: #e6ffe8;
        }

        .added-button {
            background-color: #a1daa1;
            pointer-events: none;
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
        <form action="{{ route('issuence.store') }}" method="POST">
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
                                    placeholder="Enter Employee's ID" onkeydown="return event.key != 'Enter';">
                            </div>
                            @error('employeeId')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="col-md-2 mb-4">
                                <label class="col-form-label pt-5 scan-text">Scan Barcode :</label>
                            </div>
                            <div class="col-sm-2 pt-4">
                                <input class="form-control qr" type="file" accept="image/*" capture="environment"
                                    id="qrInput">
                                <img id="qrImage"
                                    src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png') }}"
                                    alt="QR Code">
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
                    <div class="card-item card" style="transform: translateY(-2.5rem);">
                        <div class="row p-3">
                            <div class="col-md-5 mb-4">
                                <label class="form-label" for="serialNumber">Asset code:</label>
                                <input class="form-control" id="serialNumber" value="{{ old('serialNumber') }}"
                                    name="serialNumber" type="text" data-bs-original-title="" title=""
                                    placeholder="Enter Asset Number">
                                @error('serialNumber')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-4">
                                <label class="col-form-label pt-5 scan-text">Scan Barcode :</label>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="pt-4">
                                    <input class="form-control qr" type="file" accept="image/*"capture="environment" id="qrInput">
                                    <img id="qrImage"src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png') }}"
                                        alt="QR Code">
                                </div>
                            </div>
                            <div class="col-md-3 pt-4 add-more-field">
                                <button id="showAssetCategory" type="button" class="add-category-button"
                                    data-toggle="tooltip" data-placement="top" title="Add Asset Category">
                                    <span class="button-text">Choose Asset Category</span>
                                </button>
                            </div>
                        </div>
                        <div class="row p-4" id="additionalFields" style="display: none;">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="assetType">Choose Asset Type:</label>
                                <select name="assetType" class="form-control" id="assetType">
                                    <option value="">Select Asset Type</option>
                                    @foreach ($assettype as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="assetCategory">Choose Asset:</label>
                                <select name="assetCategory" class="form-control" id="assetCategory">
                                    <option value="" data-asset-id="">Select Asset</option>
                                </select>
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
                {{-- <input type="hidden" name="selectedAssets[]" value=""> --}}
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
                                    id="timePickerInput" type="time" data-bs-original-title="" title="">
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Date of Issuing</label>
                                <input class="form-control" name="date" id="dateInput" type="date"
                                    value="{{ old('date') }}" data-bs-original-title="" title="">
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label">Due Date</label>
                                <input class="form-control" name="due_date" id="dateInputs"
                                    value="{{ old('due_date') }}" type="date" data-bs-original-title=""
                                    title="">
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
                        <div class="card-item">
                            <div class="row p-3">
                                <div class="col-md-12 mb-4">
                                    <textarea class="form-control" name="description" placeholder="Issuance Description" rows="3"
                                        value="{{ old('description') }}"></textarea>
                                        @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Allocate Assets</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script>
        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0'); 
        let yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('dateInput').value = today;
        document.getElementById('dateInputs').value = today;
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Bootstrap tooltip
            $('[data-toggle="tooltip"]').tooltip();

            $('#showAssetCategory').click(function() {
                $('#additionalFields').toggle();
            });
        });
        $(document).ready(function() {
            var alert = $('#issue');
            setTimeout(function() {
                alert.alert('close');
            }, 3000);
        });

        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }
        document.getElementById('timePickerInput').value = getCurrentTime();
        $(document).ready(function() {
            $('#assetType').change(function() {
                var assetTypeId = $(this).val();
                if (assetTypeId) {
                    $.ajax({
                        type: "POST",
                        url: 'get-assets-by-type/' + assetTypeId,
                        data: {
                            assetTypeId: assetTypeId,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            // Handle the response and update the asset category select element
                            var assetCategorySelect = $('#assetCategory');
                            assetCategorySelect.empty();
                            assetCategorySelect.append(
                                '<option value="" data-asset-id="">Select Asset</option>');

                            $.each(response, function(key, asset) {
                                assetCategorySelect.append('<option value="' + asset
                                    .id + '" data-asset-id="' + asset
                                    .id + '">' + asset.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            $('#assetCategory').change(function() {
                var assetId = $(this).find('option:selected').data('asset-id');
                if (assetId) {
                    $.ajax({
                        type: "POST",
                        url: '/get-asset-details-on-stock/' + assetId,
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            updateAssetDetails(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    });
                }
            });

            function updateAssetDetails(asset) {
                $('#assetSelect').show();
                $('#draggableMultiple').show();
                var assetDetailsContainer = $('#assetdetails');
                assetDetailsContainer.show();
                assetDetailsContainer.empty();

                if (asset) {
                    // Assuming asset is an array of assets
                    if (Array.isArray(asset) && asset.length > 0) {
                        var assetTable = `
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
                        <tbody>`;

                        asset.forEach(function(singleAsset) {
                            assetTable += `
                <tr>
                    <td>${singleAsset.product_number??'N/A'}</td>
                    <td>${singleAsset.product_info}</td>
                    <td>${singleAsset.asset_type.name}</td>
                    <td>${singleAsset.assetmain.name}</td>
                    <td>${singleAsset.price}</td>
                    <td class="add">
                        <button class="btn btn-success btn-sm add-assets" type="button" data-card-id="${singleAsset.id}">
                            Add
                        </button>
                    </td>
                </tr>`;
                        });

                        assetTable += `</tbody>
        </table>`;
                        assetDetailsContainer.html(assetTable);
                    } else {
                        // Handle the case when no assets are found
                        assetDetailsContainer.html('<p>No assets found for this asset type.</p>');
                    }
                } else {
                    // Handle the case when no asset is found (response is not an array)
                    assetDetailsContainer.html('<p>No asset found for this serial number.</p>');
                }

            }
        });
        $(document).on("click", ".add-assets", function() {
            const addButton = $(this);
            if (!addButton.hasClass("added-button")) {
                addButton.hide(); // Hide the "Add" button
                const addedButton = $(
                    "<input class='btn btn-success btn-sm added-button' type='hidden' data-card-id='" +
                    addButton.data(
                        "card-id") + "'></input>"
                );
                const assetDetails = addButton.closest("tr").find("td"); // Get all <td> elements in the clicked row
                const tableBody = $("#selectedAssetTable tbody");
                const assetRow = $("<tr class='added-row'></tr>"); // Add the "added-row" class
                assetDetails.each(function() {
                    const clonedTd = $(this).clone();
                    assetRow.append(clonedTd);
                });
                const removeButton = $(
                    "<td><button class='btn btn-danger btn-sm remove-asset' type='button'>Remove</button></td>");
                assetRow.append(removeButton);
                assetRow.append("<td></td>"); // Placeholder for the "Added" button
                tableBody.append(assetRow);

                addedButton.click(function() {
                    removeAddedAsset(addedButton);
                });
                assetRow.find("td:last").append(addedButton);

                const assetId = addButton.data("card-id"); // Get asset.id from the "Add" button's data
                // const hiddenInput = $("#selectedAssetCard input[name='selectedAssets[]']");
                // const currentAssetIds = hiddenInput.val().split(',').filter(
                //     Boolean); // Retrieve current asset.ids as an array
                // currentAssetIds.push(assetId); // Add the new asset.id to the array
                // hiddenInput.val(currentAssetIds.join(',')); // Update the hidden input field value
                $('#selectedAssetCard').append('<input type="hidden" name="selectedAssets[]" value="'+assetId+'">');
            }
        });

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

        function removeAddedAsset(addedButton) {
            const assetId = addedButton.data("card-id");
            const addButton = $(".add-assets[data-card-id='" + assetId + "']");
            addButton.show(); // Show the "Add" button
            addedButton.closest("tr").remove(); // Remove the row from the table

            const hiddenInput = $("#selectedAssetCard input[name='selectedAssets[]']");
            const currentAssetIds = hiddenInput.val().split(',').filter(
                Boolean); // Retrieve current asset.ids as an array
            const indexToRemove = currentAssetIds.indexOf(assetId);
            if (indexToRemove !== -1) {
                currentAssetIds.splice(indexToRemove, 1); // Remove the asset.id from the array
                hiddenInput.val(currentAssetIds.join(',')); // Update the hidden input field value
            }
        }
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
                                    <button class="btn btn-success btn-sm add-asset" type="button" data-card-id="${asset.id}">
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
                    "<td><button class='btn btn-danger btn-sm remove-asset' type='button'>Remove</button></td>");
                assetRow.append(removeButton);
                tableBody.append(assetRow);
                const assetId = $(this).data("card-id"); // Get asset.id from the "Add" button's data
                const hiddenInput = $("#selectedAssetCard input[name='selectedAssets[]']");
                const currentAssetIds = hiddenInput.val().split(',').filter(
                    Boolean); // Retrieve current asset.ids as an array
                currentAssetIds.push(assetId); // Add the new asset.id to the array
                hiddenInput.val(currentAssetIds.join(',')); // Update the hidden input field value
            }
        });
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
    </script>
@endsection
