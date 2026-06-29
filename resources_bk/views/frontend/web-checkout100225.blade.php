@extends('frontend.layout.app')

@section('content')

<script src="https://js.stripe.com/v3/"></script>
     
<section class="p-3 mt-5">
    <div class="row pt-5">
        <div class="col-12 pb-3 text-center">
            <h2>Checkout</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                
    
            </div>
        </div>
    </div>
</section>
            
            
<section class="container mt-1 mb-4">
    <div class="row">
        <div class="container my-5">
        <form action="{{ url('web-checkout-process') }}" method="POST" class="row g-3" id="payment-form">
            @csrf
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h2>Billing Details</h2>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="billing_first_name" name="billing_first_name" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="billing_last_name" name="billing_last_name" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="billing_phone" name="billing_phone" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_company" class="form-label">Company Name (Optional)</label>
                        <input type="text" class="form-control" id="billing_company" name="billing_company">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_country" class="form-label">Country/Region <span class="text-danger">*</span></label>
                        <select id="billing_country" class="form-select" name="billing_country" required>
                            <option value="">Select a country</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="billing_address_1" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="billing_address_1" name="billing_address_1" placeholder="Street Address" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="billing_city" name="billing_city" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="billing_postcode" class="form-label">Postcode <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="billing_postcode" name="billing_postcode" required>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row p-5">
                    <div class="col-12 mb-2">
                        <h3>Your Order</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $subtotalall = 0 ?>
                                @foreach ($productsystems as $item)
                                <?php
                                $subtotal = $item->getCheckedAddon->price *  $item->item;
                                $subtotalall = $subtotalall + $subtotal;
                                ?>
                                <tr>
                                    <td>{{ $item->getCheckedAddon->addon_name }} × {{ $item->item }}</td>
                                    <td>£{{ $item->getCheckedAddon->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>£{{ $subtotalall }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 mb-2">
                        <h3>Payment Method</h3>
                        <!--<div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="klarnaPayLater" value="klarna_pay_later" checked>
                            <label class="form-check-label" for="klarnaPayLater">Pay in 30 days (Klarna)</label>
                        </div>-->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="stripe" checked>
                            <div class="card-icons">
                                <img src="{{ asset('frontend/images/credit-card-image2.png') }}" alt="Visa">
                                
                            </div>
                        </div>
                        <!--<div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="orderWithoutPay" value="order_without_pay" >
                            <label class="form-check-label" for="orderWithoutPay">Order without pay</label>
                        </div>-->
                    </div>
                    <!--<div class="col-12 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I have read and agree to the <a href="{{ url('terms-conditions') }}" target="_blank">terms and conditions</a>.
                            </label>
                        </div>
                    </div>-->
                    <div class="col-12 mb-2">
                        <div class="form-check">
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-2">
                        <input type="hidden" name="order_amount" id="order_amount" value="{{ $subtotalall }}">
                        <button class="btn bg-black text-white" id="submit-button">Place Order</button>
                    </div>
                </div>
            </div>

            
        </form>
    </div>
    </div>
</section>


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
                    name: document.getElementById("billing_first_name").value,
                    email: document.getElementById("billing_email").value,
                    
                },
            });

            if (error) {
                document.getElementById("card-errors").textContent = error.message;
            } else {
                //alert("Payment successful! Payment Method ID: " + paymentMethod.id);

                // Send the Payment Method ID to the server for further processing
                fetch("/process-payment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        payment_method_id: paymentMethod.id,
                        amount: document.getElementById("order_amount").value,
                        billing_first_name: document.getElementById("billing_first_name").value,
                        billing_last_name: document.getElementById("billing_last_name").value,
                        billing_phone: document.getElementById("billing_phone").value,
                        billing_email: document.getElementById("billing_email").value,
                        billing_company: document.getElementById("billing_company").value,
                        billing_country: document.getElementById("billing_country").value,
                        billing_address_1: document.getElementById("billing_address_1").value,
                        billing_city: document.getElementById("billing_city").value,
                        billing_postcode: document.getElementById("billing_postcode").value,
                        order_amount: document.getElementById("order_amount").value,
                        payment_method: document.querySelector('input[name="payment_method"]:checked').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert("Payment failed: " + data.error);
                    } else {
                        console.log(data);
                        if(data.paymentIntent==0){
                            window.location.href = "{{ route('shop') }}"; // Redirect on success
                        }else{
                            window.location.href = "{{ route('order-success') }}"; // Redirect on success
                        }
                        //alert("Payment successful!");
                    }
                });
            }
        });
    </script>
            
<script>
    
    function addRemoveService(stype,sid,uuid) {
        
        return $.ajax({
            url: "{{ route('addRemoveService') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                sid: sid,
                stype: stype,
               
            },
            beforeSend: function(res) {
                //$('#state').html('<option value="">Loading...</option>');
            },
            success: function(res) { 
                //console.log(res);
                $('#cartCount').html(res.abc);
                window.location.href = 'cart';
                // if(res.status=='success'){
                //     $('#sid').val('');
                    
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-success" role="alert">Form submitted successfully!</div>');
                // }else{
                //     $('#subitMessage').html('<div id="alertMessage" class="alert alert-danger" role="alert">Something went wrong!</div>');  
                // }
            }
        })
    }
    
</script> 

       
       
@endsection

