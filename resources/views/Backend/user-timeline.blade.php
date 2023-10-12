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
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0">
         
          </div>
          <div class="card-body">
            <!-- cd-timeline Start-->
            <section class="cd-container" id="cd-timeline">
                @foreach ($userTimelines as $timeline)
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture bg-primary"><i class="icon-pencil-alt"></i></div>
                    <div class="cd-timeline-content">
                      <h4>{{ $timeline->action }}</h4>
                      <p class="m-0">{{ $timeline['product']['product_info'] }}</p><span class="cd-date f-w-600">{{$timeline->created_at}}</span></span>
                    </div>
                  </div>   
                @endforeach
              
         
            </section>
            <!-- cd-timeline Ends-->
            <!-- Container-fluid ends                    -->
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('Script-Area')
<!-- Include the following JavaScript within a <script> tag -->
<script>

</script>
@endsection
