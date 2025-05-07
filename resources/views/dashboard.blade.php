<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <h1>Daily Life Assistant</h1>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-list-check"></i> To-Do List</a></li>
                    <li><a href="#"><i class="fas fa-face-smile"></i> Mood Tracker</a></li>
                    <li><a href="#"><i class="fas fa-wallet"></i> Financial Tracker</a></li>
                    <li><a href="#"><i class="fas fa-quote-left"></i> Daily Quote</a></li>
                    <li><a href="#"><i class="fas fa-heart"></i> Self-Care</a></li>
                </ul>
            </nav>
            <div class="logout">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h2>Welcome, {{ Auth::user()->name }}</h2> <!-- Display user name -->
            </header>

            <!-- Quote Section -->
            <div class="quote-card">
                <blockquote>"The only way to do great work is to love what you do."</blockquote>
                <p class="quote-author">• Steve Jobs</p>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Today's Tasks -->
                <div class="card">
                    <h3>Today's Tasks</h3>
                    <div class="task-list">
                        <div class="task-item">
                            <input type="checkbox" id="task1">
                            <label for="task1">Sistem Informasi Proposal</label>
                        </div>
                        <div class="task-item">
                            <input type="checkbox" id="task2">
                            <label for="task2">PBW Kelompok</label>
                        </div>
                        <div class="task-item">
                            <input type="checkbox" id="task3">
                            <label for="task3">RPL PKM</label>
                        </div>
                    </div>
                </div>

                <!-- Mood History -->
                <div class="card">
                    <h3>Mood History</h3>
                    <div class="mood-history">
                        <div class="mood-day">
                            <div class="emoji">😀</div>
                            <p>Mon</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">😃</div>
                            <p>Tue</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">😡</div>
                            <p>Wed</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">😊</div>
                            <p>Thu</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">🙂</div>
                            <p>Fri</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">😊</div>
                            <p>Sat</p>
                        </div>
                        <div class="mood-day">
                            <div class="emoji">😊</div>
                            <p>Sun</p>
                        </div>
                    </div>
                </div>

                <!-- Self-Care Status -->
                <div class="card">
                    <h3>Self-Care Status</h3>
                    <div class="self-care-list">
                        <div class="self-care-item">
                            <div class="self-care-icon water">💧</div>
                            <p>5/8 Glasses</p>
                        </div>
                        <div class="self-care-item">
                            <div class="self-care-icon completed">✅</div>
                            <p>Skincare</p>
                        </div>
                        <div class="self-care-item">
                            <div class="self-care-icon completed">✅</div>
                            <p>Exercise</p>
                        </div>
                        <div class="self-care-item">
                            <div class="self-care-icon not-completed">❌</div>
                            <p>Rest</p>
                        </div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="card">
                    <h3>Financial Summary</h3>
                    <div class="financial-summary">
                        <div class="financial-item">
                            <p>Income :</p>
                            <p class="income">Rp 2.500.000</p>
                        </div>
                        <div class="financial-item">
                            <p>Expenses :</p>
                            <p class="expenses">Rp 1.250.000</p>
                        </div>
                        <div class="financial-item balance">
                            <p>Balance :</p>
                            <p>Rp 1.250.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
