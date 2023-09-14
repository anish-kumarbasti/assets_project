<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link</title>
</head>
<body>
    <h1>Password Reset Link</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Click the following link to reset your password:</p>
    <a href="{{route('reset.password', $token)}}">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
