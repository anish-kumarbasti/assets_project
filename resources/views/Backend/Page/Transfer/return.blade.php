@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .change-card.selected {
        border: 2px solid #1774f7 !important;
        background-color: #d1f6fe !important;
    }

    .change-card:hover {
        transform: scale(.9);
    }
    .ellipsis {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 150px;
   }
</style>
@endsection
@section('Content-Area')
@if (session('success'))
<div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div id="alerts" class="alert alert-danger inverse alert-dismissible fade show" role="alert">
    <p>{{ session('error') }}</b>
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
<div class="col-sm-12">
    <form class="needs-validation" method="post" action="{{ route('submit') }}" novalidate="">
        @csrf
        <div class="card" id="step1">
            <div class="card-header pb-0">
                <h4>Product Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5>No Asset for Returning</h5>
                    </div>
                    {{-- {{dd($data)}} --}}
                    @isset($data)
                    @foreach ($data as $asset)
                    <div class="col-md-12">
                        <table class="table table-bordered" id="selectedAssetTable">
                            <thead>
                                <tr>
                                    <th>Asset Code</th>
                                    <th>Product</th>
                                    <th>Asset Type</th>
                                    <th>Brand</th>
                                    <th>License Number</th>
                                    <th>Brand Model</th>
                                    <th>Configuration</th>
                                    <th>Supplier</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$asset->product_number??'N/A'}}</td>
                                    <td>{{ $asset->product_info??'N/A'}}</td>
                                    <td>{{ $asset->asset_type->name??'N/A'}}</td>
                                    <td>{{ $asset->brand->name??'N/A'}}</td>
                                    <td>{{ $asset->license_number ?? 'N/A' }}</td>
                                    <td>{{ $asset->brandmodel->name ?? 'N/A' }}</td>
                                    <td class="ellipsis">{{ $asset->configuration ?? 'N/A' }}</td>
                                    <td>{{ $asset->getsupplier->name??'N/A' }}</td>
                                    <td>{{ $asset->price }}</td>
                                    <td class="add">
                                    <button onclick="selectDeselect(this)" class="btn btn-success" type="button" data-card-id="{{ $asset->id}}">
                                        Add
                                    </button>
                                    @if (isset($selectedCardIds) && in_array($asset->id, $selectedCardIds))
                                    <input type="hidden" value="{{ $asset->id }}" name="cardId[{{ $asset->id }}]">
                                    @endif
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @endisset
                </div>
            </div>
        </div>
        <div class="card mt-3" id="step2">
            <div class="card-body">
                <div class="card-head">
                    <h4>Asset Return</h4>
                </div>
                <div class="card-item border mt-3">
                    <div class="row p-3">
                        <div class="col-md-12 p-3">
                            <label for="text">Reason for Return</label>
                            <textarea name="description" id="text" placeholder="reason.." class="form-control" cols="20" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {{-- <button class="btn btn-secondary" id="previous" type="button">Previous</button> --}}
                <button class="btn btn-primary" type="submit">Rturn</button>
            </div>
        </div>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
</script>


<script>
    $(document).ready(function() {
        var alerts = $('#alerts');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
<script>
function selectDeselect(card) {
    var $card = $(card);
    if ($card.hasClass('selected')) {
        $card.removeClass('selected').text('Add');
        removeCardId(card);
    } else {
        $card.addClass('selected').text('Selected');
        addCardId(card);
    }
}

// function addCardId(card) {
//     var cardId = $(card).data('card-id');
//     var input = $('<input>')
//         .attr('type', 'hidden')
//         .attr('name', 'cardId[' + cardId + ']')
//         .val(cardId);
//     $('#selectedAssetTable form').append(input);
// }

// function removeCardId(card) {
//     var cardId = $(card).data('card-id');
//     $('#selectedAssetTable form input[name="cardId[' + cardId + ']"]').remove();
// }


function checkSelection(card) {
    if ($(card).hasClass('selected')) {
        $(card).append('<input type="hidden" value="' + $(card).data('card-id') + '" name="cardId[' + $(card).data('card-id') + ']">');
    } else {
        $(card).find('input[name^="cardId"]').remove();
    }

    if ($('.change-card.selected').length > 0) {
        $('#next').show();
    } else {
        $('#next').hide();
    }
}

$('#next').click(function() {
    if ($('.change-card.selected').length > 0) {
        $('#step1').hide();
        $('#step2').show();
    }
});

$('#previous').click(function() {
        $('#step1').show();
        $('#step2').hide();
    });



    // function selectDeselect(card) {
    //     card.classList.toggle('selected');

    //     // Check if at least one card is selected, then show the Next button
    //     if ($('.change-card.selected').length > 0) {
    //         $('#next').show();
    //     } else {
    //         $('#next').hide();
    //     }
    // }
</script>
@endsection
