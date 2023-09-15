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
    <h1 id="text">Depreciation</h1>
    <table>
        <thead>
            <tr>
                <th>SN.</th>
                <th>Asset Type</th>
                <th>Asset</th>
                <th>Product</th>
                <th>Period (Month)</th>
                <th>Asset Value</th>
                <th>Disposal Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disposal as $disposals)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $disposals->TypeName->name??'N/A' }}</td>
                <td>{{ $disposals->assetName->name??'N/A' }}</td>
                <td>{{ $disposals->product->product_info??'N/A' }}</td>
                <td>{{ $disposals->period_months ??''}}</td>
                <td>{{ $disposals->asset_value??'' }}</td>
                <td>{{ $disposals->desposal_code??'' }}</td>
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