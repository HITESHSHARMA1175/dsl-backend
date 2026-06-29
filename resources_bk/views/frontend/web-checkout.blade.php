@extends('frontend.layout.app')

@section('content')

<?php 
if(session('app_locale')=='cn'){
    $Checkout = 'چیک آؤٹ';
    $Billing_Details = 'بلنگ کی تفصیلات';
    $Your_Order = 'آپ کا آرڈر';
}elseif(session('app_locale')=='ar'){
    $Checkout = 'الدفع';
    $Billing_Details = 'تفاصيل الفاتورة';
    $Your_Order = 'طلبك';
}else{
    $Checkout = 'Checkout';
    $Billing_Details = 'Billing Details';
    $Your_Order = 'Your Order';
    
}
?> 


<script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
<script src="https://js.stripe.com/v3/"></script>
<style>
    #submit-button-klarna {
        width:100%;
        margin-top: 30px;
    }
</style>
<div class="breadcrumb-cell" aria-label="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb mb-0">
                    <a href="{{ url('/') }}"> Home </a> &gt; {{ $Checkout }}
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="web-checkout">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-5"><b>{{ $Checkout }}</b></h2>
            </div>
        </div>
       
        <form action="{{ url('web-checkout-process') }}" method="POST" class="row g-3 payment-form-all" id="payment-form">
        @csrf
        <div class="col-lg-6">
            <h2 class="mb-3"><b>{{ $Billing_Details }}</b></h2>
            
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="billing_first_name"><b>First Name</b></label>
                        <input type="text" class="form-control" id="billing_first_name" name="billing_first_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="billing_last_name"><b>Last Name</b></label>
                        <input type="text" class="form-control" id="billing_last_name" name="billing_last_name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="billing_phone"><b>Phone</b></label>
                        <input type="tel" class="form-control" maxlength="10" id="billing_phone" name="billing_phone" required>
                    </div>
                    <div class="col-md-6">
                        <label for="billing_email"><b>Email</b></label>
                        <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="billing_company"><b>Company Name (Optional)</b></label>
                        <input type="text" class="form-control" id="billing_company" name="billing_company">
                    </div>
                    <div class="col-md-6">
                        <label for="billing_country"><b>Country/Region </b></label>
                        <select id="billing_country" class="form-select" name="billing_country" required>
                            <option value="">Select a country</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="specificSizeInputName"><b>Address</b></label>
                        <input type="text" class="form-control" id="billing_address_1" name="billing_address_1" required>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="billing_city"><b>City</b></label>
                        <input type="text" class="form-control" maxlength="10"  id="billing_city" name="billing_city" required>
                    </div>
                    <div class="col-md-6">
                        <label for="billing_postcode"><b>Postcode </b></label>
                        <input type="text" class="form-control" id="billing_postcode" name="billing_postcode" required>
                    </div>
                </div>
                

            
        </div>
        <div class="col-lg-6">
            <h4><b>{{ $Your_Order }}</b></h4>
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
<h4><b>Payment Method</b></h4>

<div>
    <div class="form-check mb-4 d-flex align-items-center gap-2">
        <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="stripe" checked onchange="paymentMethodCheck('Stripe')">
        <div class="card-icons">
            <img src="{{ asset('frontend/images/credit-card-image3.png') }}" alt="Visa">
        </div>
    </div>
</div>

<div>
    <div class="form-check mb-2 d-flex align-items-center gap-2">
        <input class="form-check-input" type="radio" name="payment_method" id="payment_method2" value="Klarna" onchange="paymentMethodCheck('Klarna')">
        <div class="card-icons">
            <img src="{{ asset('frontend/images/klarnalogo.png') }}" alt="Klarna" style="width:55px">
        </div>
    </div>

    <div id="klarna_container" style="display:none;"></div>
    <button type="button" id="klarna-pay-button" style="display:none;">Pay with Klarna</button>
</div>

<!-- TERMS & CONDITIONS -->
<div class="col-12 mb-3 mt-3">
    <div class="form-check d-flex align-items-start gap-2">
        <input 
            class="form-check-input mt-1" 
            type="checkbox" 
            id="agree_terms"
            onchange="togglePlaceOrderButton()"
        >
        <label class="form-check-label" for="agree_terms" style="font-size:14px;">
            I agree to the 
            <a href="https://dslclinic.com/terms-conditions" 
               target="_blank" 
               class="text-primary text-decoration-underline">
                Terms & Conditions
            </a>
        </label>
    </div>
</div>

<!-- PLACE ORDER BUTTONS -->
<div class="col-12 mb-2">
    <input type="hidden" name="order_amount" id="order_amount" value="{{ $subtotalall }}">

    <button 
        type="submit" 
        class="btn bg-primary text-white" 
        id="submit-button"
        disabled
    >
        Place Order
    </button>

    <button 
        type="button" 
        class="btn bg-primary text-white" 
        id="submit-button-klarna" 
        style="display:none;"
        disabled
    >
        Place Order
    </button>
</div>

<!-- JS -->
<script>
function togglePlaceOrderButton() {
    const isChecked = document.getElementById('agree_terms').checked;

    document.getElementById('submit-button').disabled = !isChecked;
    document.getElementById('submit-button-klarna').disabled = !isChecked;
}
</script>
        

    </div>
</section>


<script>
let client_token = null;

