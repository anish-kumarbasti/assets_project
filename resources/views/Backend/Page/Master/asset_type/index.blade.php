@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Asset Types</h4>
      </div>
      <div class="card-body">
         <div class="mb-3">
            <a href="{{ route('assets-type-create') }}" class="btn btn-primary">Create Asset Type</a>
         </div>
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
                  @foreach ($assets as $asset)
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $asset->id }}</td>
                     <td>{{ $asset->name }}</td>
                     <td class="w-20">
                        <label class="mb-0 switch">
                            <input type="checkbox" data-id="{{ $asset->id }}"
                                {{ $asset->status ? 'checked' : '' }}>
                            <span class="switch-state"></span>
                        </label>
                    </td>
                     <td>
                        <a href="{{ route('assets-type-edit', $asset->id) }}" class="btn btn-primary" data-bs-original-title="" title="">Edit</a>
                        <form action="{{ route('assets-type-destroy', $asset->id) }}" method="post" style="display: inline-block;">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this asset type?')" data-bs-original-title="" title="">Delete</button>
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
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

       $('input[type="checkbox"]').on('change', function() {
          const assetId = $(this).data('id');
          const status = $(this).prop('checked');
          const csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
             url: `/assets-type-status/${assetId}`,
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
@endsection

@endsection
