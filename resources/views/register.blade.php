<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 420px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 500px) {
            .form-container {
                margin: 20px;
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
        <input type="text" name="contact" placeholder="Contact Number" value="{{ old('contact') }}" required>
       
        <select name="otp_method" required>
            <option value="">Select OTP Method</option>
            <option value="email" {{ old('otp_method') == 'email' ? 'selected' : '' }}>Email</option>
            <option value="contact" {{ old('otp_method') == 'contact' ? 'selected' : '' }}>Contact (SMS)</option>
        </select>

        <input type="password" name="password" placeholder="Password" required>
        <div class="mt-2 d-grid">
          <button type="submit" class="btn btn-primary btn-block mb-2">Register</button>
          <a href="home" class="btn btn-primary btn-block">Back to Home</a>
        </div>
    </form>
</div>

</body>
</html>
