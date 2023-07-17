<!DOCTYPE html>
<html lang="en">
  @include('Backend.Layouts.head')
  @yield('Style-Area')
  <body>  
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
 @include('Backend.Layouts.loader')
   <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
       @include('Backend.Layouts.header')
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
        <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
          @include('Backend.Layouts.sidebar')
        <div class="page-body">
         @include('Backend.Layouts.breadcrumbs')
        @yield('Content-Area')
          <!-- Container-fluid starts-->
          



          <!-- Container-fluid Ends-->
        </div>
       @include('Backend.Layouts.footer')
       </div>
       </div>
      @yield('Script-Area')
    @include('Backend.Layouts.footer-script')
  </body>
</html>