@extends('Backend.Layouts.panel')
@section('Content-Area')
@if(session('success'))
<div id="success-message" class="alert alert-success inverse alert-dismissible fade show" role="alert">
    <i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('failed'))
<div class="alert alert-danger inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('failed') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Locations</h4>
      </div>
      <div class="card-body">
         <div class="mb-3">
            <a href="{{ route('location-create') }}" class="btn btn-primary">Create Location</a>
         </div>
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>ID</th>
                     <th>Location</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($locations as $location)
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $location->id }}</td>
                     <td>{{ $location->name }}</td>
                     <td class="w-20">
                        <label class="mb-0 switch">
                            <input type="checkbox" data-id="{{ $location->id }}"
                                {{ $location->status ? 'checked' : '' }}>
                            <span class="switch-state"></span>
                        </label>
                    </td>
                     <td>
                        <a href="{{ route('location-edit', $location->id) }}" class="btn btn-primary" data-bs-original-title="" title="">Edit</a>
                           <button class="btn btn-danger delete-button" type="button"
                           data-id="{{ $location->id }}">Delete</button>
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
    $(document).ready(function() {

       $('input[type="checkbox"]').on('change', function() {
          const locationId = $(this).data('id');
          const status = $(this).prop('checked');
          const csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
             url: `/location-status/${locationId}`,
             type: 'PUT',
             data: {
                status: status
             },
             headers: {
                'X-CSRF-TOKEN': csrfToken
             },
             success: function(response) {
                console.log('Status updated successfully');
             },
             error: function(error) {
                console.error('Error:', error);
             }
          });
       });
    });
 </script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

     <script>
         document.querySelectorAll('.delete-button').forEach(function(button) {
             button.addEventListener('click', function() {
                 const locationId = this.getAttribute('data-id');
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
                         fetch('/location-destroy/' + locationId, {
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
     <script>
        $(document).ready(function() {
            // Check if the success message exists and hide it after 5 seconds (adjust the time as needed)
            if ($('#success-message').length) {
                setTimeout(function() {
                    $('#success-message').alert('close');
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>

@endsection
