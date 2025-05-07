<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant | Sistem Pendukung Aktivitas Harian</title>
    <link rel="stylesheet" href="{{ asset('/css/Landingpage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <h2>DailyLifeAssistant</h2>
                </div>
                <nav>
                    <ul class="nav-links">
                        <li><a href="#beranda" class="active">Beranda</a></li>
                        <li><a href="#fitur">Fitur</a></li>  
                        <li><a href="#tim">Tim</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                    </ul>
                </nav>
                <div class="header-buttons">
                    <a href="{{ url('/page/user/login.html') }}" class="btn btn-secondary">Masuk</a>
                    <a href="{{ url('/page/user/signup.html') }}" class="btn btn-primary">Daftar</a>
                </div>
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Kembangkan keseimbanganmu dengan cara baru dan unik</h1>
                    <p>Sistem pendukung aktivitas harian khusus untuk mahasiswi produktif yang ingin mencapai keseimbangan hidup.</p>
                    <button class="btn btn-primary">Mulai Sekarang</button>
                    <div class="user-count">
                        <img src="{{ asset('assets/user-avatars.png') }}" alt="" class="avatar-group">
                    </div>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/hero-image.png') }}" alt="Mahasiswi menggunakan aplikasi" class="main-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Search Section -->
    <section class="features-search" id="fitur">
        <div class="container">
            <h2>Cari Fitur</h2>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari dari 50+ fitur..." class="search-input">
                <button class="btn btn-primary">Cari</button>
            </div>

            <div class="features-highlight">
                <h3>Fitur Dari Daily Life Assistant</h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon purple">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <h4>To-Do List</h4>
                        <p>Mengelola tugas dan kegiatan harian dengan mudah dan terorganisir</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon pink">
                            <i class="fas fa-face-smile"></i>
                        </div>
                        <h4>Mood Tracker</h4>
                        <p>Lacak dan analisis perubahan suasana hati untuk kesehatan mental yang lebih baik</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon orange">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h4>Financial Tracker</h4>
                        <p>Kelola keuangan pribadi dengan sistem pencatatan dan analisis pengeluaran</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <h4>Daily Quotes</h4>
                        <p>Dapatkan inspirasi dan motivasi harian melalui kutipan yang menyemangati</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon green">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>Self Care</h4>
                        <p>Panduan dan pengingat untuk merawat diri secara fisik dan mental</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Team Section -->
    <section class="popular-tools" id="tim">
        <div class="container">
            <h2>Tim Pengembang</h2>
            <p class="section-desc">Kenali tim yang membuat Daily Life Assistant menjadi aplikasi pendukung mahasiswi produktif</p>
            
            <div class="tools-grid">
                <div class="tool-card">
                    <div class="tool-image">
                        <img src="{{ asset('assets/team-1.png') }}" alt="Team Member">
                    </div>
                    <div class="tool-content">
                        <h4>Tasya Zahrani</h4>
                        <p>Lead Developer</p>
                        <div class="tool-meta">
                            <span class="role"><i class="fas fa-code"></i> Backend</span>
                            <span class="exp"><i class="fas fa-calendar"></i> 5+ tahun</span>
                        </div>
                    </div>
                </div>
                
                <!-- Additional team members can be added here -->
                
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>DailyLife</h3>
                    <p>Sistem pendukung aktivitas harian dan keseimbangan hidup untuk mahasiswi produktif.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Additional footer content -->
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/Landingpage.js') }}"></script>
</body>
</html>
