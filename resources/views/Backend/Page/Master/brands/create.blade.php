@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
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
</script>
@endsection
