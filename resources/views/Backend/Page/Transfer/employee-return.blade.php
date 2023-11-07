@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #detail:hover {
            color: black;
            text-decoration: underline;
        }
    </style>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returndata as $return)
                                    <tr class="text-center">
                                        @php
                                        $product=json_decode($return->product_id);
                                        $userId = $return->return_by_user;
                                        $mangerId = $return->manager_user_id;
                                        @endphp
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$return->return_transaction_code??'N/A'}}</td>
                                        {{-- <td>{{ isset(App\Models\Stock::find($product[0])->product_number) ? (App\Models\Stock::find($product[0]))->product_number : 'N/A' }}</td> --}}
                                        <td>
                                            @if (is_numeric($userId))
                                            @php
                                            $user = App\Models\User::find($userId);
                                            @endphp
                                            {{ $user ? $user->first_name : 'N/A' }} {{ $user ? $user->last_name : 'N/A' }}
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
                                        <td>{{$return->reason??'N/A'}}</td>
                                        <td>
                                            <a href="{{route('report.return',$return->id)}}" class="btn btn-success">View</a>
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
