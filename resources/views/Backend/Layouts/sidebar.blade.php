 <div class="sidebar-wrapper">
   <div>
     <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src="{{asset('Backend/assets/images/logo/logo.png')}}" alt=""></a>
       <div class="back-btn"><i data-feather="grid"></i></div>
       <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
     </div>
     <div class="logo-icon-wrapper"><a href="index.html">
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
           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="home"></i><span class="lan-3">Dashboard</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ url('home')}}">Admin Dashboard</a></li>
               {{-- <li><a href="javascript:;">Ecommerce Dashboard</a></li> --}}
             </ul>
           </li>

           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="airplay"></i><span>Masters</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ route('auth.create-department')}}">Department</a></li>
               <li><a href="{{ url('designations')}}">Designation</a></li>
               <li><a href="{{ route('assets-type-index')}}">Asset Type</a></li>
               <li><a href="{{ url('assets')}}">Asset Name</a></li>
               <li><a href="{{ route('create-brand')}}">Brand</a></li>
               <li><a href="{{ url('brand-model')}}">Brand Model</a></li>
               <li><a href="{{ url('location-index')}}">Locations</a></li>
               <li><a href="{{ url('sublocation-index')}}">Sub-Locations</a></li>
               <li><a href="{{ url('attributes')}}">Attribute</a></li>
             </ul>
           </li>
           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="layout"></i><span>User</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{url('users')}}">All Users</a></li>
               <li><a href="{{route('users.create')}}">Add User</a></li>
               <li><a href="{{ url('show')}}">User Details</a></li>
               <li><a href="{{ url('users.user-profile')}}">User Card</a></li>
               <li><a href="{{url('add-role') }}">Add Role</a></li>
               <li><a href="{{url('view-permissions') }}">All Permission</a></li>
             </ul>
           </li>


           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="home"></i><span>Stocks</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ url('manage-stocks')}}">Manage Stocks</a></li>
               {{-- <li><a href="{{ url('all-stock')}}">All Stocks</a></li> --}}
               <li><a href="{{ url('stock')}}">Stocks</a></li>
             </ul>
           </li>
           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="airplay"></i><span>Assets</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ url('it-assets-stock')}}">IT Assets</a></li>
               <li><a href="{{route('non.it.assets')}}">Non-IT Assets</a></li>
               <li><a href="{{route('assets.components')}}">Assets Components</a></li>
               <li><a href="{{route('assets.software')}}">Software</a></li>
             </ul>
           </li>


           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Setting</span></a>
           </li>

           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Issuence</span></a>
             <ul class="sidebar-submenu">

               <li><a href="{{ url('issuences')}}"> Add Issuence </a></li>


             </ul>
           </li>
           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Transfer</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ url('transfer')}}">Add Transfer</a> </li>

             </ul>
           </li>
           <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Dispose</span></a>
             <ul class="sidebar-submenu">
               <li><a href="{{ url('disposal')}}">Add Disposal</a> </li>

             </ul>
           </li>
         </ul>
       </div>
       <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
     </nav>
   </div>
 </div>
