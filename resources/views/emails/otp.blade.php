<!-- <!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
</head>
<body class="p-4">
<div class="container">
    <h2>Enter the OTP sent to your email</h2>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf
        <input type="text" name="otp" class="form-control my-2" placeholder="Enter OTP" required>
        <button class="btn btn-success">Verify</button>
    </form>
</div>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session("success") }}',
});
</script>
@endif
</body>
</html>
<!-- <body>
    <p>Hello,</p>
    <p>Your OTP is: <strong>{{ $otp }}</strong></p>
    <p>Thank you for registering!</p>
</body> --> -->
