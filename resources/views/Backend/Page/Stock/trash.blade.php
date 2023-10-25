@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>Trash Stocks</span>
                <a href="{{ route('all.stock') }}" class="btn btn-primary float-right">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr class="text-center">
                           <th>SL</th>
                           <th>Asset Code</th>
                           <th>Serial Number</th>
                           <th>Product</th>
                           <th>Asset Type</th>
                           <th>Asset</th>
                           <th>Brand</th>
                           <th>Brand Model</th>
                           <th>Configuration</th>
                           <th>Supplier</th>
                           <th>Price</th>
                           <th>Active</th>
                           <th>Status</th>
                           <th>Image</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($stock as $stock)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{$stock->product_number??'N/A'}} </td>
                           <td>{{$stock->serial_number??'N/A'}}</td>
                           <td>{{$stock->product_info??'N/A'}}</td>
                           <td>{{$stock->asset_type->name??'N/A'}}</td>
                           <td>{{$stock->assetmain->name??'N/A'}}</td>
                           <td>{{$stock->brand->name??'N/A'}}</td>
                           <td>{{$stock->brandmodel->name??'N/A'}}</td>
                           <td class="ellipsis">{{$stock->configuration??'N/A'}} </td>
                           <td>{{$stock->getsupplier->name??'N/A'}} </td>
                           <td>{{$stock->price??'N/A'}} </td>
                           <td class="w-20">
                               <label class="mb-0 switch">
                                   <input type="checkbox" data-id="{{$stock->id}}" {{ $stock->status ? 'checked' : '' }}><span class="switch-state"></span>
                               </label>
                           </td>
                           <td> <span class=" custom-btn {{$stock->statuses->status ??''}}">{{$stock->statuses->name??'N/A'}}</span></td>
                           <td>
                              <img src="{{ $stock->image ? $stock->image : '/Backend/assets/images/It-Assets/default-image.jpg'}}" alt="Stock Image" width="50">
                           </td>
                           <td>
                              <div class="button-group d-flex justify-content-between align-items-center">
                                 <a style="display: flex; align-item:center;" class="btn btn-primary" href="{{ route('restore.stocks' . $stock->id) }}"><i class="fa fa-pencil" style="margin-top: 4px;"></i>&nbsp;Restore</a>&nbsp;
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

@endsection
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('input[type="checkbox"]').on('change', function() {
            const assetId = $(this).data('id');
            const status = $(this).prop('checked');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: `assets.destroy${assetId}`,
                type: 'delete',
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
            const brandId = this.getAttribute('data-id');
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
                    fetch('/assets-permanently-delete/' + brandId, {
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
                                'An error occurred while deleted the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>

@endsection