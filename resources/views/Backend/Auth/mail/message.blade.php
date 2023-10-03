<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to IT-Asset</title>
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
            <img src="{{asset('storage/'.$logo)}}" alt="{{$company_name}} Logo">
        </div>
        <div class="content">
            <h1>Welcome to {{$company_name}}</h1>
            <p>Dear {{$name}},</p>
            <p>Thank you for registering with {{$company_name}}. You are now a part of our team, and we are excited to have you on board.</p>
            <p>Your Employee ID: {{$employee_id}}</p>
            <p>Here are some important details:</p>
            <ul>
                <li>User Id: {{$email}}</li>
                <li>Password: {{$password}}</li>
                <li>Department: {{$department}}</li>
                <li>Designation: {{$designation}}</li>
                <li>Location: {{$location}}</li>
                <!-- Add more employee details as needed -->
            </ul>
            <p>If you have any questions or need assistance, please feel free to contact our IT support team at {{$company_name}}.</p>
            <p>Once again, welcome to {{$company_name}}, and we look forward to working together!</p>
            <p>Best regards,</p>
            <p>The {{$company_name}} Team</p>
        </div>
    </div>
</body>

</html>