@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }
</style>
@endsection

@section('Content-Area')
@if (session('success'))
<div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Depreciation</h4>
            <hr>
        </div>
        <div class="card-header pb-0 d-flex justify-content-between">
            <div class="m-b-30">
                <div class="btn-group">
                    <button class="btn btn-primary" id="copy-button"><i class="fa fa-clipboard"></i> Copy</button>
                    <button class="btn btn-secondary" id="csvButton"><i class="fa fa-file-excel-o"></i> CSV</button>
                    <a href="{{url('load-disposal-pdf')}}" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> PDF</a>
                    <a href="{{url('load-disposal')}}" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <a class="btn btn-primary text-end m-b-30" id="openModalButton" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i>
                Add Depreciation</a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h4 class="modal-title text-primary" id="exampleModalLabel"> Add Depreciation</h4>
                            <button type="button" class="close rounded" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('store-disposal') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label">Asset Type</label>
                                    <select class="form-select" id="assettype" name="assetType" aria-label="Default select example">
                                        <option value="">--Select Asset Type--</option>
                                        @foreach ($assettype as $assettypes)
                                        <option value="{{ $assettypes->id }}">{{ $assettypes->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Asset</label>
                                    <select class="form-select" id="asset" name="assetName" aria-label="Default select example">
                                        <option value="">--Select Asset--</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Choose Product</label>
                                    <select class="form-select" id="product" name="product_name" aria-label="Default select example">
                                        <option value="">--Select Product--</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Period (Month)</label>
                                    <input class="form-control" name="period_months" type="text" id="period_months" inputmode="numeric">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Desposal Code</label>
                                    <input type="text" class="form-control" name="desposal_code" id="desposal">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Asset Value</label>
                                    <input type="text" class="form-control" name="asset_value" id="assetvalue" inputmode="numeric">
                                </div>
                                <div class="mb-2">
                                    <label for="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" aria-label="Default select example">
                                        <option value="">--Select Status--</option>
                                        @foreach ($status as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
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
                                <th>SN.</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Product</th>
                                <th>Period (Month)</th>
                                <th>Asset Value</th>
                                <th>Disposal Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disposal as $disposals)
                            <tr class="copy-content">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $disposals->TypeName->name??'N/A' }}</td>
                                <td>{{ $disposals->assetName->name??'N/A' }}</td>
                                <td>{{ $disposals->product->product_info??'N/A' }}</td>
                                <td>{{ $disposals->period_months??'N/A'}}</td>
                                <td>{{ $disposals->asset_value??'N/A'}}</td>
                                <td>{{ $disposals->desposal_code??'N/A'}}</td>
                                <td> <span class=" custom-btn {{$disposals->statuses->status??'N/A'}}">{{$disposals->statuses->name??'N/A'}}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('disposal-edit', $disposals->id) }}" class=" btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                                        <button class=" btn btn-danger delete-button" data-id="{{ $disposals->id }}" type="button"><i class="fa fa-trash-o"></i> Delete</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        var alerts = $('#alerts');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
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
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
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
                    fetch('disposal-delete/' + Id, {

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