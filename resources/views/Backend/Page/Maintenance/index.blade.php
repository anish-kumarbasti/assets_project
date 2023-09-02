@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
@if (session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Maintenance</h4>
            <hr>
        </div>
        <div class="card-header pb-0 d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" id="copyButton"><i class="far fa-copy"></i> Copy</button>
                <button class="btn btn-primary" id="csvButton"><i class="fas fa-file-csv"></i> Export CSV</button>
                <button class="btn btn-primary" id="pdfButton"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
            </div>
            <a class="btn btn-primary text-end" id="openModalButton" data-toggle="modal" data-target="#exampleModal">+ Add Asset</a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content date-picker">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Maintenance</h5>
                            <button type="button" class="close ml-auto float-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <hr>
                        <form action="{{route('maintenance-save')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label">Asset Type</label>
                                    <select class="form-select" id="assettype" name="assetType" aria-label="Default select example">
                                        <option value="">--Select Asset Type--</option>
                                        @foreach ($assettype as $assettypes)
                                        <option value="{{$assettypes->id}}">{{$assettypes->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Asset</label>
                                    <select class="form-select" id="asset" name="assetName" aria-label="Default select example">
                                        <option value="">--Select Asset--</option>
                                        @foreach ($asset as $assets)
                                        <option value="{{$assets->id}}">{{$assets->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Asset Number</label>
                                    <input type="text" class="form-control" name="asset_number">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Supplier</label>
                                    <select class="form-select" id="supplier" name="supplier" aria-label="Default select example">
                                        <option value="">--Select Supplier--</option>
                                        @foreach ($supplier as $suppliers)
                                        <option value="{{$suppliers->id}}">{{$suppliers->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="text" class="datepicker-here form-control digits" name="start_date" type="date" id="start">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">End Date</label>
                                    <input type="text" class="datepicker-here form-control digits" name="end_date" id="end" type="date">
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
                                <th>S.No</th>
                                <th>Asset Type</th>
                                <th>Asset Name</th>
                                <th>Asset Number</th>
                                <th>Supplier</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maintain as $maintainans)
                            <tr class="copy-content">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$maintainans->assetType->name??''}}</td>
                                <td>{{$maintainans->assetName->name??''}}</td>
                                <td>{{$maintainans->asset_number}}</td>
                                <td>{{$maintainans->supplierName->name??''}}</td>
                                <td>{{$maintainans->start_date}}</td>
                                <td>{{$maintainans->end_date}}</td>
                                <td>
                                    <a href="{{ route('maintainans-edit', $maintainans->id) }}" class="btn btn-primary">Edit</a>
                                    <button class="btn btn-danger delete-button" type="button" data-id="{{ $maintainans->id }}">Delete</button>
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
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    });
    document.getElementById('pdfButton').addEventListener('click', function () {
        const doc = new jsPDF();
        doc.autoTable({html: '#basic-1'});
        doc.save('datatable.pdf');
    });
    document.getElementById('csvButton').addEventListener('click', function () {
        const table = document.getElementById('basic-1');
        const rows = table.querySelectorAll('tbody tr');
        const csvData = [];

        // Iterate over table rows and collect data
        rows.forEach(function (row) {
            const rowData = [];
            row.querySelectorAll('td').forEach(function (cell) {
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
    const copyButton = document.getElementById('copyButton');
    const table = document.getElementById('basic-1');

    const clipboard = new ClipboardJS(copyButton, {
        text: function () {
            const selectedRows = table.querySelectorAll('tbody tr');
            const copiedData = [];
            selectedRows.forEach(function (row) {
                const rowData = [];
                row.querySelectorAll('td').forEach(function (cell) {
                    rowData.push(cell.innerText);
                });
                copiedData.push(rowData.join('\t')); // Use tab as delimiter
            });
            return copiedData.join('\n');
        }
    });
    clipboard.on('success', function (e) {
        // Handle success (e.text is the copied text)
        e.clearSelection();
        alert('Data copied to clipboard.');
    });
    clipboard.on('error', function (e) {
        // Handle error
        console.error('Copy failed:', e.action);
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
                    data: 'assettypeId' + assettypeId + '&_token={{csrf_token()}}',
                    success: function(data) {
                        jQuery('#asset').append('<option value="">--Select Asset--</option>');
                        jQuery.each(data.assets, function(key, value) {
                            jQuery('#asset').append('<option value="' + value.id + '">' + value.name + '</option>');
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
