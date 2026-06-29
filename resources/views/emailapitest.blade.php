<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email API Test — Dsl Clinic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {font-family: system-ui; margin: 40px; max-width: 600px;}
    input, textarea {width: 100%; padding: 10px; margin: 6px 0;}
    button {padding: 10px 20px; cursor: pointer;}
    .alert {padding: 10px; margin: 10px 0; border-radius: 6px;}
    .success {background: #d1f7c4;}
    .error {background: #ffd1d1;}
  </style>
</head>
<body>
  <h2>SendGrid Email API Test</h2>

  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert error">{{ session('error') }}</div>
  @endif

  <form method="post" action="{{ route('emailapitest.sendBirthday') }}">
    @csrf
    <label>To Email:</label>
    <input type="email" name="to" value="{{ old('to') }}" required placeholder="someone@example.com">

    <label>Subject:</label>
    <input type="text" name="subject" value="{{ old('subject', 'Test Mail from Dsl Clinic') }}">

    <label>Message:</label>
    <textarea name="message" rows="6">{{ old('message', 'Hello from Dsl Clinic!') }}</textarea>

    <button type="submit">Send Email</button>
  </form>
</body>
</html>
