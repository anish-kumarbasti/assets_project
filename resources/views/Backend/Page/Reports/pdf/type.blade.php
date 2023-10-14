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
            <tr class="text-center">
                <th>SL</th>
                <th>Asset tag</th>
                <th>Product Name</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Location</th>
                <th>Picture</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $reports)
            <tr class="copy-content text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{$reports->product_number??'N/A'}}</td>
                <td>{{$reports->product_info??'N/A'}}</td>
                <td>{{$reports->asset_type->name??'N/A'}}</td>
                <td>{{$reports->brand->name??'N/A'}} </td>
                <td>{{$reports->location->name??'N/A'}}</td>
                <td><img src="{{ $reports->image_url ? $reports->image_url : '/Backend/assets/images/It-Assets/default-image.jpg' }}" alt="reports" width="50"></td>
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
