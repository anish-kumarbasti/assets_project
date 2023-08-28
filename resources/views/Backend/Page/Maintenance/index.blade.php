@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Maintenance list</h4>
            <hr>
        </div>
        <div class="card-header pb-0 d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
                <button class="btn btn-primary" id="csvButton"><i class="fas fa-file-csv"></i> Export CSV</button>
                <button class="btn btn-primary" id="pdfButton"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
            </div>
            <a class="btn btn-primary text-end" id="openModalButton" data-toggle="modal" data-target="#exampleModal">+ Add Asset</a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Maintenance list</h5>
                            <button type="button" class="close ml-auto float-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <hr>
                        <form action="{{route('maintenance-save')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label">Asset</label>
                                    <select class="form-select" id="asset" name="asset" aria-label="Default select example">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Supplier</label>
                                    <select class="form-select" id="supplier" name="supplier" aria-label="Default select example">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Type</label>
                                    <select class="form-select" id="type" name="type" aria-label="Default select example">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" type="date" id="start">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end" type="date">
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
                                <th>Asset</th>
                                <th>Employees</th>
                                <th>Status</th>
                                <th>Location</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="copy-content">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
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
    })
</script>
@endsection