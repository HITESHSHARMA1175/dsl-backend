@extends('frontend.layout.app')

@section('content')

<div class="breadcrumb-cell" aria-label="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb mb-0">
                    <a href="{{ url('/') }}"> Home </a> &gt; Privacy Policy
                </ol>
            </div>
        </div>
    </div>
</div>

<!--
<section class="banner-hero p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="homepage-slider-banner">
                    @foreach ($home_top_banner as $item)
                    <a href="#">
                        <img src="{{ !empty($item->profile) ? asset('uploads/banner/' . $item->profile) : asset('uploads/userimage/no-banner.jpg') }}" alt="">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
-->

<section class="About-Pulse pb-0">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                            <h3><strong>Privacy Policy</strong></h3>
            </div>
        </div>
    </div>
</section>

<section class="about-pulse-light-clinic">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
 
                <!-- ✅ NEW SECTION: Privacy Policy (Added) -->
                <section class="privacy-policy-section" style="padding-top:20px;">
                    <div class="row">
                        <div class="col-12">
                            <h3><strong>Doctor Skin Clinic Ltd</strong></h3>

                            <p><span style="font-weight: 400;">
                                Effective date:
                                {{ !empty($privacy_effective_date) ? $privacy_effective_date : '[9 January 2026]' }}
                            </span></p>

                            <p><span style="font-weight: 400;">Doctor Skin Clinic Ltd is committed to protecting your personal data and respecting your privacy. This Privacy Policy explains how we collect, use, store, and protect your personal information when you interact with us, use our services, visit our website, or communicate with us in any way.</span></p>

                            <p><span style="font-weight: 400;">This policy is written in accordance with the UK General Data Protection Regulation and the Data Protection Act 2018.</span></p>

                            <h3><strong>Who we are</strong></h3>

                            <p><span style="font-weight: 400;">
                                Doctor Skin Clinic Ltd<br>
                                Registered in England and Wales<br>
                                Registered office address: 758 Harrow Road, Wembley, HA9 6AZ<br>
                                Email: hello@dslclinic.com
                            </span></p>

                            <p><span style="font-weight: 400;">
                                Telephone: 0208 004 0277<br>
                                Website: www.dslclinic.com
                            </span></p>

                            <p><span style="font-weight: 400;">For the purposes of data protection law, Doctor Skin Clinic Ltd is the data controller.</span></p>

                            <h3><strong>The personal data we collect</strong></h3>
                            <p><span style="font-weight: 400;">We may collect and process the following categories of personal data:</span></p>

                            <p><strong>Identity information</strong><br>
                                <span style="font-weight: 400;">This includes your full name, date of birth, gender, and title.</span>
                            </p>

                            <p><strong>Contact information</strong><br>
                                <span style="font-weight: 400;">This includes your address, email address, telephone number, and emergency contact details.</span>
                            </p>

                            <p><strong>Medical and health information</strong><br>
                                <span style="font-weight: 400;">This includes medical history, medications, allergies, consultation notes, treatment suitability assessments, consent forms, photographs taken for treatment purposes, and aftercare records. This information is classified as special category data.</span>
                            </p>

                            <p><strong>Appointment and treatment information</strong><br>
                                <span style="font-weight: 400;">This includes booking details, consultation dates, treatment plans, treatments undertaken, and follow up communications.</span>
                            </p>

                            <p><strong>Financial information</strong><br>
                                <span style="font-weight: 400;">This includes invoices, payment records, finance agreements, Klarna or third party payment provider information, and chargeback or dispute correspondence. We do not store full card details.</span>
                            </p>

                            <p><strong>Technical information</strong><br>
                                <span style="font-weight: 400;">This includes IP address, browser type, device information, and website usage data collected through cookies.</span>
                            </p>

                            <p><strong>Marketing and communication information</strong><br>
                                <span style="font-weight: 400;">This includes your communication preferences and your interactions with our emails, messages, and marketing materials.</span>
                            </p>

                            <h3><strong>How we collect your data</strong></h3>
                            <p><span style="font-weight: 400;">We collect personal data directly from you through:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">Consultation forms and medical questionnaires</span></li>
                                <li><span style="font-weight: 400;">Online booking systems and enquiry forms</span></li>
                                <li><span style="font-weight: 400;">In clinic registration and consent processes</span></li>
                                <li><span style="font-weight: 400;">Email, WhatsApp, telephone, and SMS communications</span></li>
                                <li><span style="font-weight: 400;">Payments made online or in clinic</span></li>
                                <li><span style="font-weight: 400;">Our website and cookie technology</span></li>
                                <li><span style="font-weight: 400;">Third party finance providers where applicable</span></li>
                            </ul>

                            <h3><strong>How we use your personal data</strong></h3>
                            <p><span style="font-weight: 400;">We use your personal data for the following purposes:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">To assess your suitability for treatments and ensure patient safety</span></li>
                                <li><span style="font-weight: 400;">To provide aesthetic, laser, and medical skin treatments</span></li>
                                <li><span style="font-weight: 400;">To manage appointments, treatment plans, and aftercare</span></li>
                                <li><span style="font-weight: 400;">To process payments and manage accounts</span></li>
                                <li><span style="font-weight: 400;">To communicate with you regarding your care or enquiries</span></li>
                                <li><span style="font-weight: 400;">To comply with legal, regulatory, and insurance obligations</span></li>
                                <li><span style="font-weight: 400;">To manage complaints, disputes, and chargebacks</span></li>
                                <li><span style="font-weight: 400;">To improve our services and website functionality</span></li>
                                <li><span style="font-weight: 400;">To send marketing communications where consent has been provided</span></li>
                            </ul>

                            <h3><strong>Lawful bases for processing</strong></h3>
                            <p><span style="font-weight: 400;">We process personal data under the following lawful bases:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">Performance of a contract</span></li>
                                <li><span style="font-weight: 400;">Legal obligation</span></li>
                                <li><span style="font-weight: 400;">Legitimate interests</span></li>
                                <li><span style="font-weight: 400;">Consent</span></li>
                                <li><span style="font-weight: 400;">Vital interests relating to medical safety</span></li>
                                <li><span style="font-weight: 400;">Provision of health or social care under Article 9 of UK GDPR</span></li>
                            </ul>

                            <p><span style="font-weight: 400;">Special category medical data is processed strictly for healthcare purposes and patient safety.</span></p>

                            <h3><strong>Marketing communications</strong></h3>
                            <p><span style="font-weight: 400;">We may send you information about treatments, offers, or clinic updates where you have provided consent or where permitted under applicable soft opt in rules.</span></p>
                            <p><span style="font-weight: 400;">You can withdraw consent at any time by contacting us or using the unsubscribe option provided in our communications.</span></p>

                            <h3><strong>Sharing your personal data</strong></h3>
                            <p><span style="font-weight: 400;">We may share your personal data with trusted third parties where necessary, including:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">Medical practitioners and clinical staff working with or for the clinic</span></li>
                                <li><span style="font-weight: 400;">Payment processors and finance providers</span></li>
                                <li><span style="font-weight: 400;">IT systems, software providers, and booking platforms</span></li>
                                <li><span style="font-weight: 400;">Marketing service providers where consent has been given</span></li>
                                <li><span style="font-weight: 400;">Legal, regulatory, professional, or insurance advisers</span></li>
                                <li><span style="font-weight: 400;">Regulatory bodies where disclosure is required by law</span></li>
                            </ul>

                            <p><span style="font-weight: 400;">All third parties are required to process your data securely and in accordance with data protection legislation.</span></p>

                            <h3><strong>International data transfers</strong></h3>
                            <p><span style="font-weight: 400;">Where personal data is transferred outside the United Kingdom, we ensure appropriate safeguards are in place, including contractual protections required by law.</span></p>

                            <h3><strong>Data security</strong></h3>
                            <p><span style="font-weight: 400;">We implement appropriate technical and organisational measures to protect your personal data from unauthorised access, loss, misuse, alteration, or disclosure.</span></p>
                            <p><span style="font-weight: 400;">Access to medical records is restricted to authorised personnel only. Electronic records are password protected and stored on secure systems.</span></p>

                            <h3><strong>Data retention</strong></h3>
                            <p><span style="font-weight: 400;">We retain personal data only for as long as necessary:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">Medical records are retained in line with clinical, legal, and insurance requirements</span></li>
                                <li><span style="font-weight: 400;">Financial records are retained for statutory accounting periods</span></li>
                                <li><span style="font-weight: 400;">Marketing data is retained until consent is withdrawn</span></li>
                            </ul>
                            <p><span style="font-weight: 400;">Once data is no longer required, it is securely deleted or anonymised.</span></p>

                            <h3><strong>Your data protection rights</strong></h3>
                            <p><span style="font-weight: 400;">You have the right to:</span></p>
                            <ul>
                                <li><span style="font-weight: 400;">Request access to your personal data</span></li>
                                <li><span style="font-weight: 400;">Request correction of inaccurate or incomplete data</span></li>
                                <li><span style="font-weight: 400;">Request deletion of your personal data where applicable</span></li>
                                <li><span style="font-weight: 400;">Restrict or object to processing</span></li>
                                <li><span style="font-weight: 400;">Withdraw consent at any time</span></li>
                                <li><span style="font-weight: 400;">Request data portability</span></li>
                                <li><span style="font-weight: 400;">Lodge a complaint with the Information Commissioner’s Office</span></li>
                            </ul>

                            <p><span style="font-weight: 400;">
                                Information Commissioner’s Office<br>
                                Website: www.ico.org.uk
                            </span></p>

                            <h3><strong>Cookies</strong></h3>
                            <p><span style="font-weight: 400;">Our website uses cookies to improve performance and user experience. You can manage cookie preferences through your browser settings.</span></p>
                            <p><span style="font-weight: 400;">Further information is available in our Cookie Policy.</span></p>

                            <h3><strong>Children’s data</strong></h3>
                            <p><span style="font-weight: 400;">We do not knowingly collect personal data from individuals under the age of 18 without parental or guardian consent.</span></p>

                            <h3><strong>Changes to this policy</strong></h3>
                            <p><span style="font-weight: 400;">We may update this Privacy Policy from time to time. Any updates will be published on our website and, where appropriate, communicated to you.</span></p>

                            <h3><strong>Contact us</strong></h3>
                            <p><span style="font-weight: 400;">If you have any questions about this Privacy Policy or how we handle your personal data, please contact:</span></p>
                            <p><span style="font-weight: 400;">
                                Doctor Skin Clinic Ltd<br>
                                Email: hello@dslclinic.com<br>
                                Telephone: 0208 004 0277
                            </span></p>
                        </div>
                    </div>
                </section>
                <!-- ✅ END Privacy Policy Section -->

            </div>

        </div>
    </div>
</section>

<section class="Clinics-located">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="mb-3">Clinics located in Central London</h2>
                <p>We are committed to delivering excellent customer service. Our aspiration towards perfection and forward-thinking in the aesthetic industry has enabled us to develop our reputation as London’s leading Laser brand, with a steady growth of our services and locations in London.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="discuss-you text-center">
                    <h3 class="mb-3">Let's discuss you body goals!</h3>
                    <a href="{{ url('contact') }}" class="bigbtn primary-btn btn book-a-free pill">Book Your Free Consultation</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection