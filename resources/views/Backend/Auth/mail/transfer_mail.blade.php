<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Transfer - {{$product_name}}</title>
    <style>
        /* Add your email styling here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .logo {
            text-align: center;
        }
        .logo img {
            max-width: 100px;
        }
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="[Company Logo URL]" alt="{{$company_name}} Logo">
        </div>
        <div class="content">
            <h1>Product Transfer - {{$product_name}}</h1>
            <p>Dear {{$handover_employee}},</p>
            <p>We are writing to inform you that the following product has been transferred to you:</p>
            <ul>
                <li>Product Name: {{$product_name}}</li>
                <li>Serial Number: {{$product_serial}}</li>
                <li>Transferred From: {{$transfer_from}}</li>
                <!-- Add more product and transfer details as needed -->
            </ul>
            <p>If you have any questions or need assistance regarding the transferred product, please contact our IT support team at {{$company_name}}.</p>
            <p>Best regards,</p>
            <p>The {{$company_name}} Team</p>
        </div>
    </div>
</body>
</html>
