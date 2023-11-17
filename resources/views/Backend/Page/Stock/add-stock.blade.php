@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #dynamicFields {
            margin-top: 20px;
        }

        .dynamic-field {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            display: flex;
        }

        .dynamic-field label {
            font-weight: bold;
        }

        .dynamic-field input {
            width: 50%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 10px;
        }

        .dynamic-field select {
            width: 50%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .remove-field {
            cursor: pointer;
            color: #d9534f;
            font-weight: bold;
            transform: translateY(12px);
        }

        .add-field {
            cursor: pointer;
            color: #5bc0de;
            font-weight: bold;
        }

        .add-field {
            cursor: pointer;
            color: #5bc0de;
            font-weight: bold;
        }

        /* Add some custom styles to ensure the calendar is properly displayed */
        .datepicker-dropdown {
            position: absolute !important;
        }
    </style>
    <style>
        /* Custom styles for breadcrumbs */
        .breadcrumbs-dark ol.breadcrumbs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumbs-dark ol.breadcrumbs li {
            font-size: 14px;
            /* Adjust font size as needed */
            color: #555;
            /* Adjust text color as needed */
        }

        .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
            content: ">";
            margin-left: 10px;
            margin-right: 10px;
            color: #777;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
            color: blue;
        }
    </style>
@endsection
@section('breadcrumbs')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <ol class="breadcrumbs mb-2">
                        <li class="text-muted">Dashboard</li>
                        <li class="text-muted">Stock</li>
                        {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{ url('stock') }}">Add-Stock</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
    @if (session('success'))
        <div id="alert-delete" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p><b> Well done! </b>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-sm-12">
        <form class="needs-validation" enctype="multipart/form-data" method="POST"
            action="{{ isset($stockedit) ? route('update.stock', $stockedit->id) : route('store.stock') }}">
            @csrf
            <div class="card">
                <div class="card-header pb-0">
                    <h4>{{ isset($stockedit) ? 'Update Stock' : 'Add Stock' }}</h4>
                </div>
                <div class="card-body">
                    <div class="card-item border mb-3 p-2">
                        <div class="row mb-2 p-2">
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Asset Category</label>
                                <select class="form-select" id="assettype" name="asset_type"
                                    aria-label="Default select example">
                                    <option>--Select Asset Category--</option>
                                    @foreach ($asset_type as $asset_type)
                                        <option
                                            value="{{ $asset_type->id }}"{{ isset($stockedit) && $stockedit->asset_type_id == $asset_type->id ? 'selected' : '' }}>
                                            {{ $asset_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('asset_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Asset</label>
                                <select class="form-select" id="asset" name="asset"
                                    aria-label="Default select example">
                                    <option value="">--Select Asset--</option>
                                    @if (old('asset'))
                                        <option value="{{ old('asset') }}" selected>{{ old('asset') }}</option>
                                    @endif
                                </select>
                                @error('asset')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row p-3" id="showbrand">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="validationCustom01">Brand</label>
                                <select class="form-select" id="brand" name="brand"
                                    aria-label="Default select example">
                                    <option value="">--Select Brand --</option>
                                    @foreach ($brand as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ isset($stockedit) && $stockedit->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Brand Model</label>
                                <select id="brand_model" class="form-select" name="brand_model"
                                    aria-label="Default select example">
                                    <option value="">--Select Model--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0">
                    <h4>Product Details</h4>
                </div>
                <div class="card-body">
                    <div class="card-item border">
                        <div class="row p-3">
                            <div class="col-md-4">
                                <label class="form-label" for="validationCustom01">Product Info</label>
                                <input class="form-control" value="{{ isset($stockedit) ? $stockedit->product_info : '' }}"
                                    id="validationCustom01" type="text" name="product_info" data-bs-original-title=""
                                    title="" placeholder="Enter Product Info">
                                @error('product_info')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4" id="serialnumber">
                                <label class="form-label" for="validationCustom01">Serial number</label>
                                <input class="form-control" id="validationCustom01"
                                    value="{{ isset($stockedit) ? $stockedit->serial_number : '' }}" name="serial_number"
                                    type="text" data-bs-original-title="" title=""
                                    placeholder="Enter Serial Number">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="col-form-label pt-4 scan-text">Scan SrialNumber Barcode :</label>
                                <input class="form-control qr" type="file" accept="image/*" capture="environment"
                                    id="qrInput">
                                <img id="qrImage" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png') }}"
                                    alt="QR Code">
                            </div>
                            <div class="col-md-4 mb-4" id="licenseNumberField">
                                <label class="form-label" for="validationCustom01">License Number</label>
                                <input class="form-control" id="validationCustom01" type="text"
                                    name="liscence_number" data-bs-original-title=""
                                    value="{{ isset($stockedit) ? $stockedit->liscence_number : '' }}" title=""
                                    placeholder="Enter License Number">
                            </div>
                            <div class="col-md-4 mb-4" id="quantityField">
                                <label class="form-label" for="validationCustom01">Quantity</label>
                                <input class="form-control" id="validationCustom01" type="text"
                                    value="{{ isset($stockedit) ? $stockedit->quantity : '' }}" name="quantity"
                                    data-bs-original-title="" title="" placeholder="Enter Quantity">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="float: left;">Asset Code :</label>
                                <a href="#" id="generateNumber" style="float: left;">Generate Number</a>
                                <input class="form-control" type="text" id="generateNumberInput"
                                    name="generate_number"
                                    value="{{ isset($stockedit) ? $stockedit->product_number : '' }}"
                                    placeholder="Generate Number">
                                @error('generate_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                {{-- <img id="" src="{{ asset('Backend/assets/images/IT-Assets/Vector_qr.png')}}" alt="QR Code"> --}}
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="multiSelect">Select Attribute:</label>
                                <select class="form-control js-example-placeholder-multiple" name="attribute"
                                    id="attribute" multiple>
                                    <!-- dd($attribute); -->
                                    <option value="">--Select Attribute--</option>
                                </select>
                            </div>
                            <div id="dynamicFields" class="col-md-12 p-2"></div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Location</label>
                                <select class="form-select" id="location" name="location"
                                    aria-label="Default select example">
                                    <option>--Select Location--</option>
                                    @foreach ($location as $location)
                                        <option value="{{ $location->id }}"
                                            {{ isset($stockedit) && $stockedit->location_id == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Sub Location</label>
                                <select id="slocation" class="form-select" name="sublocation"
                                    aria-label="Default select example">
                                    <option value="">--Select Sub Location--</option>
                                </select>
                                @error('sublocation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Host Name</label>
                                <input class="form-control" id="validationCustom01"
                                    value="{{ isset($stockedit) ? $stockedit->host_name : '' }}" name="host_name"
                                    value="{{ old('host_name') }}" type="text" data-bs-original-title=""
                                    title="" placeholder="Enter Host Name">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="image" class="form-label">Image(Optional)</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="card-item border">
                        <div class="row p-3" id="configuration">
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="validationCustom01"> Configuration</label>
                                <textarea class="form-control" name="configuration" id="exampleFormControlTextarea1" placeholder="configuration"
                                    rows="3">{{ old('configuration') }} {{ isset($stockedit) ? $stockedit->configuration : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-12 mb-4" id="specificationField">
                                <label class="form-label" for="validationCustom01">Specification</label>
                                <textarea class="form-control" name="specification" id="exampleFormControlTextarea1" placeholder="Specification"
                                    rows="3">{{ old('specification') }}</textarea>
                                @error('specification')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-item border">
                        <div class="row p-3">
                            {{-- <div class="col-md-4">
                        <label class="form-label" for="validationCustom01">Vendor</label>
                        <input class="form-control" id="validationCustom01" name="vendor" type="text" data-bs-original-title="" value="{{ isset($stockedit) ? $stockedit->vendor : '' }}" title="" placeholder="Enter Vendor">
                    </div> --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Suppliers</label>
                                <select class="form-select" id="supplier" name="supplier"
                                    aria-label="Default select example">
                                    <option value="">--Select Supplier --</option>
                                    @foreach ($supplier as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ isset($stockedit) && $stockedit->supplier == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label" for="validationCustom01">Price</label>
                                <input class="form-control" id="validationCustom01"
                                    value="{{ isset($stockedit) ? $stockedit->price : '' }}" type="text"
                                    name="price" data-bs-original-title="" title="" placeholder="Enter Price">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4" id="warranty">
                                <label class="form-label" for="warrantyDateInput">Warranty</label>
                                <div class="input-group">
                                    <input class="form-control digits" id="dateInput"
                                        value="{{ isset($stockedit) ? $stockedit->product_warranty : '' }}"
                                        name="product_warranty" type="date" data-language="en">
                                </div>
                                @error('product_warranty')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4" id="expiryField">
                                <label class="col-form-label" for="expiryDateInput">Expiry</label>
                                <div class="input-group">
                                    <input class="form-control" id="expiryDateInput" name="expiry" type="date"
                                        data-language="en" value="{{ isset($stockedit) ? $stockedit->expiry : '' }}">
                                    <input type="hidden" value="1" name="status">
                                </div>
                            </div>
                            {{-- <div class="col-md-4 mb-4">
                        <label class="col-form-label" for="expiryDateInput">Status</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">--Select Status--</option>
                            @foreach ($status as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        </div>
                    </div>
                    <div class="footer-item">
                        <button class="btn btn-primary mt-3"
                            type="submit">{{ isset($stockedit) ? 'UPDATE' : 'ADD' }}</button>
                        <a href="{{ url('all-stock') }}" class="btn btn-warning mt-3" type="button"
                            data-bs-original-title="" title="">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            var alert = $('#alert-delete');
            setTimeout(function() {
                alert.alert('close');
            }, 3000);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#attribute').on('change', function() {
                $('#dynamicFields').empty();
                $('#attribute option:selected').each(function() {
                    var optionValue = $(this).val();
                    var optionText = $(this).text();
                    var dynamicField = `
                <div class="dynamic-field">
                    <input type="" readonly value="${optionText}">
                    <input type="text" name="attribute_value" placeholder="Enter input">
                </div>
            `;
                    $('#dynamicFields').append(dynamicField);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#generateNumber").click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "/generate/number",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#generateNumberInput").val(data.number);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // $('#addAttribute').click(function() {
            //     var dynamicField = `
        //         <div class="form-group">
        //             <input type="text" name="attribute_value" placeholder="Enter input">
        //         </div>
        //     `;
            //     $('#dynamicFields').append(dynamicField);
            // });

            $('#brand').change(function() {
                var brandId = $(this).val();
                $('#brand_model').empty();

                if (brandId) {
                    $.ajax({
                        url: '/get-brand-models/' + brandId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#brand_model').append(
                                '<option value="">--Select Model--</option>');
                            $.each(data.models, function(key, value) {
                                $('#brand_model').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#location').change(function() {
                let locationId = $(this).val();
                $('#slocation').empty();

                if (locationId) {
                    $.ajax({
                        url: '/get-slocation/' + locationId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#slocation').append(
                                '<option value="">--Select Sub-location--</option>');
                            $.each(data.locations, function(key, value) {
                                $('#slocation').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#assettype').change(function() {
                let assettypeId = $(this).val();
                $('#asset').empty();

                if (assettypeId) {
                    $.ajax({
                        url: '/get-asset-type/' + assettypeId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#asset').append('<option value="">--Select Asset--</option>');
                            $.each(data.assets, function(key, value) {
                                $('#asset').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                            $('#attribute').append(
                                '<option value="">--Select Attribute--</option>');
                            $.each(data.attribute, function(key, value) {
                                $('#attribute').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            $('#assettype').change(function() {
                var selectedAssetTypeId = $(this).val();

                $.ajax({
                    url: '/get-asset-details/' + selectedAssetTypeId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#quantityField, #specificationField, #licenseNumberField, #expiryField')
                            .hide();

                        if (data.assetType === 'IT Asset Component') {
                            $('#quantityField, #specificationField, #showbrand,#warranty')
                                .show();
                            $('#serialnumber, #configuration').hide();
                        } else if (data.assetType === 'Non IT Asset') {
                            $('#quantityField, #specificationField, #showbrand, #warranty')
                                .show();
                            $('#serialnumber, #configuration').hide();
                        } else if (data.assetType === 'Software') {
                            $('#licenseNumberField, #expiryField, #configuration, #quantityField')
                                .show();
                            $('#serialnumber,#showbrand,#warranty').hide();
                        } else {
                            $('#serialnumber, #showbrand,#configuration,#warranty').show();
                            $('#serial_number_label').text('Serial Number');
                        }
                    }
                });
            });
        });
    </script>
@endsection
