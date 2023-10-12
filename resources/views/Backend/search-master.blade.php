@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }
</style>
@endsection

@section('Content-Area')
<div class="container-fluid search-page">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0">
            <form class="search-form" action="{{ route('search') }}" method="GET">
                @csrf
                <input type="hidden" name="active_tab" value="employee">
              <div class="form-group m-0">
                <label class="sr-only">Email</label>
              </div>
              <div class="form-group mb-0">
                <div class="input-group">
                  <span class="input-group-text"><i class="icon-search"></i></span>
                  <input class="form-control-plaintext" type="search" name="keyword" placeholder="Search..">
                </div>
              </div>
            </form>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
           
              <li class="nav-item"><a class="nav-link active" id="employee" data-bs-toggle="tab" href="#employee" role="tab" aria-selected="true"><i class="icon-image"></i>Employee</a>
                <div class="material-border"></div>
              </li>
              <li class="nav-item"><a class="nav-link" id="asset" data-bs-toggle="tab" href="#asset" role="tab" aria-selected="false"><i class="icon-video-clapper"></i>Assets</a>
                <div class="material-border"></div>
              </li>
              {{-- <li class="nav-item"><a class="nav-link" id="issuance" data-bs-toggle="tab" href="#issuance" role="tab" aria-selected="false"><i class="icon-map-alt"></i>Issuance</a>
                <div class="material-border"></div>
              </li>
              <li class="nav-item"><a class="nav-link" id="transfer" data-bs-toggle="tab" href="#transfer" role="tab" aria-selected="false"><i class="icon-settings"></i>Transfer</a>
                <div class="material-border"></div>
              </li> --}}
            </ul>
            <div class="tab-content" id="top-tabContent">
              <div class="search-links tab-pane fade" id="all" role="tabpanel" aria-labelledby="all">
                <div class="row">
                
                </div>
              </div>
          


              <div class="tab-pane fade {{ !request('active_tab') || request('active_tab') === 'employee' ? 'show active' : '' }}" id="employee" role="tabpanel" aria-labelledby="employee">
                        @if ($users)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Employee ID</th>
                                        <th>Mobile Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->employee_id }}</td>
                                            <td>{{ $user->mobile_number }}</td>
                                            <td>
                                                <!-- Add action buttons or links here -->
                                                <!-- For example, you can add an edit or view button -->
                                                <a href="{{ route('user-timeline', $user->id) }}" class="btn btn-primary">View Timeline</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No data found.</p>
                        @endif
                    </div>

                    </div>

                    <div class="tab-pane fade {{ !request('active_tab') || request('active_tab') === 'asset' ? 'show active' : '' }}" id="asset" role="tabpanel" aria-labelledby="asset">

                <div class="row">
                   
                    @if ($stocks)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Asset Type</th>
                                <th>Asset Name</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $stock)
                           
                                <tr>
                                    <td>{{ $stock->product_info ?? ''  }}</td>
                                    <td>{{ $stock['asset_type']->name ?? ''  }}</td>
                                    <td>{{ $stock['assetmain']->name ?? ''  }}</td>
                                    <td>{{ $stock['brand']->name ?? ''  }}</td>
                                    <td>{{ $stock['statuses']->name ?? ''  }}</td>

                                    <td>
                                
                                        <a href="{{ route('stock-timeline', $stock->id) }}" class="btn btn-primary">View Timeline</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
               
                @endif
                </div>
                <div class="row">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('Script-Area')
<!-- Include the following JavaScript within a <script> tag -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.nav-link');
        const hiddenInput = document.querySelector('input[name="active_tab"]');
    
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const tabId = this.getAttribute('id');
                hiddenInput.value = tabId;
            });
        });
    });
</script>
@endsection
