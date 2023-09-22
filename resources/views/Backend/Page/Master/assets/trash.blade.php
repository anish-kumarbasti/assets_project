@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>Trash Asset</span>
                <a href="{{ route('assets.index') }}" class="btn btn-primary float-right">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Asset Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $asset->AssetName->name??'' }}</td>
                            <td>{{ $asset->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{$asset->id}}" {{ $asset->status ? 'checked' : '' }}><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('assets.restore', $asset->id) }}" class="btn btn-primary">Restore</a>
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

@endsection