<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
</head>
<body>
    <h2>Stripe Payment</h2>
    <form id="payment-form">
        <input type="number" id="amount" placeholder="Enter Amount" required>
        <button type="submit">Pay with Stripe</button>
    </form>
    <div id="payment-result"></div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            
            let amount = document.getElementById('amount').value;

            const response = await fetch("{{ route('stripe.create.payment') }}", {
                method: "POST",
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}" 
                },
                body: JSON.stringify({ amount: amount })
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = data.payment_url;
            } else {
                document.getElementById('payment-result').innerText = data.message;
            }
        });
    </script>
</body>
</html>
