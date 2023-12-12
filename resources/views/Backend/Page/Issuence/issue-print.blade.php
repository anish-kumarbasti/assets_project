<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .card-item {
            height: 142px;
            width: 153px;
        }

        .icofontt {
            float: right;
        }

        .first-heading {
            color: #5C61F2;
            font-size: 30px;
            font-weight: 700;


            border-bottom: 1px solid #5555551A;
        }

        .heading-item {
            color: black;
        }

        .widget-joins .d-flex .flex-grow-1 {
            text-align: left !important;
        }

        .has-search .form-control {
            padding-left: 2.375rem;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

        .left-header .input-group {
            padding: 12px 15px !important;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f6f8fc;

        }

        .rounded-circle {
            position: relative;
            left: -43px;
        }

        .ican-item-1 {
            background: #4FAAD51A;
            height: 32px;
            width: 40px;
            padding: 8px;
            color: #4FAAD5 !important;
            border-radius: 6px;
            font-weight: 700;
            font-size: 19px;
        }

        .home-item {
            border-bottom: 3px solid #55555533;
        }

        .home-card-item {
            border-right: 3px solid #55555533;
        }

        .home-item-1 {
            border-top: 3px solid #55555533;

        }

        .number-item {
            color: #4FAAD5 !important;
            font-size: 20px;
        }

        input[readonly] {
            background-color: white !important;
        }

        textarea[readonly] {
            background-color: white !important;
        }

        .action-button {
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: #f0f0f0 !important;
            color: #333;
        }
        td.narrow-width {
            width: 500px; /* Adjust the width as needed */
        }
        pre {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-xl-12">
            <h4 class="text-center"><b>ASSET ACKNOWLEDGEMENT REPORT </b></h4>
            <div class="card-body">
                    <div class="row p-3">
                        <div class="col-sm-6">
                            <div class="p-1">
                                <b>Transaction Code: </b>  {{$issue->transaction_code??'N/A'}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-1">
                                <b>Date And Time:</b>  {{$issue->created_at??'N/A'}}
                    </div>
                </div>
            <div class="card-body">
                    <h4>EMPLOYEE DETAILS:</h4>
                    <div class="row p-3">
                        <b>Employee:</b>
                        <div class="col-sm-6">
                            Name:  {{$user->first_name??'N/A'}} {{$user->last_name??'N/A'}} <br>
                            Department:  {{$user->department->name??'N/A'}} <br>
                            Mobile Number:  {{$user->mobile_number??'N/A'}} <br>
                            Based Location:  {{$user->slocation->name??'N/A'}} <br><br>

                            Iqama / ID Number:  ____________________________________ <br><br>

                            <b>Manager :</b> <br>
                            Name:  {{$mng->first_name??'N/A'}} {{$mng->last_name??'N/A'}} <br>
                            Employee ID:  {{$mng->employee_id??'N/A'}} <br>
                        </div>
                        <div class="col-sm-6">
                            Employee ID:  {{$user->employee_id??'N/A'}} <br>
                            Designation:  {{$user->designation->name??'N/A'}} <br>
                            Email ID:  {{$user->email??'N/A'}} <br><br><br>

                            TNT GLID:/FedEx ID:  ___________________________________ <br><br>

                            <b>Asset Controller :</b> <br>
                            Name:  {{$assetc->first_name??'N/A'}} {{$assetc->last_name??'N/A'}} <br>
                            Employee ID:  {{$assetc->employee_id??'N/A'}} <br>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <h4>TRANSFER INFORMATION :</h4><br>
                <div class="table-responsive theme-scrollbar">
                    <table class="table table-bordered">
                        <thead>
                            <th>Asset Code</th>
                            <th>Serial Number</th>
                            <th>Asset Type</th>
                            <th>Asset</th>
                            <th>Product Info</th>
                            <th>Warranty</th>
                            <th>Supplier</th>
                        </thead>
                        <tbody>
                            @foreach ($stock as $stock)
                                <tr>
                                    <td>{{$stock->product_number??''}}</td>
                                    <td>{{$stock->serial_number??'N/A'}}</td>
                                    <td>{{$stock->asset_type->name??''}}</td>
                                    <td>{{$stock->assetmain->name??'N/A'}}</td>
                                    <td class="narrow-width">{{$stock->configuration??''}}</td>
                                    <td>{{$stock->product_warranty??'N/A'}}</td>
                                    <td>{{$stock->getsupplier->name??'N/A'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body p-4">
                    <p>On the date of _____________ , I____________ I received' Asset owned and issued by SAB Express LLC. <br><br>
                    In doing so, I, do in fact understand that I am solely responsible for these devices untile it is returned to the SUB Express IT Department. While under my care, I acknowledge that any physical or accidental damage is my fault and I will be held accountable for it. <br><br>
                    While using these Assets & laptop device, I will not commit any acts of cyber terrorism/crime, illeggal activity share any company information with unauthorized user, search for or watch or store explicit content, install any software without IT consent, or lead laptop to friends or family members. I will strictly use these Asset & laptop for work/business purpose. <br><br>
                    By signing this document,'am accepting and agreeing and agreeing to the terms of use for these Asset & laptop.
                    </p><br><br><br>
                   <pre><b>Employee Signature:</b>____________________________                  <b>Date:</b>__________________________  </pre> 
                </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
    