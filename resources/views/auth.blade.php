<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In / Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f6f5f7;
            margin: 0;
        }
        h2 { font-weight: bold; margin-bottom: 20px; }
        p { font-size: 14px; font-weight: 100; line-height: 20px; letter-spacing: 0.5px; }
        button {
            border-radius: 20px;
            border: 1px solid #512da8;
            background-color: #512da8;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }
        button:active { transform: scale(0.95); }
        button:focus { outline: none; }
        button.ghost { background-color: transparent; border-color: #fff; }
        form {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 5px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25),
                        0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            min-height: 550px;
        }
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
        .container.right-panel-active .sign-in-container { transform: translateX(100%); }
        .container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; }
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        .overlay {
            background: linear-gradient(to right, #5c6bc0, #512da8);
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        .container.right-panel-active .overlay-container { transform: translateX(-100%); }
        .container.right-panel-active .overlay { transform: translateX(50%); }
        .overlay-panel {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }
    </style>
</head>
<body>

<div class="container {{ session('form') == 'register' ? 'right-panel-active' : '' }}" id="container">
    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <h2>Create Account</h2>
            @if ($errors->any() && session('form') == 'register')
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            <input type="text" name="contact" placeholder="Contact Number" value="{{ old('contact') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Sign In Form -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <h2>Sign In</h2>
            @if ($errors->any() && session('form') == 'login')
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h2>Welcome Back!</h2>
                <p>Enter your personal details to use all of site features</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h2>Hello, Friend!</h2>
                <p>Register with your personal details to use all of site features</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
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

<script>
const container = document.getElementById('container');
document.getElementById('signUp').addEventListener('click', () => container.classList.add("right-panel-active"));
document.getElementById('signIn').addEventListener('click', () => container.classList.remove("right-panel-active"));
</script>

</body>
</html>
