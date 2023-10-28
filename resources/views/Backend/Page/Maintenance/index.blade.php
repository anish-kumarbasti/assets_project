@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }

    .btn-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
    }

    .swal2-popup {
        text-align: center;
    }
</style>
@endsection

@section('Content-Area')
@if (session('success'))
<div id="btn" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
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
    <div class="card">
        <div class="card-header pb-0">
            <h4>Maintenance</h4>
            <hr>
        </div>
        <div class="card-header pb-0 d-flex justify-content-between">
            <div class="m-b-30">
                <div class="btn-group">
                    <button class="btn btn-primary" id="copy-button"><i class="fa fa-clipboard"></i> Copy</button>
                    <button class="btn btn-secondary" id="csvButton"><i class="fa fa-file-excel-o"></i> CSV</button>
                    <a href="{{url('maintenance-repo')}}" class="btn btn-success" id="pdfButton"><i class="fa fa-file-pdf-o"></i> PDF</a>
                    <a href="{{route('maintenance-reports')}}" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <a class="btn btn-primary text-end m-b-30" id="openModalButton" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                Add Mainatinence</a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content date-picker">
                        <div class="modal-header border-bottom">
                            <h4 class="modal-title text-primary" id="exampleModalLabel">Add Maintenance</h4>
                            <button type="button" class="close ml-auto rounded float-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('maintenance-save') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label">Product Number</label>
                                    <input class="form-control" oninput="showDiv()" id="product_number" type="search" data-bs-original-title="" title="" name="product_id" placeholder="Enter Asset Number" onkeydown="return event.key != 'Enter';" required>
                                    @error('product_number')
                                    <span class="btn btn-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div id="myDiv" style="display: none;">
                                    <div class="mb-2">
                                        <label class="form-label" for="validationCustom01">Product:</label>
                                        <input class="form-control" id="product_info" name="asset_number" type="text" data-bs-original-title="" title="" placeholder="" readonly>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="validationCustom01">Asset Price:</label>
                                        <input class="form-control" id="price" name="asset_price" type="text" data-bs-original-title="" title="" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Supplier</label>
                                    <select class="form-select" id="supplier" name="supplier_id" aria-label="Default select example">
                                        <option value="">--Select Supplier--</option>
                                        @foreach ($supplier as $suppliers)
                                        <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" aria-label="Default select example">
                                        <option value="">--Select Status--</option>
                                        @foreach ($status as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control digits" name="start_date" type="date" id="dateInput">
                                    @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control digits" name="end_date" id="dateInputs" type="date">
                                    @error('end_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Asset Name</th>
                                <th>Product Number</th>
                                <th>Supplier</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maintain as $maintenance)
                            <tr class="copy-content">
                                <td>{{ $maintenance->id }}</td>
                                <td>{{ $maintenance->asset_number ?? 'N/A' }}</td>
                                <td>{{ $maintenance->product_id ?? 'N/A' }}</td>
                                <td>{{ $maintenance->suppliers->name ?? 'N/A' }}</td>
                                <td>{{ $maintenance->asset_price ?? 'N/A' }}</td>
                                <td><span class=" custom-btn {{$maintenance->statuss->status ?? 'N/A'}}">{{$maintenance->statuss->name ?? 'N/A'}}</span></td>
                                <td>{{ $maintenance->start_date }}</td>
                                <td>{{ $maintenance->end_date }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('maintenance-edit', $maintenance->id) }}" class="btn btn-primary">Edit</a>&nbsp;
                                        <button class="btn btn-danger delete-button" data-id="{{ $maintenance->id }}" type="button">Delete</button>&nbsp;
                                        <a href="{{ route('maintenance-print', $maintenance->id) }}" class="btn btn-primary" target="_blank">Print </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        var alerts = $('#btn');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
<script>
    const form = document.querySelector(".f1");

    function showDiv() {
        var inputField = document.getElementById('product_number');
        var div = document.getElementById('myDiv');

        if (inputField.value.trim() !== '') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    }
    $(document).ready(function() {
        $("#product_number").on("input", function() {
            var product_number = $(this).val();
            $.ajax({
                url: "/maintenance",
                method: "GET",
                data: {
                    product_number: product_number
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#product_info").val(data.product_info);
                    $('#price').val(data.price);
                }
            });
        });
    });
</script>
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    });
    document.getElementById('pdfButton').addEventListener('click', function() {
        const doc = new jsPDF();
        doc.autoTable({
            html: '#basic-1'
        });
        doc.save('datatable.pdf');
    });
    document.getElementById('csvButton').addEventListener('click', function() {
        const table = document.getElementById('basic-1');
        const rows = table.querySelectorAll('tbody tr');
        const csvData = [];

        // Iterate over table rows and collect data
        rows.forEach(function(row) {
            const rowData = [];
            row.querySelectorAll('td').forEach(function(cell) {
                rowData.push(cell.innerText);
            });
            csvData.push(rowData.join(','));
        });

        // Create a CSV blob and trigger download
        const csvContent = 'data:text/csv;charset=utf-8,' + csvData.join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'datatable.csv');
        document.body.appendChild(link);
        link.click();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const copyButton = document.getElementById("copy-button");

        copyButton.addEventListener("click", function() {
            const copyContents = document.querySelectorAll(".copy-content");
            let copiedText = '';

            copyContents.forEach(content => {
                copiedText += content.textContent.trim() + '\n';
            });

            const textarea = document.createElement("textarea");
            textarea.value = copiedText;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);

            const originalButtonText = copyButton.textContent;
            copyButton.textContent = "Copied!";
            setTimeout(function() {
                copyButton.textContent = originalButtonText;
            }, 1500);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
    jQuery(document).ready(function() {
        jQuery('#assettype').change(function() {
            let assettypeId = jQuery(this).val();
            jQuery('#asset').empty();

            if (assettypeId) {
                jQuery.ajax({
                    url: '/get-asset-type/' + assettypeId,
                    type: 'POST',
                    data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                    success: function(data) {
                        jQuery('#asset').append(
                            '<option value="">--Select Asset--</option>');
                        jQuery.each(data.assets, function(key, value) {
                            jQuery('#asset').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
    jQuery(document).ready(function() {
        jQuery('#asset').change(function() {
            let assettypeId = jQuery(this).val();
            jQuery('#product').empty();

            if (assettypeId) {
                jQuery.ajax({
                    url: '/get-product-type/' + assettypeId,
                    type: 'POST',
                    data: 'assettypeId' + assettypeId + '&_token={{ csrf_token() }}',
                    success: function(data) {
                        jQuery('#product').append(
                            '<option value="">--Select Product--</option>');
                        jQuery.each(data.product, function(key, value) {
                            console.log(value);
                            jQuery('#product').append('<option value="' + value.id +
                                '">' + value.product_info + '</option>');
                        });
                    }
                });
            }
        });
    });
    document.querySelectorAll('.delete-button').forEach(function(button) {

        button.addEventListener('click', function() {
            const Id = this.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('maintainans-delete/' + Id, {

                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())


                        .then(data => {

                            if ('success' in data && data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Failed to delete the file.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'An error occurred while deleting the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
@endsection
