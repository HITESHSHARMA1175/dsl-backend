<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSL Order Confirmation</title>
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
            text-align: left;
        }
        .details {
            margin: 20px 0;
            font-size: 16px;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #218838;
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

            <p>Thank you for Order with our clinic.</p>

            <div class="details">
                <p><b>Booking Details:</b></p>
                <p>Order Id: <b>{{ $clientData['orderid'] }}</b></p>
                <p>Order Amount: <b>£{{ $clientData['amount'] }}</b></p>
                <p>Order Date: <b>{{ $clientData['date'] }}</b></p>
                <p>Order Time: <b>{{ $clientData['time'] }}</b></p>
            </div>

            <p>If you have any questions, feel free to contact us.</p>

            <p style="margin-top: 20px;">
                <a href="https://dslclinic.com/contact" class="button">Contact Us</a>
            </p>

            <p style="margin-top: 30px;">Best regards,<br>DSL Clinic Team</p>
        </div>
    </div>
</body>
</html>
