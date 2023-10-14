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
    <h1 id="text">Maintenance Report</h1>
    <table>
        <thead>
            <tr class="text-center">
                <th>SL</th>
                <th>Asset tag</th>
                <th>Asset</th>
                <th>Supplier</th>
                <th>Price</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Completion day(s)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintenance as $maintenances)
            <tr class="copy-content">
                <td>{{$loop->iteration}}</td>
                <td>{{$maintenances->product_id??'N/A'}}</td>
                <td>{{$maintenances->asset_number??'N/A'}}</td>
                <td>{{$maintenances->supplierName->name??'N/A'}}</td>
                <td>{{$maintenances->asset_price??'N/A'}}</td>
                <td>{{$maintenances->start_date??'N/A'}} </td>
                <td>{{$maintenances->end_date??'N/A'}}</td>
                <td>{{$maintenances->updated_at??'N/A'}}</td>
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
