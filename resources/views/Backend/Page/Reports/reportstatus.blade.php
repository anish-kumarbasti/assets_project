@extends('Backend.Layouts.panel')

@section('Style-Area')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
</style>
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Report Status</h4>
            <hr>
        </div>
        <div class="card-header pb-0">
            <button class="btn btn-primary" id="copy-button"><i class="far fa-copy"></i> Copy</button>
            <button class="btn btn-primary" id="csvButton"><i class="fas fa-file-csv"></i> CSV</button>
            <button class="btn btn-primary" id="pdfButton"><i class="fas fa-file-pdf"></i> PDF</button>
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>Picture</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Brand</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $reports)
                            <tr class="copy-content">
                                <td><img src="" alt="status"></td>
                                <td>{{$reports->product_number}}</td>
                                <td>{{$reports->host_name}}</td>
                                <td>{{$reports->status}}</td>
                                <td>{{$reports->brand_id}}</td>
                                <td>{{$reports->location_id}}</td>
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

        // Iterate over table rows and collect data
        rows.forEach(function(row) {
            const rowData = [];
            row.querySelectorAll('td').forEach(function(cell) {
                rowData.push(cell.innerText);
            });
            csvData.push(rowData.join(','));
        });

        // Create a CSV blob and trigger download
        const csvContent = 'data:text/csv;charset=utf-8,' + csvData.join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'report_status.csv');
        document.body.appendChild(link);
        link.click();
    });
</script>



@endsection