@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<header>
    <h2>Welcome, {{ Auth::user()->name }}</h2>
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
            @forelse($todos as $todo)
                <div class="task-item">
                    <input type="checkbox" id="task-{{ $todo->id }}" {{ $todo->is_completed ? 'checked' : '' }} disabled>
                    <label for="task-{{ $todo->id }}">{{ $todo->task }}</label>
                </div>
            @empty
                <p>No tasks available.</p>
            @endforelse
        </div>
    </div>

    <!-- Mood History -->
    <div class="card">
    <h3>Mood Hari Ini</h3>
    <div class="mood-history">
        @if($mood)
            <div class="mood-day">
                <div class="emoji">{{ $mood->emoji }}</div>
                <p class="mood-date">{{ $mood->created_at->format('l, d M Y') }}</p>
                <p class="mood-text">Feeling: <strong>{{ $mood->mood }}</strong></p>
                <p class="diary">{{ $mood->diary_text }}</p>
            </div>
        @else
            <p>No mood entry for today.</p>
        @endif
    </div>
</div>


    <!-- Self-Care Status -->
    <div class="card">
        <h3>Self-Care Status</h3>
        <div class="self-care-list">
            @forelse($selfcares as $item)
                <div class="self-care-item">
                    <div class="self-care-icon">{{ $item->icon }}</div>
                    <p>{{ $item->description }}</p>
                </div>
            @empty
                <p>No self-care data available.</p>
            @endforelse
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="card">
        <h3>Financial Summary</h3>
        <div class="financial-summary">
            <div class="financial-item">
                <p>Income :</p>
                <p class="income">Rp {{ number_format($financial['income'], 0, ',', '.') }}</p>
            </div>
            <div class="financial-item">
                <p>Expenses :</p>
                <p class="expenses">Rp {{ number_format($financial['expenses'], 0, ',', '.') }}</p>
            </div>
            <div class="financial-item balance">
                <p>Balance :</p>
                <p>Rp {{ number_format($financial['balance'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
