<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Your DSL Clinic Order is Confirmed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @media only screen and (max-width:600px){
      .container{width:100%!important}
      .px{padding-left:16px!important;padding-right:16px!important}
      .p{padding:16px!important}
      .h1{font-size:20px!important;line-height:28px!important}
      .btn{display:block!important;width:100%!important}
      .stack td{display:block!important;width:100%!important}
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#f5f8fc;font-family:Inter,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">

  <!-- Preheader (hidden) -->
  <div style="display:none;max-height:0;overflow:hidden;opacity:0;">
    Thank you {{ $clientData['name'] }} — your order {{ $clientData['order_id'] }} has been confirmed.
  </div>

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f5f8fc;">
    <tr>
      <td align="center" style="padding:24px;">
        <table role="presentation" class="container" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:600px;background:#ffffff;border-radius:14px;box-shadow:0 6px 22px rgba(20,41,77,.08);">
          
          <!-- Header / Logo -->
          <tr>
            <td align="center" style="padding:28px 16px 6px;">
              <a href="https://dslclinic.com" target="_blank" style="text-decoration:none;">
                <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" width="180" alt="DSL Clinic" style="display:block;border:0;outline:none;text-decoration:none;">
              </a>
            </td>
          </tr>

          <!-- Title row with icon -->
          <tr>
            <td class="px" style="padding:8px 40px 0;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td width="36" valign="top" style="padding-right:10px;">
                    <!-- FA-style check-circle (inline SVG for email compatibility) -->
                    <svg width="28" height="28" viewBox="0 0 512 512" aria-hidden="true" style="display:block;">
                      <path fill="#0ea5a6" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm142.2 172.2l-22.6-22.6c-6.2-6.2-16.4-6.2-22.6 0L224 288.8l-63-63c-6.2-6.2-16.4-6.2-22.6 0l-22.6 22.6c-6.2 6.2-6.2 16.4 0 22.6l96 96c6.2 6.2 16.4 6.2 22.6 0l163.8-163.8c6.3-6.2 6.3-16.4 0-22.6z"/>
                    </svg>
                  </td>
                  <td>
                    <h1 class="h1" style="margin:0;font-size:24px;line-height:32px;color:#0b2035;font-weight:700;">
                      Thank you for your order, {{ $clientData['name'] }}!
                    </h1>
                    <p style="margin:6px 0 0;font-size:15px;line-height:24px;color:#475569;">
                      We have received your order <strong>{{ $clientData['order_id'] }}</strong> placed on <strong>{{ $clientData['order_date'] }}</strong>.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Order summary -->
          <tr>
            <td class="p" style="padding:18px 40px 10px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8fbff;border:1px solid #e6eef7;border-radius:12px;">
                <tr>
                  <td style="padding:16px 18px;">
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr class="stack">
                        <td style="font-size:13px;color:#64748b;padding:4px 0;width:36%;">Payment</td>
                        <td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['payment_method'] }} — {{ $clientData['payment_status'] }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Items table -->
          <tr>
            <td style="padding:8px 40px 0;">
              <h3 style="margin:0 0 6px;font-size:16px;color:#0b2035;">Items in your order</h3>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th align="left" style="font-size:12px;color:#64748b;padding:10px 0;border-bottom:1px solid #e2e8f0;">Product</th>
                    <th align="center" style="font-size:12px;color:#64748b;padding:10px 0;border-bottom:1px solid #e2e8f0;">Qty</th>
                    <th align="right" style="font-size:12px;color:#64748b;padding:10px 0;border-bottom:1px solid #e2e8f0;">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Repeat this <tr> for each item -->
                  <?php $cartDetails = json_decode($clientData['cart_details'], true); ?>

                  @if (!empty($cartDetails) && is_array($cartDetails))
                      @foreach ($cartDetails as $detail)
                      <tr>
                        <td style="padding:10px 0;font-size:14px;color:#0b2035;">
                          <div>
                            <span style="font-weight:600;">{{ $detail['get_checked_addon']['addon_name'] }}</span>
                          </div>
                        </td>
                        <td align="center" style="padding:10px 0;font-size:14px;color:#0b2035;">{{ $detail['item'] }}</td>
                        <td align="right" style="padding:10px 0;font-size:14px;color:#0b2035;">£<?php echo $detail['get_checked_addon']['price']*$detail['item']; ?></td>
                      </tr>
                      @endforeach
                  @endif
                  <!-- End repeat -->
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Totals -->
          <tr>
            <td style="padding:6px 40px 10px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top:1px solid #e2e8f0;margin-top:6px;">
                <tr>
                  <td align="right" style="padding:8px 0;font-size:13px;color:#0b2035;font-weight:700;border-top:1px dashed #e2e8f0;">Total</td>
                  <td align="right" style="padding:8px 0;font-size:16px;color:#0b2035;font-weight:700;border-top:1px dashed #e2e8f0;">£{{ $clientData['order_total'] }}</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Addresses -->
          <tr>
            <td class="p" style="padding:6px 40px 6px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="stack">
                <tr>
                  <td valign="top" style="padding:10px 0;width:50%;">
                    <h4 style="margin:0 0 6px;font-size:14px;color:#0b2035;">Shipping Address</h4>
                    <p style="margin:0;font-size:13px;color:#475569;line-height:20px;">
                      {{ $clientData['billing_first_name'] }} {{ $clientData['billing_last_name'] }}<br>
                      {{ $clientData['billing_address_1'] }}<br>
                      {{ $clientData['billing_city'] }}, {{ $clientData['billing_postcode'] }}<br>
                      {{ $clientData['billing_country'] }}<br>
                      Phone: {{ $clientData['billing_phone'] }}
                    </p>
                  </td>
                  <td valign="top" style="padding:10px 0;width:50%;">
                    <h4 style="margin:0 0 6px;font-size:14px;color:#0b2035;">Billing Address</h4>
                    <p style="margin:0;font-size:13px;color:#475569;line-height:20px;">
                      {{ $clientData['billing_first_name'] }} {{ $clientData['billing_last_name'] }}<br>
                      {{ $clientData['billing_address_1'] }}<br>
                      {{ $clientData['billing_city'] }}, {{ $clientData['billing_postcode'] }}<br>
                      {{ $clientData['billing_country'] }}<br>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Buttons -->
          
          

          <!-- Help + small print -->
          <tr>
            <td style="padding:6px 40px 24px;">
              <p style="margin:0 0 6px;font-size:14px;color:#0b2035;">
                Questions? Email <a href="mailto:hello@dslclinic.com" style="color:#0ea5a6;text-decoration:none;">hello@dslclinic.com</a>.
              </p>
              <p style="margin:6px 0 0;font-size:12px;color:#64748b;line-height:20px;">
                You’re receiving this email because an order was placed at <a href="https://dslclinic.com/shop" style="color:#0ea5a6;text-decoration:none;">dslclinic.com/shop</a>.
              </p>
            </td>
          </tr>

        </table>

        <!-- Footer -->
        <table role="presentation" width="600" class="container" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:600px;margin-top:10px;">
          <tr>
            <td align="center" style="padding:8px 16px;">
              <p style="margin:0;font-size:12px;color:#94a3b8;">
                © 2025 DSL Clinic — Diamond Skin Aesthetic &amp; Laser Clinic
              </p>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>