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
            <tr>
                <th>Asset tag</th>
                <th>Asset</th>
                <th>Supplier</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Completion day(s)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintenance as $maintenances)
            <tr>
                <td>{{$maintenances->product_number}}</td>
                <td>{{$maintenances->product_info}}</td>
                <td>{{$maintenances->supplier}}</td>
                <td></td>
                <td>{{$maintenances->created_at}} </td>
                <td>{{$maintenances->expiry_date}}</td>
                <td></td>
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