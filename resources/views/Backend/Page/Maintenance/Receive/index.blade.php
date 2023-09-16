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
            <form method="post">
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
                        <input class="form-control" id="price" name="asset_price" type="text" data-bs-original-title="" title="" value="" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Supplier</label>
                        <select class="form-select" id="supplier" name="supplier" aria-label="Default select example">
                            <option value="">--Select Supplier--</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">--Select Status--</option>

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="" type="submit" class="btn btn-primary">Print</a>
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
                                        <a href="{{ url('maintenance/edit', $maintenance->id) }}" data-toggle="modal" data-target="#updateModal" class="btn btn-primary custom"><i class="fa fa-print "></i> Receive </a>&nbsp;
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
        const urlParams = new URLSearchParams(window.location.search);
        const isModalRequested = urlParams.get('modal');

        if (isModalRequested) {
            const maintenanceId = urlParams.get('id');

            $.ajax({
                url: `/maintenance/edit/${maintenanceId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#start').text(data.start_date);
                    $('#end').text(data.end_date);
                    $('#updateModal').modal('show');
                },
                error: function() {
                    console.error('Failed to fetch data.');
                }
            });
        }
    });
</script>

@endsection