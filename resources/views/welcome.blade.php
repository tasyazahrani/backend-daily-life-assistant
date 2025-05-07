<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant | Sistem Pendukung Aktivitas Harian</title>
    <link rel="stylesheet" href="/css/Landingpage.css">
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
                    <a href="/page/user/login.html" class="btn btn-secondary">Masuk</a>
                    <a href="/page/user/signup.html" class="btn btn-primary">Daftar</a>
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
                        <img src="assets/user-avatars.png" alt="" class="avatar-group">
                    </div>
                </div>
                <div class="hero-image">
                    <img src="assets/hero-image.png" alt="Mahasiswi menggunakan aplikasi" class="main-image">
                    <!-- Removed the floating cards for "3 Tugas Hari Ini" and "2 Jam Fokus" as requested -->
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
                    <!-- Updated the featured functionalities as requested -->
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

    <!-- Development Team Section (formerly Popular Tools) -->
    <section class="popular-tools" id="tim">
        <div class="container">
            <h2>Tim Pengembang</h2>
            <p class="section-desc">Kenali tim yang membuat Daily Life Assistant menjadi aplikasi pendukung mahasiswi produktif</p>
            
            <div class="tools-grid">
                <div class="tool-card">
                    <div class="tool-image">
                        <img src="assets/team-1.png" alt="Team Member">
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
                
                <div class="tool-card">
                    <div class="tool-image">
                        <img src="assets/team-2.png" alt="Team Member">
                    </div>
                    <div class="tool-content">
                        <h4>Anisa Ramadhani</h4>
                        <p>UI/UX Designer</p>
                        <div class="tool-meta">
                            <span class="role"><i class="fas fa-palette"></i> Design</span>
                            <span class="exp"><i class="fas fa-calendar"></i> 4+ tahun</span>
                        </div>
                    </div>
                </div>
                
                <div class="tool-card">
                    <div class="tool-image">
                        <img src="assets/team-3.png" alt="Team Member">
                    </div>
                    <div class="tool-content">
                        <h4>Bunga Rasikhah Haya</h4>
                        <p>Frontend Developer</p>
                        <div class="tool-meta">
                            <span class="role"><i class="fas fa-laptop-code"></i> Frontend</span>
                            <span class="exp"><i class="fas fa-calendar"></i> 3+ tahun</span>
                        </div>
                    </div>
                </div>
                
                <div class="tool-card">
                    <div class="tool-image">
                        <img src="assets/team-4.png" alt="Team Member">
                    </div>
                    <div class="tool-content">
                        <h4>Khairun Nisa</h4>
                        <p>Content Specialist</p>
                        <div class="tool-meta">
                            <span class="role"><i class="fas fa-pen"></i> Content</span>
                            <span class="exp"><i class="fas fa-calendar"></i> 3+ tahun</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Keunggulan Section -->
<section class="keunggulan" id="keunggulan"> 
    <div class="container">
        <h2>Keunggulan DailyLife</h2>
        <p class="section-desc">Alasan mengapa DailyLife menjadi pilihan utama mahasiswi produktif</p>
        
        <div class="keunggulan-grid">
            <div class="keunggulan-card">
                <div class="keunggulan-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="keunggulan-content">
                    <h4>Meningkatkan Produktivitas</h4>
                    <p>Sistem pengelolaan waktu yang terintegrasi membantu mahasiswi meningkatkan produktivitas hingga 80% dalam mengelola tugas akademis dan aktivitas lainnya</p>
                    <ul class="keunggulan-list">
                        <li><i class="fas fa-check"></i> Reminder tugas otomatis</li>
                        <li><i class="fas fa-check"></i> Prioritas tugas cerdas</li>
                        <li><i class="fas fa-check"></i> Integrasi dengan kalender kampus</li>
                    </ul>
                </div>
            </div>
            
            <div class="keunggulan-card">
                <div class="keunggulan-icon">
                    <i class="fas fa-heart-pulse"></i>
                </div>
                <div class="keunggulan-content">
                    <h4>Kesehatan Terjaga</h4>
                    <p>Fitur pelacak kesehatan khusus wanita yang membantu mahasiswi memperhatikan pola tidur, nutrisi, dan siklus menstruasi di tengah padatnya jadwal kuliah</p>
                    <ul class="keunggulan-list">
                        <li><i class="fas fa-check"></i> Monitor kualitas tidur</li>
                        <li><i class="fas fa-check"></i> Pelacak siklus menstruasi</li>
                        <li><i class="fas fa-check"></i> Pengingat nutrisi harian</li>
                    </ul>
                </div>
            </div>
            
            <div class="keunggulan-card">
                <div class="keunggulan-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="keunggulan-content">
                    <h4>Keseimbangan Hidup</h4>
                    <p>Konsultasi dengan pendamping profesional membantu mahasiswi mengatasi burnout dan menemukan keseimbangan baru antara akademik, sosial, dan waktu pribadi</p>
                    <ul class="keunggulan-list">
                        <li><i class="fas fa-check"></i> Konsultasi psikolog</li>
                        <li><i class="fas fa-check"></i> Tips anti-burnout</li>
                        <li><i class="fas fa-check"></i> Analisis keseimbangan aktivitas</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="keunggulan-stats">
            <div class="stat-item">
                <div class="stat-number">80%</div>
                <p>Peningkatan produktivitas</p>
            </div>
            <div class="stat-item">
                <div class="stat-number">65%</div>
                <p>Penurunan tingkat stres</p>
            </div>
            <div class="stat-item">
                <div class="stat-number">27K+</div>
                <p>Mahasiswi aktif</p>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <p>Tingkat kepuasan</p>
            </div>
        </div>
        
        <div class="keunggulan-cta">
            <a href="#" class="btn btn-primary">Mulai Perjalanan Produktif</a>
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
                
                <div class="footer-links">
                    <h4>Halaman</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Fitur</a></li>
                        <li><a href="#">Tim</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h4>Fitur</h4>
                    <ul>
                        <li><a href="/page/user/todo.html">To-Do List</a></li>
                        <li><a href="/page/user/mood.html">Mood Tracker</a></li>
                        <li><a href="/page/user/financial.html">Financial Tracker</a></li>
                        <li><a href="/page/user/daily.html">Daily Quotes</a></li>
                        <li><a href="/page/user/selfcare.html">Self Care</a></li>
                    </ul>
                </div>
                
                <div class="footer-newsletter">
                    <h4>Berlangganan</h4>
                    <p>Dapatkan tips produktivitas terbaru</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Email anda...">
                        <button class="btn btn-primary">Kirim</button>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Daily Life Assistant. All rights reserved.</p>
                <div class="footer-terms">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="/js/Landingpage.js"></script>
</body>
</html>