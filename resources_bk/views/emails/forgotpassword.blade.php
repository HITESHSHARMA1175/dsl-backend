<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            border: 2px solid #ccc; /* Added border */
            border-radius: 10px; /* Added border radius */
        }
        /* Logo styles */
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        /* Message styles */
        .message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="https://dsl.in">
            <img src="https://dsl.in/assets/img/Logo_SH_Grey.png" alt="Logo" class="logo">
        </a>
        <div class="message">
            <p>Dear {{ $importData['userName'] }},</p>
            <p>You login Password is {{ $importData['loginPass'] }}</p>
            <p>Best regards,<br>
            Dsl.</p>
        </div>
    </div>
</body>
</html>
