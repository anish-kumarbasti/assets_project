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
    <h1 id="text">Maintenance</h1>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Asset Type</th>
                <th>Asset Name</th>
                <th>Product Number</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintain as $maintain)
            <tr>
                <td>{{$maintain->id }}</td>
                <td>{{$maintain->type ?? 'N/A' }}</td>
                <td>{{$maintain->asset ?? 'N/A' }}</td>
                <td>{{$maintain->product_id ?? 'N/A' }}</td>
                <td>{{$maintain->asset_price ?? 'N/A' }}</td>
                <td>{{$maintain->statuss->name ?? 'N/A'}}</td>
                <td>{{$maintain->start_date}}</td>
                <td>{{$maintain->end_date}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <script>
        document.getElementById('cancel').addEventListener('click', function() {
            window.history.back();
        });
    </script>
</body>

</html>