@extends('Backend.Layouts.panel')

@section('Content-Area')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>
                Assets
                <a href="{{ route('assets.create') }}" class="btn btn-primary float-right">Add Asset</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr>
                            <td>{{ $asset->id }}</td>
                            <td>{{ $asset->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                <input type="checkbox" data-id="{{$asset->id}}" {{ $asset->status ? 'checked' : '' }}><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('assets.destroy', $asset->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
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
    $(document).ready(function() {

       $('input[type="checkbox"]').on('change', function() {
          const assetId = $(this).data('id');
          const status = $(this).prop('checked');
          const csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
             url: `/assets-status/${assetId}`,
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
