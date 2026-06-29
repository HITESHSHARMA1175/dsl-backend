<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klarna Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        #klarna_container { margin: 20px 0; }
    </style>
</head>
<body>

<h2>Test Klarna Payment</h2>

<button id="start-klarna">Start Klarna Session</button>

<div id="klarna_container"></div>
<button id="klarna-pay-button" style="display: none;">Pay with Klarna</button>

<script>
let client_token = null;

document.getElementById("start-klarna").addEventListener("click", () => {
    fetch('/klarna/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            purchase_country: "GB",
            purchase_currency: "GBP",
            order_amount: 1000,
            order_tax_amount: 0,
            locale: "en-GB",
            order_lines: [
                {
                    name: "Running Shoes",
                    quantity: 1,
                    unit_price: 1000,
                    total_amount: 1000
                }
            ],
            merchant_urls: {
                confirmation: "https://dslclinic.com/order-success",
                cancel: "https://dslclinic.com/order-cancelled"
            }
        })
    })
    .then(res => res.json())
    .then(data => {
        client_token = data.client_token;
        console.log("Session Created:", data);

        Klarna.Payments.init({ client_token });

        Klarna.Payments.load({
            container: '#klarna_container',
            payment_method_category: 'pay_later' // or pay_now, pay_over_time
        }, function(res) {
            if (res.show_form) {
                document.getElementById("klarna-pay-button").style.display = 'inline-block';
            }
        });
    });
});

document.getElementById("klarna-pay-button").addEventListener("click", () => {
    Klarna.Payments.authorize(
        { payment_method_category: 'pay_later' },
        {},
        function (res) {
            console.log("Authorization Response:", res);
            if (res.approved && res.authorization_token) {
                fetch(`/klarna/order/${res.authorization_token}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        order_amount: 1000,
                        order_tax_amount: 0,
                        order_lines: [
                            {
                                name: "Running Shoes",
                                quantity: 1,
                                unit_price: 1000,
                                total_amount: 1000
                            }
                        ],
                        merchant_reference1: "Order_Test_001"
                    })
                })
                .then(res => res.json())
                .then(order => {
                    console.log("Order Created:", order);
                    alert("Order Created: " + order.order_id);
                    //window.location.href = "/order-success";
                });
            }
        }
    );
});
</script>

</body>
</html>
