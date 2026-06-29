<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klarna Checkout</title>
    <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .checkout-wrapper {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkout-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .order-amount {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
        }

        #klarna-payments-container {
            margin-bottom: 20px;
        }

        #klarna-pay-button {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        #klarna-pay-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="checkout-wrapper">
        <div class="checkout-header">
            <h2>Pay with Klarna</h2>
            <div class="order-amount">£{{ number_format($order_amount / 100, 2) }}</div>
        </div>

        <!-- Klarna Payment Widget -->
        <div id="klarna-payments-container"></div>
        
        <!-- Payment Button -->
        <button id="klarna-pay-button">Pay Now</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const clientToken = "{{ $client_token }}";

            if (clientToken) {
                Klarna.Payments.init({ client_token: clientToken });

                Klarna.Payments.load(
                    { container: '#klarna-payments-container' },
                    {},
                    function (res) {
                        console.log("Klarna Load Response:", res);
                        if (res.show_form === false) {
                            alert("Klarna form cannot be shown.");
                        }
                    }
                );

                document.getElementById("klarna-pay-button").addEventListener("click", function () {
                    Klarna.Payments.authorize(
                        {},
                        {
                            billing_address: {
                                given_name: "John",
                                family_name: "Doe",
                                email: "johndoe@email.com",
                                street_address: "123 Street",
                                postal_code: "10001",
                                city: "London",
                                country: "GB"
                            }
                        },
                        function (res) {
                            console.log("Authorization Response:", res);

                            if (res.approved && res.authorization_token) {
                                fetch("/klarna/create-order", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                    },
                                    body: JSON.stringify({
                                        authorization_token: res.authorization_token,
                                        order_amount: {{ $order_amount }}
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Order Response:", data);
                                    if (data.order_id) {
                                        //alert("Order Created: " + data.order_id);
                                        window.location.href = `/klarna/payment-success?order_id=${encodeURIComponent(data.order_id)}`;
                                    } else {
                                        alert("Order creation failed.");
                                    }
                                })
                                .catch(error => {
                                    console.error("Order Creation Error:", error);
                                    alert("An error occurred while creating the order.");
                                });

                            } else {
                                alert("Payment Failed!");
                            }
                        }
                    );
                });
            } else {
                alert("Failed to load Klarna payment options.");
            }
        });
    </script>

</body>
</html>
