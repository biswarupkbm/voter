<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
