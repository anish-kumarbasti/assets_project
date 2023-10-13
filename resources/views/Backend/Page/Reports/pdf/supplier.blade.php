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
    <h1 id="text">Report By Supplier</h1>
    <table>
        <thead>
            <tr class="text-center">
                <th>SL</th>
                <th>Asset Code</th>
                <th>Asset Type</th>
                <th>Supplier</th>
                <th>Brand</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplier as $suppliers)
            <tr class="text-center">
                <td>{{$loop->iteration}} </td>
                <td>{{$suppliers->product_number??'N/A'}}</td>
                <td>{{$suppliers->asset_type->name??'N/A'}}</td>
                <td>{{$suppliers->getsupplier->name??'N/A'}} </td>
                <td>{{$suppliers->brand->name??'N/A'}} </td>
                <td>{{$suppliers->location->name??'N/A'}} </td>
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
