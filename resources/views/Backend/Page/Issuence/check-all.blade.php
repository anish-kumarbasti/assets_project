@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        /* Add this CSS to your existing styles */
        td#clickfr {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            /* Change cursor to pointer on hover */
        }

        td#clickfr p {
            transition: color 0.3s;
            /* Add a color transition for the text */
        }

        td#clickfr::before,
        td#clickfr::after {
            content: "";
            position: absolute;
            background: grey;
            height: 1px;
            width: 0;
            left: 0;
            transition: all 0.3s;
        }

        td#clickfr::before {
            top: 0;
        }

        td#clickfr::after {
            bottom: 0;
        }

        td#clickfr:hover::before,
        td#clickfr:hover::after {
            width: 100%;
            /* Expand the borders on hover */
        }

        td#clickfr:hover p a {
            color: #1d0950;
            /* Change text color on hover */
        }
    </style>
@endsection
@section('Content-Area')
    @if (session('success'))
        <div id="btn" class="alert alert-success" role="alert"><i class="icon-thumb-up alert-center"></i>
            <p>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger outline" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-xl-12">
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            {{-- <p class="square-after f-w-600 header-text-primary">Asset Requests<i class="fa fa-circle"> </i> --}}
                            </p>
                            <h4>Asset Notifications</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- Define table headers -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (auth()->user()->notifications as $notification)
                                    <tr>
                                        <td id="clickfr">
                                            @if (Auth::check() && Auth::user()->role_id == 4)
                                                <p class="click"><b>{{ Auth::user()->first_name }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-controller', $notification->id) }}">New
                                                        Product Isuue to the User Click for more Detail!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @elseif (Auth::check() && Auth::user()->role_id == 3)
                                                @if ($notification->type == 'App\Notifications\TransferNotification')
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                            href="{{ route('markasread-transfer-manager', $notification->id) }}">Manager
                                                            New Notification of Transfer Click for more Detail!</a><span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                @elseif ($notification->type == 'App\Notifications\ReturnNotification')
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;
                                                        <a
                                                            href="{{ route('markasread-manager-return', $notification->id) }}">Manager
                                                            New Notification for Return Click for more Detail!</a>
                                                        <span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                @else
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                            href="{{ route('markasread-manager', $notification->id) }}">Manager
                                                            New Notification Click for more Detail!</a><span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                @endif
                                            @elseif(Auth::check() && Auth::user()->role_id == 1)
                                                @if ($notification->type == 'App\Notifications\IssuenceNotification')
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                            href="{{ route('markasread-admin', $notification->id) }}">New
                                                            Asset Accepted by Employee Click for more Detail!</a><span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                @endif
                                            @else
                                                @if ($notification->type == 'App\Notifications\TransferNotification')
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                            href="{{ route('markasread-transfer', $notification->id) }}">Employee
                                                            New Transfer
                                                            Notification Click for more Detail!</a><span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                @else
                                                    <p class="click">
                                                        <b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                            href="{{ route('markasread', $notification->id) }}">Employee
                                                            New
                                                            Notification Click for more Detail!</a><span
                                                            class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                    </p>
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
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('rejection') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Enter Rejection Reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="productIdToReject" name="productIdToReject" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reason">Reason for Rejection</label>
                            <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="submitRejection">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('Script-Area')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function setProductIdToReject(productId) {
            document.getElementById('productIdToReject').value = productId;
        }
        $(document).on('click', '#clickfr', function() {
            var anchor = $(this).find('a');
            if (anchor.length) {
                anchor[0].click();
            }
        });
    </script>
@endsection
