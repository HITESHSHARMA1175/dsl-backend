<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP Verification</title>
    <style>
        /* Reset styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        /* Container styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        /* Logo styles */
        .logo {
            width: 200px;
            height: 53px;
            margin-bottom: 20px;
        }
        /* Message styles */
        .message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="https://dslclinic.com">
            <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="Clinic Logo" class="logo" style="width:200px !important;">
        </a>
        <div class="message">
            <p>Hello <b>{{ $clientData['name'] }}</b>,</p>
            <p>Use the following OTP to log in to your account:</p>
            <p class="otp">{{ $clientData['otp'] }}</p>
            
            <p>If you did not request this OTP, please ignore this email.</p>
            <p>Best regards,<br> DSL Team.</p>
        </div>
    </div>
</body>
</html>
