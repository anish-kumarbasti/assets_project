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
            <button class="btn btn-primary" id="csvButton"><i class="fas fa-file-csv"></i> Export CSV</button>
            <button class="btn btn-primary" id="pdfButton"><i class="fas fa-file-pdf"></i> Export PDF</button>
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
                            <tr class="copy-content">
                                <td><img src="" alt=""></td>
                                <td>AST222909</td>
                                <td>Aman Kumar</td>
                                <td>Ready to deploy</td>
                                <td>TP-Link</td>
                                <td>Noida</td>
                            </tr>
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

@endsection