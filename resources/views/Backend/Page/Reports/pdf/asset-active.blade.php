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
    <h1 id="text">Asset Activity Report</h1>
    <table>
        <thead>
            <tr>
                <th>Asset</th>
                <th>Employees</th>
                <th>Status</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $asset)
            <tr class="copy-content">
                <td>{{$asset->assetmain->name??''}}</td>
                <td>{{$asset->host_name}}</td>
                <td><span class=" custom-btn  {{$asset->statuses->status??''}}"> {{$asset->statuses->name??''}}</span></td>
                <td>{{$asset->location??''}}</td>
                <td>{{$asset->created_at}}</td>
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