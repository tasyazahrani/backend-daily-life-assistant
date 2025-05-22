<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daily Life Assistant - Login</title>
    <!-- Link CSS Laravel -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form-container">
            <h1>Login</h1>
            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="email" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="forgot-password">
                    <a href="#">Forget Password?</a>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a> Now</p>
            </div>
        </div>
            <div class="illustration-container">
                <div class="container">
            <div class="left-panel">
                <h1><span class="gray">Daily Life</span> <span class="bold">ASSISTANT</span></h1>
                <p>Sistem Pendukung Aktivitas Harian dan<br/>Keseimbangan Hidup untuk<br/>Mahasiswi Produktif</p>
                <img src="{{ asset('images/icon login.png') }}" alt="Ilustrasi Mahasiswi" class="illustration"/>
            </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
