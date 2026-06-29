<!DOCTYPE html>
<html>
<head>
    <title>Stripe Google Pay / Apple Pay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        #payment-request-button {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h2>Express Checkout</h2>
    <p>Pay quickly using Google Pay or Apple Pay</p>

    <div id="payment-request-button"></div>

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");

        fetch('/create-payment-intent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const elements = stripe.elements();

            const paymentRequest = stripe.paymentRequest({
                country: 'US',
                currency: 'usd',
                total: {
                    label: 'My Laravel Store',
                    amount: 1000, // $10.00
                },
                requestPayerName: true,
                requestPayerEmail: true,
            });

            const prButton = elements.create('paymentRequestButton', {
                paymentRequest: paymentRequest,
                style: {
                    paymentRequestButton: {
                        type: 'default', // You can also use 'googlePay'
                        theme: 'dark',
                        height: '44px',
                    }
                }
            });

            paymentRequest.canMakePayment().then(function(result) {
                if (result) {
                    prButton.mount('#payment-request-button');

                    if (result.applePay) {
                        console.log("✅ Apple Pay is available");
                    }

                    if (result.googlePay) {
                        console.log("✅ Google Pay is available");
                    }
                } else {
                    document.getElementById('payment-request-button').style.display = 'none';
                    console.log("❌ No available payment methods");
                }
            });

            paymentRequest.on('paymentmethod', async (ev) => {
                const {error} = await stripe.confirmCardPayment(
                    data.clientSecret,
                    {
                        payment_method: ev.paymentMethod.id
                    },
                    {
                        handleActions: false
                    }
                );

                if (error) {
                    ev.complete('fail');
                    alert(error.message);
                } else {
                    ev.complete('success');
                    const result = await stripe.confirmCardPayment(data.clientSecret);
                    if (result.error) {
                        alert(result.error.message);
                    } else {
                        alert("🎉 Payment successful!");
                    }
                }
            });
        });
    </script>
</body>
</html>
