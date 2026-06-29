<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Welcome to DSL Clinic</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	@media only screen and (max-width:600px) {
		.container {
			width: 100%!important
		}
		.p-24 {
			padding: 16px!important
		}
		.h1 {
			font-size: 22px!important;
			line-height: 28px!important
		}
		.btn {
			display: block!important;
			width: 100%!important
		}
	}
	</style>
</head>

<body style="margin:0; padding:0; background:#f5f8fc; font-family:Inter,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
	<!-- Preheader -->
	<div style="display:none; max-height:0; overflow:hidden; opacity:0;"> Welcome to DSL Clinic — your profile has been successfully created. </div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f5f8fc;">
		<tr>
			<td align="center" style="padding:24px;">
				<table class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:14px; box-shadow:0 4px 22px rgba(0,0,0,0.06); max-width:600px;">
					<!-- Logo -->
					<tr>
						<td align="center" style="padding:30px 16px 10px;"> <img src="https://dslclinic.com/frontend/images/logo-plc.jpeg" alt="DSL Clinic" width="180" style="display:block; border:0; outline:none; text-decoration:none;"> </td>
					</tr>
					<!-- Header -->
					<tr>
						<td class="p-24" style="padding:24px 40px 10px;">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="36" valign="top" style="padding-right:10px;">
										<svg width="28" height="28" viewBox="0 0 512 512" aria-hidden="true" style="display:block;">
											<path fill="#0963f9" d="M464 128c-26.5 0-48 21.5-48 48v80h-16V64c0-26.5-21.5-48-48-48s-48 21.5-48 48v192h-16V40c0-22.1-17.9-40-40-40s-40 17.9-40 40v216h-16V88c0-22.1-17.9-40-40-40s-40 17.9-40 40v232h-16v-88c0-22.1-17.9-40-40-40S0 209.9 0 232v64c0 114.9 93.1 208 208 208h80c114.9 0 208-93.1 208-208V176c0-26.5-21.5-48-48-48z" /> </svg>
									</td>
									<td>
										<h1 class="h1" style="margin:0; font-size:24px; line-height:32px; color:#0b2035; font-weight:700;">
                                          Welcome to DSL Clinic, {{ $clientData['name'] }}
                                        </h1>
										<p style="margin:8px 0 0; font-size:15px; line-height:24px; color:#475569;"> Your profile has been successfully created. You can now manage appointments, view treatments, and access your records anytime from your dashboard. </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- CTA -->
					<tr>
						<td align="center" style="padding:20px 40px;"> <a href="https://dslclinic.com/" target="_blank" style="background:#0963f9; color:#ffffff; text-decoration:none; font-size:15px; font-weight:600; padding:12px 22px; border-radius:8px; display:inline-block;">
                            Open Website
                          </a> </td>
					</tr>
					<!-- Features -->
					<tr>
						<td style="padding:10px 40px 20px;">
							<h3 style="font-size:16px; color:#0b2035; margin-bottom:6px;">Here’s what you can do:</h3>
							<ul style="margin:0; padding-left:20px; color:#475569; font-size:14px; line-height:22px;">
								<li>Book or reschedule your appointments online</li>
								<li>View your treatment plans and post-care tips</li>
								<li>Track invoices & download receipts</li>
								<li>Get updates, reminders, and special offers</li>
							</ul>
						</td>
					</tr>
					<!-- Divider -->
					<tr>
						<td style="padding:0 40px;">
							<hr style="border:0; border-top:1px solid #e2e8f0;"> </td>
					</tr>
					<!-- Footer -->
					<tr>
						<td align="center" style="padding:30px 16px;">
							<p style="margin:0; font-size:12px; color:#64748b; line-height:20px;"> Need help? Email us at <a href="mailto:hello@dslclinic.com" style="color:#0963f9; text-decoration:none;">hello@dslclinic.com</a> </p>
							<p style="margin:4px 0 0; font-size:12px; color:#64748b;"> DSL Clinic — Diamond Skin Aesthetic & Laser Clinic </p>
							<p style="margin:4px 0 0; font-size:11px; color:#94a3b8;"> You received this email because you created a profile on DSL Clinic. </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>