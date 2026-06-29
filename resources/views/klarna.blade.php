<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klarna Checkout</title>
    <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
</head>
<body>

    <h2>Pay with Klarna</h2>
    
    <!-- Klarna Payment Container -->
    <div id="klarna-payments-container"></div>
    
    <!-- Payment Button -->
    <button id="klarna-pay-button">Pay Now</button>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var clientToken = "{{ $clientToken }}"; // Get the client token from Laravel

            if (clientToken) {
                Klarna.Payments.init({
                    client_token: clientToken
                });

                Klarna.Payments.load(
                    {
                        container: '#klarna-payments-container'
                    },
                    {},
                    function (res) {
                        console.log("Klarna Load Response:", res);
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
                            if (res.approved) {
                                alert("Payment Approved!");
                                //window.location.href = "/order-success"; // Redirect to success page
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
