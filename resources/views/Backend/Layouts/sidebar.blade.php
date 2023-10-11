@php
$businessSetting = \App\Models\BusinessSetting::where('title', 'logo_path')->first();
if ($businessSetting) {
$logoPath = $businessSetting->value;
} else {
$logoPath = 'Backend/assets/images/logo/logo.png'; // Default logo path if not found
}
@endphp
<div class="sidebar-wrapper" style="
background-color:#1d0950!important;
">
    <div>
        <div class="logo-wrapper"><a href="#"><img class="img-fluid for-light" src="{{ asset('storage/' . $logoPath) }}" style="height: auto; width: 100%;" alt=""></a></div>
        <div class="back-btn"><i data-feather="grid"></i></div>
        <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
            </i></div>
    </div>
    <div class="logo-icon-wrapper"><a href="#">
            <div class="icon-box-sidebar"><i data-feather="grid"></i></div>
        </a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-list">
                    <h6>Pinned</h6>
                </li>
                <hr>
                <li class="sidebar-list {{ request()->is('home*') ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                        <i data-feather="home"></i><span class="lan-3">Dashboard</span>
                    </a>
                    <ul class="sidebar-submenu">
                        @if (Auth::check())
                            @if (Auth::user()->role_id == 1)
                                <li class="{{ request()->is(['home*']) ? 'active' : '' }}"><a href="{{ url('home') }}">Admin Dashboard</a></li>
                            @elseif (Auth::user()->role_id == 2)
                                <li class="{{ request()->is(['user_dashboard*']) ? 'active' : '' }}"><a href="{{ url('user_dashboard') }}">User Dashboard</a></li>
                            @elseif(Auth::user()->role_id == 3)
                                <li class="{{ request()->is(['user_dashboard*']) ? 'active' : '' }}"><a href="{{url('user_dashboard')}}">User Dashboard</a></li>
                            @elseif(Auth::user()->role_id == 4)
                                <li class="{{ request()->is(['user_dashboard*']) ? 'active' : '' }}"><a href="{{url('user_dashboard')}}">User Dashboard</a></li>
                            @else
                                <li>No Dashboard</li>
                            @endif
                        @else
                            <li>No Dashboard</li>
                        @endif
                    </ul>
                </li>
                @can('view_asset')
                <li class="sidebar-list {{ request()->is(['department*', 'designations*', 'assets-type*', 'assets*', 'brand*', 'brand-model*', 'location*', 'sublocation*', 'attributes*', 'suppliers*', 'add-status*', 'transfer-reasons*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="airplay"></i><span>Masters</span></a>
                    <ul class="sidebar-submenu">
                        @can('View_Department')
                        <li class="{{ request()->is(['department*']) ? 'active' : '' }}"><a href="{{ url('department') }}">Department</a></li>
                        @endcan
                        @can('view_designation')
                        <li class="{{ request()->is(['designations*']) ? 'active' : '' }}"><a href="{{ url('designations') }}">Designation</a></li>
                        @endcan
                        {{-- <li class="{{ request()->is(['assets-type-index*']) ? 'active' : '' }}"><a href="{{ route('assets-type-index') }}">Asset Type</a></li> --}}
                        @can('view_asset')
                        <li class="{{ request()->is(['assets*']) ? 'active' : '' }}"><a href="{{ url('assets') }}">Asset</a></li>
                        @endcan
                        @can('view_brand')
                        <li class="{{ request()->is(['/brands/create*']) ? 'active' : '' }}"><a href="{{ route('create-brand') }}">Brands</a></li>
                        @endcan
                        @can('view_brand_model')
                        <li class="{{ request()->is(['brand-model*']) ? 'active' : '' }}"><a href="{{ url('brand-model') }}">Brand Models</a></li>
                        @endcan
                        @can('view_location')
                        <li class="{{ request()->is(['location-index*']) ? 'active' : '' }}"><a href="{{ url('location-index') }}">Locations</a></li>
                        @endcan
                        @can('view_sub_location')
                        <li class="{{ request()->is(['sublocation-index*']) ? 'active' : '' }}"><a href="{{ url('sublocation-index') }}">Sub-Locations</a></li>
                        @endcan
                        @can('view_attributes')
                        <li class="{{ request()->is(['attributes*']) ? 'active' : '' }}"><a href="{{ url('attributes') }}">Attributes</a></li>
                        @endcan
                        @can('view_supplier')
                        <li class="{{ request()->is(['suppliers*']) ? 'active' : '' }}"><a href="{{ url('suppliers') }}">Suppliers</a></li>
                        @endcan
                        @can('view_asset_status')
                        <li class="{{ request()->is(['add-status*']) ? 'active' : '' }}"><a href="{{ url('add-status') }}">All Status</a></li>
                        @endcan
                        @can('view_transfer_reason')
                        <li class="{{ request()->is(['transfer-reasons*']) ? 'active' : '' }}"><a href="{{ route('transfer-reasons.index') }}">Reasons</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('view_user')
                <li class="sidebar-list {{ request()->is(['users*', 'roles*', 'view-permissions*', 'add-permission*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="layout"></i><span>User Management</span></a>
                    <ul class="sidebar-submenu">
                        @can('manage_user')
                        <li class="{{ request()->is(['users*']) ? 'active' : '' }}"><a href="{{ url('users') }}">All Users</a></li>
                        @endcan
                        @can('create_user')
                        <li class="{{ request()->is(['users/create*']) ? 'active' : '' }}"><a href="{{ route('users.create') }}">Add User</a></li>
                        @endcan
                        <!-- <li><a href="{{ url('show') }}">User Details</a></li> -->
                        <!-- <li><a href="{{ url('users.user.profile') }}">User Card</a></li> -->
                        @can('view_role')
                        <li class="{{ request()->is(['roles*']) ? 'active' : '' }}"><a href="{{ url('roles') }}">Add Role</a></li>
                        @endcan
                        @can('view_permission')
                        <li class="{{ request()->is(['view-permissions*']) ? 'active' : '' }}"><a href="{{ url('view-permissions') }}">Add Permission</a></li>
                        <li class="{{ request()->is(['add-permission*']) ? 'active' : '' }}"><a href="{{ route('add.permission') }}">All Permission</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('view_stock')
                <li class="sidebar-list {{ request()->is(['manage-stocks*', 'all-stock*', 'stock*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="home"></i><span>Stocks</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['manage-stocks*']) ? 'active' : '' }}"><a href="{{ url('manage-stocks') }}">Manage Stocks</a></li>
                        @can('manage_stock')
                        <li class="{{ request()->is(['all-stock*']) ? 'active' : '' }}"><a href="{{ url('all-stock') }}">All Stocks</a></li>
                        @endcan
                        @can('create_stock')
                        <li class="{{ request()->is(['stock*']) ? 'active' : '' }}"><a href="{{ url('stock') }}">Add Stocks</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('view_asset')
                <li class="sidebar-list {{ request()->is(['it-assets-stock*', 'non-it-asset*', 'asset-components*', 'asset-software*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="airplay"></i><span>Assets</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['it-assets-stock*']) ? 'active' : '' }}"><a href="{{ url('it-assets-stock') }}">IT Assets</a></li>
                        <li class="{{ request()->is(['non-it-asset*']) ? 'active' : '' }}"><a href="{{ url('non-it-asset') }}">Non-IT Assets</a></li>
                        <li class="{{ request()->is(['asset-components*']) ? 'active' : '' }}"><a href="{{ url('asset-components') }}">Assets Components</a></li>
                        <li class="{{ request()->is(['asset-software*']) ? 'active' : '' }}"><a href="{{ url('asset-software') }}">Software</a></li>
                    </ul>
                </li>
                @endcan
                @can('view_general_setting')
                <li class="sidebar-list {{ request()->is(['application-setting*', 'send-email*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="settings" class="fa fa-spin"></i><span>Business Settings</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['application-setting*']) ? 'active' : '' }}"><a href="{{ route('settings.application') }}">General Settings</a></li>
                        <li class="{{ request()->is(['send-email*']) ? 'active' : '' }}"><a href="{{ url('/send-email') }}">Mail Configuration</a></li>
                    </ul>
                </li>
                @endcan
                @can('view_issuence')
                <li class="sidebar-list {{ request()->is(['issuences*', 'issuences/all*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Issuance</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['issuences*']) ? 'active' : '' }}"><a href="{{ url('issuences') }}"> Add Issuance </a></li>
                        <li class="{{ request()->is(['issuences/all*']) ? 'active' : '' }}"><a href="{{ url('issuences/all') }}"> All Issuance </a></li>
                    </ul>
                </li>
                @endcan
                @can('view_transfer')
                <li class="sidebar-list {{ request()->is(['transfer*', 'transfer/all*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="list"></i><span>Transfer</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['transfer*']) ? 'active' : '' }}"><a href="{{ url('transfer') }}">Add Transfer</a> </li>
                        <li class="{{ request()->is(['return*']) ? 'active' : '' }}"><a href="{{ url('return') }}">Asset Returning</a> </li>
                        <li class="{{ request()->is(['transfer/all*']) ? 'active' : '' }}"><a href="{{ url('transfer/all') }}">All Transfer</a> </li>
                    </ul>
                </li>
                @endcan
                @can('view_depreciation')
                <li class="sidebar-list {{ request()->is(['disposal*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="trash"></i><span>Depreciation</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['disposal*']) ? 'active' : '' }}"><a href="{{ url('disposal') }}">Add Depreciation</a> </li>
                    </ul>
                </li>
                @endcan
                @if (Auth::check() && Auth::user()->role_id == 1)
                <li class="sidebar-list {{ request()->is(['all-reports*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="book-open"></i><span>Reports</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{request()->is(['all-reports*']) ? 'active' : ''}}"><a href="{{ url('all-reports') }}">All Reports</a> </li>
                    </ul>
                </li>
                @endif
                @can('view_maintenance')
                <li class="sidebar-list {{ request()->is(['asset-maintenances*', 'receive-maintenance*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="plus-square"></i><span>Maintenance</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['asset-maintenances*']) ? 'active' : '' }}"><a href="{{ route('assets-maintenances') }}">Add Maintenance</a></li>
                        <li class="{{ request()->is(['receive-maintenance*']) ? 'active' : '' }}"><a href="{{ route('receive-maintenance') }}">Receive Maintenance</a></li>
                    </ul>
                </li>
                @endcan
                @if (Auth::check() && Auth::user()->role_id == 2)
                <!-- Issuence menu -->
                <li class="sidebar-list {{ request()->is(['issuence-requests*', 'all-issuence*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="plus-square"></i><span>Issuence</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{url('employee/issue')}}">Issuence Requests</a></li>
                        <li><a href="{{url('all/issue')}}">All Issuence</a></li>
                    </ul>
                </li>
                <!-- Transfer menu -->
                <li class="sidebar-list {{ request()->is(['transfer-requests*', 'all-transfer*']) ? 'active' : '' }}">
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="plus-square"></i><span>Transfer</span></a>
                    <ul class="sidebar-submenu">
                        <li class="{{ request()->is(['return*']) ? 'active' : '' }}"><a href="{{ url('return') }}">Asset Returning</a> </li>
                        <li><a href="{{url('employee/all/transfer')}}">All Transfer</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
