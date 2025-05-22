<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant - Daily Quotes</title>
    <link rel="stylesheet" href="{{ asset('css/daily.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <li><a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="{{ url('/todo') }}"><i class="fas fa-list-check"></i> To-Do List</a></li>
                    <li><a href="{{ url('/mood') }}"><i class="fas fa-face-smile"></i> Mood Tracker</a></li>
                    <li><a href="{{ url('/financial') }}"><i class="fas fa-wallet"></i> Financial Tracker</a></li>
                    <li class="active"><a href="{{ route('daily.quotes.index') }}"><i class="fas fa-quote-left"></i> Daily Quote</a></li>
                    <li><a href="{{ url('/selfcare') }}"><i class="fas fa-heart"></i> Self-Care</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="{{ url('/') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h2>Daily Quotes</h2>
            </header>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            <!-- Today's Quote -->
            <div class="quote-of-the-day">
                <div class="quote-box">
                    @if($todayQuote)
                        <blockquote>
                            <p>"{{ $todayQuote->text }}"</p>
                            <footer>• {{ $todayQuote->author }}</footer>
                        </blockquote>
                    @endif

                    <h2>Previous Quotes</h2>
                    @foreach($previousQuotes as $quote)
                        <div>
                            <p>"{{ $quote->text }}"</p>
                            <small>• {{ $quote->author }}</small><br>
                            <small>{{ \Carbon\Carbon::parse($quote->quote_date)->format('F d, Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Previous Quotes -->
            <section class="previous-quotes">
                <h3>Previous Quotes</h3>
                <div class="quotes-grid">
                    @forelse ($previousQuotes as $quote)
                        <div class="quote-card">
                            <p class="quote-text">"{{ Str::limit($quote->text, 150) }}"</p>
                            <p class="quote-author">
                                <span class="bullet">•</span> {{ $quote->author ?? 'Anonymous' }}
                            </p>
                            <p class="quote-date">{{ \Carbon\Carbon::parse($quote->quote_date)->format('M d, Y') }}</p>
                        </div>
                    @empty
                        <!-- Default Previous Quotes when database is empty -->
                        <div class="quote-card">
                            <p class="quote-text">"The future belongs to those who believe in the beauty of their dreams."</p>
                            <p class="quote-author">
                                <span class="bullet">•</span> Steve Jobs
                            </p>
                            <p class="quote-date">April 18, 2025</p>
                        </div>
                        <div class="quote-card">
                            <p class="quote-text">"Happiness is not something ready made. It comes from your own actions."</p>
                            <p class="quote-author">
                                <span class="bullet">•</span> Dalai Lama
                            </p>
                            <p class="quote-date">April 17, 2025</p>
                        </div>
                        <div class="quote-card">
                            <p class="quote-text">"The best time to plant a tree was 20 years ago. The second best time is now."</p>
                            <p class="quote-author">
                                <span class="bullet">•</span> Chinese Proverb
                            </p>
                            <p class="quote-date">April 16, 2025</p>
                        </div>
                        <div class="quote-card">
                            <p class="quote-text">"It does not matter how slowly you go as long as you do not stop."</p>
                            <p class="quote-author">
                                <span class="bullet">•</span> Confucius
                            </p>
                            <p class="quote-date">April 15, 2025</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Save Quote Section -->
            <section class="save-quotes">
                <h3>Save Your Favorite Quotes</h3>
                @if ($todayQuote)
                    <form method="POST" action="{{ route('daily.quotes.favorite', $todayQuote->id) }}">
                        @csrf
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-light">Save today's quote</button>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode('"' . $todayQuote->text . '" - ' . ($todayQuote->author ?? 'Anonymous')) }}" target="_blank" class="btn btn-primary">Share</a>
                        </div>
                    </form>
                @else
                    <div class="action-buttons">
                        <button class="btn btn-light">Save today's quote</button>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode('"The only way to do great work is to love what you do." - Steve Jobs') }}" target="_blank" class="btn btn-primary">Share</a>
                    </div>
                @endif
            </section>

            <!-- Add Your Own Quote -->
            <section class="add-quote">
                <h3>Add Your Own Quote</h3>
                <form method="POST" action="{{ route('daily.quotes.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="quote-text">Quote Text</label>
                        <textarea name="text" id="quote-text" placeholder="Enter your favorite quote..." required>{{ old('text') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="quote-author">Author</label>
                        <input type="text" name="author" id="quote-author" placeholder="Enter the author's name..." value="{{ old('author') }}">
                    </div>
                    <button type="submit" class="btn btn-light">Add Quote</button>
                </form>
            </section>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>

    <script src="{{ asset('js/daily.js') }}"></script>
</body>
</html>