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
    <h1 id="text">Asset Register Report</h1>
    <table>
        <thead>
            <tr class="text-center">
                <th>SL</th>
                <th>Asset Code</th>
                <th>Serial Number</th>
                <th>Configuration</th>
                <th>Type</th>
                <th>Model</th>
                <th>Purchase Date</th>
                <th>Purchase Cost</th>
                <th>Allocation Date</th>
                <th>Location</th>
                <th>Sub-Location</th>
                <th>Status</th>
                <th>Warranty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $asset)
            <tr class="copy-content text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{$asset->product_number??'N/A'}}</td>
                <td>{{$asset->serial_number??'N/A'}}</td>
                <td class="ellipsis">{{$asset->configuration??'N/A'}} {{$asset->attributes->name??'N/A'}}</td>
                <td>{{$asset->asset_type->name??'N/A'}}</td>
                <td>{{$asset->brandmodel->name??'N/A'}}</td>
                <td>{{\Carbon\Carbon::parse($asset->created_at)->format('d-m-y')??'N/A'}}</td>
                <td>{{$asset->price??'N/A'}}</td>
                <td>{{ ($asset->assettypeid && $asset->assettypeid->created_at) ? \Carbon\Carbon::parse($asset->assettypeid->created_at)->format('Y-m-d') : 'N/A' }}</td>
                <td>{{$asset->location->name??'N/A'}}</td>
                <td>{{$asset->sublocation->name??'N/A'}}</td>
                <td><span class=" custom-btn  {{$asset->statuses->status??''}}"> {{$asset->statuses->name??'N/A'}}</span></td>
                <td>{{$asset->product_warranty??'N/A'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

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