document.getElementById("submit-button-klarna").addEventListener("click", () => {
    
    var billingData = {
        amount2: parseInt($('#order_amount').val(), 10) * 100,
        billing_first_name: $('#billing_first_name').val(),
        billing_last_name: $('#billing_last_name').val(),
        billing_phone: $('#billing_phone').val(),
        billing_email: $('#billing_email').val(),
        billing_company: $('#billing_company').val(),
        billing_country: $('#billing_country').val(),
        billing_address_1: $('#billing_address_1').val(),
        billing_city: $('#billing_city').val(),
        billing_postcode: $('#billing_postcode').val()
    };
    
    if (billingData.billing_first_name.trim() === '') {
        $('#billing_first_name').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_first_name').css('border', '');
    }
    
    if (billingData.billing_phone.trim() === '') {
        $('#billing_phone').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_phone').css('border', '');
    }
    
    if (billingData.billing_email.trim() === '') {
        $('#billing_email').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_email').css('border', '');
    }
    
    if (billingData.billing_country.trim() === '') {
        $('#billing_country').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_country').css('border', '');
    }
    
    if (billingData.billing_address_1.trim() === '') {
        $('#billing_address_1').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_address_1').css('border', '');
    }
    
    if (billingData.billing_city.trim() === '') {
        $('#billing_city').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_city').css('border', '');
    }
    
    if (billingData.billing_postcode.trim() === '') {
        $('#billing_postcode').focus().css('border', '1px solid red');
        return false;
    } else {
        $('#billing_postcode').css('border', '');
    }
    

    
    fetch('/klarna/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            purchase_country: "GB",
            purchase_currency: "GBP",
            order_amount: billingData.amount2,
            order_tax_amount: 0,
            locale: "en-GB",
            order_lines: [
                {
                    name: "Dsl Product",
                    quantity: 1,
                    unit_price: billingData.amount2,
                    total_amount: billingData.amount2
                }
            ],
            billing_address: {
                given_name: billingData.billing_first_name.trim(),
                family_name: billingData.billing_last_name.trim(),
                email: billingData.billing_email.trim(),
                phone: billingData.billing_phone.trim(),
                street_address: billingData.billing_address_1.trim(),
                postal_code: billingData.billing_postcode.trim(),
                city: billingData.billing_city.trim(),
                country: billingData.billing_country.trim()
            },
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
                //document.getElementById("klarna-pay-button").style.display = 'inline-block';
                document.getElementById("klarna_container").style.display = 'none';
                const payButton = document.getElementById("klarna-pay-button");
                payButton.click();
            }
        });
    });
});

document.getElementById("klarna-pay-button").addEventListener("click", () => {
    
    var billingData = {
        amount2: parseInt($('#order_amount').val(), 10) * 100,
        billing_first_name: $('#billing_first_name').val(),
        billing_last_name: $('#billing_last_name').val(),
        billing_phone: $('#billing_phone').val(),
        billing_email: $('#billing_email').val(),
        billing_company: $('#billing_company').val(),
        billing_country: $('#billing_country').val(),
        billing_address_1: $('#billing_address_1').val(),
        billing_city: $('#billing_city').val(),
        billing_postcode: $('#billing_postcode').val()
    };
    
    
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
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        purchase_country: "GB",
                        purchase_currency: "GBP",
                        order_amount: billingData.amount2,
                        order_tax_amount: 0,
                        locale: "en-GB",
                        order_lines: [
                            {
                                name: "Dsl Product",
                                quantity: 1,
                                unit_price: billingData.amount2,
                                total_amount: billingData.amount2
                            }
                        ],
                        billing_address: {
                            given_name: billingData.billing_first_name.trim(),
                            family_name: billingData.billing_last_name.trim(),
                            email: billingData.billing_email.trim(),
                            phone: billingData.billing_phone.trim(),
                            street_address: billingData.billing_address_1.trim(),
                            postal_code: billingData.billing_postcode.trim(),
                            city: billingData.billing_city.trim(),
                            country: billingData.billing_country.trim()
                        },
                        merchant_reference1: "Order_Test_001"
                    })
                })
                .then(res => res.json())
                .then(order => {
                    console.log("Order Created:", order);
                    //alert("Order Created: " + order.order_id);
                    window.location.href = "/klarna/order-success/" + order.order_id;
                });
            }
        }
    );
});
</script>



<script>

    function paymentMethodCheck(MethodValue){
        if(MethodValue === 'Klarna'){
            $('#submit-button-klarna').show();
            $('#submit-button').hide();
        } else {
            $('#submit-button-klarna').hide();
            $('#submit-button').show();
        }
    }

    
   
</script>

<script>
    document.getElementById('payment-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        
        var billingData = {
            amount: parseInt($('#order_amount').val(), 10), // Make sure it's named "amount" to match backend
            billing_first_name: $('#billing_first_name').val(),
            billing_last_name: $('#billing_last_name').val(),
            billing_phone: $('#billing_phone').val(),
            billing_email: $('#billing_email').val(),
            billing_company: $('#billing_company').val(),
            billing_country: $('#billing_country').val(),
            billing_address_1: $('#billing_address_1').val(),
            billing_city: $('#billing_city').val(),
            billing_postcode: $('#billing_postcode').val()
        };

        const response = await fetch("{{ route('stripe.create.paymentshop') }}", {
            method: "POST",
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': "{{ csrf_token() }}" 
            },
            body: JSON.stringify(billingData)
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.payment_url;
        } else {
            document.getElementById('payment-result').innerText = data.message;
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

