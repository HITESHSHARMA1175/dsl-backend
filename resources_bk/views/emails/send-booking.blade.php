<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Your Service Booking is Confirmed</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	@media only screen and (max-width:600px) {
		.container {
			width: 100%!important
		}
		.px {
			padding-left: 16px!important;
			padding-right: 16px!important
		}
		.p {
			padding: 16px!important
		}
		.h1 {
			font-size: 20px!important;
			line-height: 28px!important
		}
		.btn {
			display: block!important;
			width: 100%!important
		}
	}
	</style>
</head>

<body style="margin:0;padding:0;background:#f5f8fc;font-family:Inter,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
	<!-- Preheader (hidden) -->
	<div style="display:none;max-height:0;overflow:hidden;opacity:0;"> Your booking is confirmed. </div>
	<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f5f8fc;">
		<tr>
			<td align="center" style="padding:24px;">
				<table role="presentation" class="container" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:600px;background:#ffffff;border-radius:14px;box-shadow:0 6px 22px rgba(20,41,77,.08);">
					<!-- Header / Logo -->
					<tr>
						<td align="center" style="padding:28px 16px 6px;">
							<a href="https://dslclinic.com" style="text-decoration:none;" target="_blank"> <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" width="180" alt="DSL Clinic" style="display:block;border:0;outline:none;text-decoration:none;"> </a>
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
											<path fill="#0ea5a6" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm142.2 172.2l-22.6-22.6c-6.2-6.2-16.4-6.2-22.6 0L224 288.8l-63-63c-6.2-6.2-16.4-6.2-22.6 0l-22.6 22.6c-6.2 6.2-6.2 16.4 0 22.6l96 96c6.2 6.2 16.4 6.2 22.6 0l163.8-163.8c6.3-6.2 6.3-16.4 0-22.6z" /> </svg>
									</td>
									<td>
										<h1 class="h1" style="margin:0;font-size:24px;line-height:32px;color:#0b2035;font-weight:700;">
                      Booking Confirmed
                    </h1>
										<p style="margin:6px 0 0;font-size:15px;line-height:24px;color:#475569;"> Hi {{ $clientData['name'] }}, your appointment is confirmed. We look forward to seeing you at <strong>DSL Clinic</strong>. </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- Appointment summary card -->
					<tr>
						<td class="p" style="padding:18px 40px 10px;">
							<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8fbff;border:1px solid #e6eef7;border-radius:12px;">
								<tr>
									<td style="padding:16px 18px;">
										<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;width:36%;">Service</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['service_name'] }}</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Date &amp; Time</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['slot_date'] }} at {{ $clientData['slot_time'] }}</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Duration</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['total_service_duration'] }} Minutes</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Clinician</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['clinic_name'] }}</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Clinic Location</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['clinic_address'] }}</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Booking ID</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['booking_date'] }}</td>
											</tr>
											<tr>
												<td style="font-size:13px;color:#64748b;padding:4px 0;">Payment</td>
												<td style="font-size:14px;color:#0b2035;padding:4px 0;">{{ $clientData['payment_method'] }} — £ {{ $clientData['payment_amount'] }}</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- Contact + small print -->
					<tr>
						<td style="padding:14px 40px 24px;">
							<p style="margin:0 0 6px;font-size:14px;color:#0b2035;">
                                Questions? Email <a href="mailto:hello@dslclinic.com" style="color:#0ea5a6;text-decoration:none;">hello@dslclinic.com</a>.
                            </p>
						</td>
					</tr>
				</table>
				<!-- Footer -->
				<table role="presentation" width="600" class="container" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:600px;margin-top:10px;">
					<tr>
						<td align="center" style="padding:8px 16px;">
							<p style="margin:0;font-size:12px;color:#94a3b8;"> © 2025 DSL Clinic — Diamond Skin Aesthetic &amp; Laser Clinic </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>