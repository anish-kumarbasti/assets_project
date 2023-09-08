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
    <h1 id="text">Report Type</h1>
    <table>
        <thead>
            <tr>
                <th>Picture</th>
                <th>Asset tag</th>
                <th>Name</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $reports)
            <tr>
                <td><img src="" alt="reports"></td>
                <td>{{$reports->product_number}}</td>
                <td>{{$reports->product_info}}</td>
                <td></td>
                <td>{{$reports->brand_id}} </td>
                <td>{{$reports->location_id}}</td>
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