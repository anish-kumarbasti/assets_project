@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
  .icon {
    background: #5c61f2;
    color: white;
    padding: 15px;
    padding-left: 20px;
    padding-top: 8px;
    font-size: 22px;
    font-weight: bold;
  }
</style>
@endsection
@section('Content-Area')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header pb-0">
          <h4>TimeLine</h4>
        </div>
        <div class="card-body">
          <!-- cd-timeline Start-->
          <section class="cd-container" id="cd-timeline">
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-picture icon">1</div>
              <div class="cd-timeline-content">
                <h4>1. In Stock</h4>
                <p class="m-0">Date & Time of Adding The Product in InStock</p>
                <p>{{$data->created_at}}</p><span class="cd-date f-w-600">Jan <span class="counter"> 14</span></span>
              </div>
            </div>
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-movie icon">2</div>
              <div class="cd-timeline-content">
                <h4>2. Allocated to User</h4>
                <div class="bg-white">
                  <p style="font-size:15px;">Sachin Singh <a style="color:rgba(107, 107, 107, 0.564);">(CEO)</a></p>
                  <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">9885354568</a></p>
                  <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">demo@gmail.com</a></p>
                </div>
                <p>Date & Time of Allocating The Product to User</p><a style="color:rgba(107, 107, 107, 0.564);">02/04/2023 at 05:30 PM</a><span class="cd-date f-w-600">Jan <span class="counter">18</span></span>
              </div>
            </div>
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-picture icon">3</div>
              <div class="cd-timeline-content">
                <h4>3. Handover to Manager</h4>
                <div class="bg-white">
                  <p style="font-size:15px;">Rakesh Singh <a style="color:rgba(107, 107, 107, 0.564);">(Manager)</a></p>
                  <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">9885354568</a></p>
                  <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">demo@gmail.com</a></p>
                </div>
                <p>Date & Time of Handover The Product to Manager</p><a style="color:rgba(107, 107, 107, 0.564);">02/04/2023 at 05:30 PM</a><span class="cd-date f-w-600">Jan <span class="counter">24</span></span>
              </div>
            </div>
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-location icon">4</div>
              <div class="cd-timeline-content">
                <h4>4. Moved to Instock</h4>
                <p>Date & Time of Handover The Product to Manager</p><a style="color:rgba(107, 107, 107, 0.564);">02/04/2023 at 05:30 PM</a>
                <span class="cd-date f-w-600">Feb <span class="counter">14</span></span>
              </div>
            </div>
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-location icon">5</div>
              <div class="cd-timeline-content">
                <h4>5. Allocated to User</h4>
                <div class="bg-white">
                  <p style="font-size:15px;">Ankit Singh <a style="color:rgba(107, 107, 107, 0.564);">(CEO)</a></p>
                  <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">9885354568</a></p>
                  <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">demo@gmail.com</a></p>
                </div>
                <p>Date & Time of Allocating The Product to User</p><a style="color:rgba(107, 107, 107, 0.564);">02/04/2023 at 05:30 PM</a>
                <span class="cd-date f-w-600">Feb <span class="counter">18</span></span>
              </div>
            </div>
          </section>
          <!-- cd-timeline Ends-->
          <!-- Container-fluid ends                    -->
          <a href="" class="btn btn-primary text-white" style="text-align:center;width:20%;transform:translate(450px,10px);border-radius:20px;">Download</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection