@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }

    .custom {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
    }

    .modal-backdrop.show {
        display: none;
    }
</style>
@endsection

@section('Content-Area')

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary" id="updateModalLabel">Print Data</h4>
                <button type="button" class="close rounded" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" id="maintenanceForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Product Number</label>
                        <input class="form-control" id="product_id" type="text" data-bs-original-title="" title="" name="product_id" value="" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="validationCustom01">Product:</label>
                        <input class="form-control" id="asset_number" name="asset_number" type="text" data-bs-original-title="" title="" value="" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="validationCustom01">Asset Price:</label>
                        <input class="form-control" id="asset_price" name="asset_price" type="text" data-bs-original-title="" title="" value="" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Supplier</label>
                        <input class="form-control" id="supplier" name="supplier_id" type="text" data-bs-original-title="" title="" value="" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            @foreach ($status as $status)
                            <option value="{{$status->id}}"><span class="{{$status->status}}">{{$status->name}}</span></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control digits" name="start_date" value="" id="start" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control digits" name="end_date" id="end" value="" readonly>
                    </div>
                    <input type="hidden" id="statusId" name="statusId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printButton">print</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Receive Maintenance</h4>
            <hr>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>S.No</th>
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
                                        <a href="#" data-toggle="modal" data-target="#updateModal" class="btn btn-primary custom receive-button" data-maintenance-id="{{ $maintenance->id }}" data-product-id="{{ $maintenance->product_id }}" data-asset-number="{{ $maintenance->asset_number }}" data-asset-price="{{ $maintenance->asset_price }}" data-supplier="{{ $maintenance->supplier_id }}" data-status="{{ $maintenance->status }}" data-start-date="{{ $maintenance->start_date }}" data-end-date="{{ $maintenance->end_date }}">
                                            <i class="fa fa-print"></i> Receive
                                        </a>

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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.receive-button').on('click', function(e) {
            const maintenanceId = $(this).data('maintenance-id');
            const productId = $(this).data('product-id');
            const assetNumber = $(this).data('asset-number');
            const assetPrice = $(this).data('asset-price');
            const supplierId = $(this).data('supplier');
            const statusName = $(this).data('status');
            const startDate = $(this).data('start-date');
            const endDate = $(this).data('end-date');

            $('#product_id').val(productId);
            $('#asset_number').val(assetNumber);
            $('#asset_price').val(assetPrice);
            $('#start').val(startDate);
            $('#end').val(endDate);
            $('#status').val(statusName);
            $('#updateModal').modal('show');

            $.ajax({
                url: "/get-suppliers/" + supplierId,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log(data);
                    var supplierSelect = $('#supplier');
                    supplierSelect.empty();
                    supplierSelect.append($('<option>', {
                        value: supplierId,
                        text: data.name
                    }));

                    supplierSelect.val(supplierId);
                },
                error: function() {
                    console.error('Failed to fetch supplier data.');
                }
            });

            $.ajax({
                url: "get-statuses",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var statusSelect = $('#status');
                    statusSelect.empty();
                    statusSelect.append($('<option>', {
                        value: '',
                        text: ''
                    }));
                    $.each(data.statuses, function(key, value) {
                        statusSelect.append($('<option>', {
                            value: value.id,
                            text: value.status
                        }));
                    });

                    // Set the selected value
                    statusSelect.val(status);
                },
                error: function() {
                    console.error('Failed to fetch status data.');
                }
            });


            $('#printButton').on('click', function(e) {
                $.ajax({
                    url: `/maintainans/update/${productId}`,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        asset_number: assetNumber,
                        asset_price: assetPrice,
                        supplier_id: supplierId,
                        status: $('#status').val(),
                        start_date: startDate,
                        end_date: endDate,
                    },
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        alert('Data updated successfully!');
                        e.preventDefault();
                        const printUrl = `maintenance-print/${maintenanceId}`;

                        window.location.href = printUrl;
                    },
                    error: function() {
                        alert('Failed to update data.');
                    }
                });

            });
        });
    });
</script>

@endsection