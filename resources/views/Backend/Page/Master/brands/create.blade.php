@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ session::get('success') }}
</div>
    @endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Add Brand</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate method="POST" action="{{ url('/brands') }}">
                @csrf
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Add Brand</label>
                            <input class="form-control" id="validationCustom01" type="text" name="name" required=""
                                data-bs-original-title="" title="" placeholder="Enter Brand Name">
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                               @enderror
                        </div>
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Add</button>
                    <button class="btn btn-warning mt-3" type="button" data-bs-original-title="" title="">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>List Brands</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td class="w-20">
                                    <label class="mb-0 switch">
                                        <input type="checkbox" data-id="{{ $brand->id }}"
                                            {{ $brand->status ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ url('/brands/' . $brand->id . '/edit') }}">Edit</a>
                                    <form class="d-inline" method="POST"
                                        action="{{ url('/brands/' . $brand->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-button" type="button" data-id="{{ $brand->id }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add an event listener to the checkboxes for updating the brand status
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const brandId = this.getAttribute('data-id');
            const status = this.checked;

            // Send an AJAX request to update the status
            fetch(`/brands/${brandId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status }) // Send the correct status value
            }).then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Optionally, you can handle the response here
                console.log('Status updated successfully');
            }).catch(function(error) {
                // Handle errors if any
                console.error('Error:', error);
            });
        });
    });
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    @if (session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
    @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
          button.addEventListener('click', function() {
              const assetId = this.getAttribute('data-id');
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              // Show SweetAlert2 confirmation dialog
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
                      // Send AJAX request to the server to delete the item
                      fetch('/brand/${brandId}' + brandId,{
                              method: 'delete',
                              headers: {
                                  'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                                  'Content-Type': 'application/json' // Set the content type
                              }
                          // You can set headers and other options here
                          })
                          .then(response => response.json())
                          
                          .then(data => {
                              
                              if ('success' in data && data.success) {
                                  Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                  ).then(() => {
                                      location.reload(); // Reload the page after the alert is closed
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
