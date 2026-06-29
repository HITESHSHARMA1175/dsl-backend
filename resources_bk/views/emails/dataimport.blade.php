<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data assigned</title>
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
        
        .button {
            display: inline-block;
            padding: 4px 15px;
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
        <a href="https://dsl.in">
            <img src="https://dsl.in/assets/img/Logo_SH_Grey.png" alt="Logo" class="logo">
        </a>
        <div class="message">
            <p>Dear {{ $importData['userName'] }},</p>
            <p>You have assigned {{ $importData['assignNum'] }} data.</p>
            <a href="https://dsl.in/admin/data-crm/All" class="button">View Data</a>
            <p>Best regards,<br>
            Dsl.</p>
        </div>
    </div>
</body>
</html>
