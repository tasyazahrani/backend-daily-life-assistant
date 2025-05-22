@extends('layouts.app')

@section('title', 'Daily Quotes')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/daily.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <header>
        <h2>Daily Quotes</h2>
    </header>

    <!-- Today's Quote -->
    <div class="quote-of-the-day">
        <div class="quote-box">
            @if($todayQuote)
                <p class="quote-text">"{{ $todayQuote->text }}"</p>
                <p class="quote-author">
                    <span class="bullet">•</span> {{ $todayQuote->author }}
                </p>
            @else
                <p class="quote-text">No quote available for today.</p>
            @endif
        </div>
    </div>

    <!-- Previous Quotes -->
    <section class="previous-quotes">
        <h3>Previous Quotes</h3>
        <div class="quotes-grid">
            @forelse($previousQuotes as $quote)
                <div class="quote-card">
                    <p class="quote-text">"{{ $quote->text }}"</p>
                    <p class="quote-author">
                        <span class="bullet">•</span> {{ $quote->author }}
                    </p>
                    <p class="quote-date">{{ \Carbon\Carbon::parse($quote->date)->format('F j, Y') }}</p>
                </div>
            @empty
                <p>No previous quotes available.</p>
            @endforelse
        </div>
    </section>

    <!-- Save Quote Buttons -->
    <section class="save-quotes">
        <h3>Save Your Favorite Quotes</h3>
        <div class="action-buttons">
            <button id="save-quote" class="btn btn-light">Save today's quote</button>
            <button id="share-quote" class="btn btn-primary">Share</button>
        </div>
    </section>

    <!-- Add Your Own Quote -->
    <section class="add-quote">
        <h3>Add Your Own Quote</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('quotes.store') }}" method="POST" id="quote-form">
            @csrf
            <div class="form-group">
                <label for="quote-text">Quote Text</label>
                <textarea id="quote-text" name="text" placeholder="Enter your favorite quote..." required></textarea>
            </div>
            <div class="form-group">
                <label for="quote-author">Author</label>
                <input type="text" id="quote-author" name="author" placeholder="Enter the author's name..." required>
            </div>
            <button type="submit" class="btn btn-light">Add Quote</button>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/daily.js') }}"></script>
@endpush
