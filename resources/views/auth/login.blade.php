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
            <div class="content">
                <h2>Daily Life <span>ASSISTANT</span></h2>
                <p>Sistem Pendukung Aktivitas Harian dan Keseimbangan Hidup untuk Mahasiswi Produktif</p>
            </div>
            <div class="illustration">
                <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f4c5.svg" alt="Calendar" class="calendar">
                <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f4da.svg" alt="Books" class="books">
                <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f9d1-200d-1f4bb.svg" alt="Student" class="student">
                <div class="decoration-items">
                    <div class="tree"></div>
                    <div class="tree"></div>
                    <div class="cup"></div>
                    <div class="book"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
