@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .custom-btn {
        font-size: 11px;
        padding: 5px 10px;
        line-height: 1.5;
        pointer-events: none;
    }
    .ellipsis {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 150px;
   }
   .input-group-text, .form-control-plaintext {
    display: inline-block;
}

</style>
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Asset Report</h4>
            <hr>
        </div>
        <div class="card-header pb-0 d-flex justify-content-between">
            <div class="btn btn-group">
                <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
                <button class="btn btn-secondary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
                <a class="btn btn-success" href="{{route('getPDF',['data'=>session('data')])}}">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a class="btn btn-info" href="{{route('getPrint',['data'=>session('data')])}}"><i class="fas fa-print"></i> Print</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Description</th>
                                <th>Asset Type</th>
                                <th>Asset </th>
                                <th>Model</th>
                                <th>Purchase Date</th>
                                <th>Purchase Cost</th>
                                <th>Location</th>
                                <th>Sub-Location</th>
                                <th>Status</th>
                                <th>Warranty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $asset)
                            <tr class="copy-content text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$asset->product_number??'N/A'}}</td>
                                <td>{{$asset->serial_number??'N/A'}}</td>
                                <td class="ellipsis">{{$asset->configuration??'N/A'}} <p>{{$asset->attributes->name??'N/A'}}</p></td>
                                <td>{{$asset->asset_type->name??'N/A'}}</td>
                                <td>{{$asset->assetmain->name??'N/A'}}</td>
                                <td>{{$asset->brandmodel->name??'N/A'}}</td>
                                <td>{{\Carbon\Carbon::parse($asset->created_at)->format('d-m-y')??'N/A'}}</td>
                                <td>{{$asset->price??'N/A'}}</td>
                                <td>{{$asset->location->name??'N/A'}}</td>
                                <td>{{$asset->sublocation->name??'N/A'}}</td>
                                <td><span class=" custom-btn  {{$asset->statuses->status??''}}"> {{$asset->statuses->name??'N/A'}}</span></td>
                                <td>{{$asset->product_warranty??'N/A'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const copyButton = document.getElementById("copy-button");

        copyButton.addEventListener("click", function() {
            const copyContents = document.querySelectorAll(".copy-content");
            let copiedText = '';

            copyContents.forEach(content => {
                copiedText += content.textContent.trim() + '\n';
            });

            const textarea = document.createElement("textarea");
            textarea.value = copiedText;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);

            const originalButtonText = copyButton.textContent;
            copyButton.textContent = "Copied!";
            setTimeout(function() {
                copyButton.textContent = originalButtonText;
            }, 1500);
        });
    });
</script>


<script>
    document.getElementById('csvButton').addEventListener('click', function() {
        const table = document.getElementById('basic-1');
        const rows = table.querySelectorAll('tbody tr');
        const csvData = [];

        rows.forEach(function(row) {
            const rowData = [];
            row.querySelectorAll('td').forEach(function(cell) {
                rowData.push(cell.innerText);
            });
            csvData.push(rowData.join(','));
        });

        const csvContent = 'data:text/csv;charset=utf-8,' + csvData.join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'asset_activity_report.csv');
        document.body.appendChild(link);
        link.click();
    });
</script>
@endsection
