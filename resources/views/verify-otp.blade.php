<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background: #e0f7fa;">
<div class="container" style="max-width: 400px;">
    <div class="bg-white p-4 rounded shadow-sm">
        <h4 class="text-center mb-3">Enter OTP</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('verify.otp.submit') }}" method="POST">
            @csrf
            <input type="text" name="otp" class="form-control mb-3" placeholder="Enter 6-digit OTP" required>
            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>
    </div>
</div>
</body>
</html>
