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
    <h1 id="text">Report By Location</h1>
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Asset Code</th>
                <th>Asset Type</th>
                <th>Asset</th>
                <th>Price</th>
                <th>Location</th>
                <th>Sub Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($location as $locations)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$locations->product_number??'N/A'}}</td>
                <td>{{$locations->asset_type->name??'N/A'}}</td>
                <td>{{$locations->assetmain->name??'N/A'}}</td>
                <td>{{$locations->price??'N/A'}}</td>
                <td>{{$locations->location->name??'N/A'}}</td>
                <td>{{$locations->sublocation->name??'N/A'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
