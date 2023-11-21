@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #detail:hover {
            color: black;
            text-decoration: underline;
        }
    </style>
    <style>
        /* Custom styles for breadcrumbs */
        .breadcrumbs-dark ol.breadcrumbs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumbs-dark ol.breadcrumbs li {
            font-size: 14px;
            /* Adjust font size as needed */
            color: #555;
            /* Adjust text color as needed */
        }

        .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
            content: ">";
            margin-left: 10px;
            margin-right: 10px;
            color: #777;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
            color: blue;
        }
    </style>
@endsection
@section('breadcrumbs')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <ol class="breadcrumbs mb-2">
                        <li class="text-muted">Dashboard</li>
                        <li class="text-muted">Transfer/Return</li>
                        {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{ url('return/all') }}">All Return</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h3>All Returns</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Transaction Code</th>
                                    {{-- <th>Asset Code</th> --}}
                                    <th>EMP Name</th>
                                    <th>Manager ID</th>
                                    <th>Return Reason</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $return)
                                    <tr class="text-center">
                                        @php
                                            $product = json_decode($return->product_id);
                                            $userId = $return->return_by_user;
                                            $mangerId = $return->manager_user_id;
                                        @endphp
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $return->return_transaction_code ?? 'N/A' }}</td>
                                        {{-- <td>{{ isset(App\Models\Stock::find($product[0])->product_number) ? (App\Models\Stock::find($product[0]))->product_number : 'N/A' }}</td> --}}
                                        <td>
                                            @if (is_numeric($userId))
                                                @php
                                                    $user = App\Models\User::find($userId);
                                                @endphp
                                                {{ $user ? $user->first_name : 'N/A' }}
                                                {{ $user ? $user->last_name : 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_numeric($mangerId))
                                                @php
                                                    $manager = App\Models\User::find($mangerId);
                                                @endphp
                                                {{ $manager ? $manager->employee_id : 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $return->reason ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('report.return', $return->id) }}"
                                                class="btn btn-success">View</a>
                                        </td>
                                        <td>
                                            @if (isset($products[$key]->statuses))
                                                @if ($products[$key]->statuses->name == 'Instock')
                                                    <a
                                                        class="{{ $products[$key]->statuses->status }}">Returned</a>
                                                @else
                                                    <a class="btn btn-danger">Pending</a>&nbsp;
                                                @endif
                                            @endif
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
