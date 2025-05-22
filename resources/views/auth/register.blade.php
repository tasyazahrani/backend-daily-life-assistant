<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant | Sistem Pendukung Aktivitas Harian</title>
    <!-- Link CSS Laravel -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1><span class="gray">Daily Life</span> <span class="bold">ASSISTANT</span></h1>
            <p>Sistem Pendukung Aktivitas Harian dan<br/>Keseimbangan Hidup untuk<br/>Mahasiswi Produktif</p>
            <img src="{{ asset('images/icon login.png') }}" alt="Ilustrasi Mahasiswi" class="illustration"/>
        </div>
        <div class="right-panel">
            <h2>Daftar</h2>

            <!-- Menampilkan pesan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulir Registrasi -->
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}"/>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Email" required value="{{ old('email') }}"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Password" required />
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                </div>
                <button type="submit" class="signup-btn">Daftar</button>
                <p class="login-link">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
