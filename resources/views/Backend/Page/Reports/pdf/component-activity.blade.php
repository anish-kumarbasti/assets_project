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
    <h1 id="text">Component Activity Report</h1>
    <table>
        <thead>
            <tr>
                <th>Component</th>
                <th>Asset</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($component as $components)
            <tr class="copy-content">
                <td>{{$components->product_number}}</td>
                <td>{{$components->product_info}}</td>
                <td>{{$components->quantity}}</td>
                <td>{{$components->status}}</td>
                <td>{{$components->location_id}}</td>
                <td>{{$components->created_at}}</td>
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