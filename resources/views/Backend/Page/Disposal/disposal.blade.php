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
      <h4>Depreciation</h4>
      <hr>
    </div>
    <div class="card-header pb-0 d-flex justify-content-between">
      <div>
        <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
        <button class="btn btn-primary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
        <button class="btn btn-primary" id="pdfButton"><i class="fas fa-file-pdf"></i> PDF</button>
        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
      </div>
      <a class="btn btn-primary text-end" id="openModalButton" data-toggle="modal" data-target="#exampleModal"> + Add Depreciation</a>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Add Depreciation</h5>
              <button type="button" class="close rounded" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <hr>
            <form action="{{route('store-disposal')}}" method="post">
              @csrf
              <div class="modal-body">
                <div class="mb-2">
                  <label class="form-label">Category</label>
                  <select class="form-select" id="category" name="category" aria-label="Default select example">
                    <option value="">--Select Category--</option>
                    @foreach ($assettype as $assett)
                    <option value="{{$assett->name}}">{{$assett->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-2">
                  <label class="form-label">Asset</label>
                  <select class="form-select" id="asset" name="asset" aria-label="Default select example">
                    <option value="">--Select Asset--</option>
                    @foreach ($asset as $assets)
                    <option value="{{$assets->name}}">{{$assets->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-2">
                  <label class="form-label">Period (Month)</label>
                  <input class="form-control" name="period_months" type="text" id="period_months" inputmode="numeric">
                </div>
                <div class="mb-2">
                  <label class="form-label">Asset Value</label>
                  <input type="text" class="form-control" name="asset_value" id="assetvalue" inputmode="numeric">
                </div>
                <div class="mb-2">
                  <label class="form-label">Desposal Code</label>
                  <input type="text" class="form-control" name="desposal_code" id="desposal">
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
                <th>Name</th>
                <th>Cost</th>
                <th>Period (Month)</th>
                <th>Category</th>
                <th>Asset Value</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($disposal as $disposals)
              <tr class="copy-content">
                <td></td>
                <td></td>
                <td>{{$disposals->period_months}}</td>
                <td>{{$disposals->category}}</td>
                <td>{{$disposals->asset_value}}</td>
                <td>
                  <a href="{{route('disposal-edit',$disposals->id)}}" class="btn btn-primary">Edit</a>
                  <button class="btn btn-danger delete-button" type="button" data-id="{{$disposals->id}}">Delete</button>
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
  })
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