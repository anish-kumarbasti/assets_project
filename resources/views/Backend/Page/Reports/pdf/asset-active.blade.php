<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #text {
            text-align: center;
            color: black;
        }
    </style>
</head>

<body>
    <h1 id="text">Asset Report</h1>

    @if(isset($data1))
    <div class="table-responsive theme-scrollbar">
        <table class="display" id="basic-1">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Asset Code</th>
                    <th>Serial Number</th>
                    <th>Asset Type</th>
                    <th>Asset</th>
                    <th>Brand</th>
                    <th>Brand Model</th>
                    <th>Attribute</th>
                    <th>Configuration</th>
                    {{-- <th>Age</th> --}}
                    <th>Price</th>
                    <th>Status</th>
                    <th>Warranty</th>
                    {{-- <th>Timeline</th> --}}
                </tr>
            </thead>
            <tbody>

                @foreach ($data1 as $asset)
                <tr class="copy-content text-center">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$asset->product_number??'N/A'}}</td>
                    <td>{{$asset->serial_number??'N/A'}}</td>
                    <td>{{$asset->asset_type->name??'N/A'}}</td>
                    {{-- <td class="ellipsis">{{$asset->specification??'N/A'}} <p>{{$asset->attributes->name??'N/A'}}</p></td> --}}
                    <td>{{$asset->assetmain->name??'N/A'}}</td>
                    <td>{{$asset->brand->name??'N/A'}}</td>
                    <td>{{$asset->brandmodel->name??'N/A'}}</td>
                    {{-- <td>{{\Carbon\Carbon::parse($asset->created_at)->format('d-m-y')??'N/A'}}</td> --}}
                    <td>{{ $asset->attributes->name??'N/A' }} {{ $asset->atribute_value??'' }}</td>
                    <td class="ellipsis">{{ $asset->configuration ?? 'N/A' }}</td>
                    {{-- <td>{{ $stock->ageInYears }} years and {{ $stock->ageInMonths }} months</td> --}}
                    <td> ₹{{ $asset->price ?? 'N/A' }}</td>
                    <td><span class=" custom-btn  {{$asset->statuses->status??''}}"> {{$asset->statuses->name??'N/A'}}</span></td>
                    <td>{{$asset->product_warranty??'N/A'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endif
@if(isset($data2))
<div class="table-responsive theme-scrollbar">
    <table class="display" id="basic-1">
        <thead>
            <tr>
               <th>SL</th>
               <th>Asset Code</th>
               <th>Asset</th>
               <th>Asset Type</th>
               <th>Brand</th>
               <th>Brand Model</th>
               <th>Specification</th>
               <th>Age</th>
               <th>Quantity</th>
               <th>In-stock</th>
               <th>Allocate</th>
               <th>Under Repair</th>
               <th>Stolen</th>
               <th>Scraped</th>
               {{-- <th>Status</th> --}}
            </tr>
         </thead>
         <tbody>
            @foreach ($data2 as $key => $nonit)
            <tr>
               <td>{{$nonit->id}}</td>
               <td>{{$nonit->product_number??''}}</td>
               <td>{{$nonit->assetmain->name??'' }}</td>
               <td>{{$nonit->asset_type->name??'' }}</td>
               <td>{{$nonit->brand->name??'' }}</td>
               <td>{{$nonit->brandmodel->name??'' }}</td>
               <td class="ellipsis">{{$nonit->specification??''}}</td>
               <td>{{ $nonit->ageInYears }} years and {{ $nonit->ageInMonths }} months</td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$nonit->quantity??''}}</span>
               </td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$availableQuantity[$key]}}</span>
               </td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$allottedCount}}</span>
               </td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$underRepairCount}}</span>
               </td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$scrappedCount}}</span>
               </td>
               <td>
                  <span class="badge rounded-pill badge-light-success">{{$scrappedCount}}</span>
               </td>
               {{-- <td><span class=" custom-btn  {{$nonit->statuses->status??''}}"> {{$nonit->statuses->name??'N/A'}}</span></td> --}}
            </tr>
            @endforeach

         </tbody>
    </table>
</div>
@endif
@if(isset($data3))
<div class="table-responsive theme-scrollbar">
    <table class="display" id="basic-1">
        <thead>
            <tr>
                <th>SL</th>
                <th>Asset Code</th>
                <th>Asset</th>
                <th>Asset Type</th>
                <th>Liscence Number</th>
                <th>Configuration</th>
                <th>Age</th>
                <th>Quantity</th>
                <th>In-stock</th>
                <th>Allocate</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($data3 as $key => $software)
                <tr>
                    <td>{{ $software->id }}</td>
                    <td>{{ $software->product_number ?? '' }}</td>
                    <td>{{ $software->assetmain->name ?? '' }}</td>
                    <td>{{$software->asset_type->name??'' }}</td>
                    <td>{{ $software->liscence_number ?? '' }}</td>
                    <td>{{ $software->configuration ?? '' }}</td>
                    <td>{{ $software->ageInYears }} years and {{ $software->ageInMonths }} months</td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $software->quantity ?? '' }}</span>
                    </td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $availableQuantity[$key] }}</span>
                    </td>
                    <td>
                        <span class="badge rounded-pill badge-light-success">{{ $allottedCount }}</span>
                    </td>
                    {{-- <td><span class=" custom-btn  {{$software->statuses->status??''}}"> {{$software->statuses->name??'N/A'}}</span></td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@if(isset($data4))
<div class="table-responsive theme-scrollbar">
    <table class="display" id="basic-1">
        <thead>
            <tr>
                <th>SL</th>
                <th>Asset Code</th>
                <th>Asset</th>
                <th>Asset Type</th>
                <th>Brand</th>
                <th>Brand Model</th>
                <th>Specification</th>
                <th>Age</th>
                <th>Quantity</th>
                <th>In-stock</th>
                <th>Allocate</th>
                <th>Under Repair</th>
                <th>Stolen</th>
                <th>Scraped</th>
                {{-- <th>Allocations</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($data4 as $key => $component)
                <tr>
                    <td>{{ $component->id }}</td>
                    <td>{{ $component->product_number ?? '' }}</td>
                    <td>{{ $component->assetmain->name ?? '' }}</td>
                    <td>{{$component->asset_type->name??'' }}</td>
                    <td>{{ $component->brand->name ?? '' }}</td>
                    <td>{{ $component->brandmodel->name ?? '' }}</td>

                    <td class="ellipsis">{{ $component->specification ?? '' }}</td>
                    <td>{{ $component->ageInYears }} years and {{ $component->ageInMonths }} months</td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $component->quantity ?? '' }}</span>
                    </td>
                    <td>
                        <span class="badge rounded-pill badge-light-success">{{$availableQuantity[$key]}}</span>
                     </td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $allottedCount[$component->product_number] ?? 0 }}</span>
                    </td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $underRepairCount[$component->product_number] ?? 0 }}</span>
                    </td>
                    <td>
                        <span class="badge rounded-pill badge-light-success">{{ $scrappedCount }}</span>
                    </td>
                    <td>
                        <span
                            class="badge rounded-pill badge-light-success">{{ $scrappedCount }}<span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<script>
    function showTable() {
        document.getElementById('basic-1').style.display = 'table';
    }
    document.querySelector('.search-form').addEventListener('submit', function() {
        showTable();
    });
</script>
    <script>
        window.onload = function() {
            window.print();
            var printw = window.open('', '_blank');
            var printwindow = setInterval(function() {
                if (printw && printw.closed) {
                    window.location.href = "{{url('asset-activity-report')}}";
                    clearInterval(printwindow);
                }
            });
        };
    </script>
</body>

</html>
