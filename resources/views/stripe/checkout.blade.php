<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment Form</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        #payment-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-row input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #card-element {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f8f8;
        }
        #submit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        #submit-button:hover {
            background-color: #0056b3;
        }
        #card-errors {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Stripe Payment Form</h2>

    <form id="payment-form">
        <div class="form-row">
            <label for="name">Full Name</label>
            <input type="text" id="name" placeholder="Enter your name" required>
        </div>
        <div class="form-row">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter your email" required>
        </div>
        <div class="form-row">
            <label for="amount">Amount ($)</label>
            <input type="number" id="amount" placeholder="Enter amount" required>
        </div>
        <div class="form-row">
            <label for="card-element">Credit or Debit Card </label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>

        <button id="submit-button">Pay Now</button>
    </form>

    <script>
        // Initialize Stripe with your Publishable Key
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();

        // Create an instance of the card element
        const card = elements.create("card");
        card.mount("#card-element");

        // Handle real-time validation errors
        card.addEventListener("change", function(event) {
            const displayError = document.getElementById("card-errors");
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = "";
            }
        });

        // Handle form submission
        const form = document.getElementById("payment-form");
        form.addEventListener("submit", async function(event) {
            event.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: "card",
                card: card,
                billing_details: {
                    name: document.getElementById("name").value,
                    email: document.getElementById("email").value,
                },
            });

            if (error) {
                document.getElementById("card-errors").textContent = error.message;
            } else {
                alert("Payment successful! Payment Method ID: " + paymentMethod.id);

                // Send the Payment Method ID to the server for further processing
                fetch("/process-payment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        amount: document.getElementById("amount").value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert("Payment failed: " + data.error);
                    } else {
                        alert("Payment successful!");
                    }
                });
            }
        });
    </script>

</body>
</html>
