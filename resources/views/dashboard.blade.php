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
            <h3>Mood History</h3>
            <div class="mood-history">
                @php
                    $moods = [
                        ['emoji' => '😀', 'day' => 'Mon'],
                        ['emoji' => '😃', 'day' => 'Tue'],
                        ['emoji' => '😡', 'day' => 'Wed'],
                        ['emoji' => '😊', 'day' => 'Thu'],
                        ['emoji' => '🙂', 'day' => 'Fri'],
                        ['emoji' => '😊', 'day' => 'Sat'],
                        ['emoji' => '😊', 'day' => 'Sun'],
                    ];
                @endphp

                @foreach($moods as $mood)
                    <div class="mood-day">
                        <div class="emoji">{{ $mood['emoji'] }}</div>
                        <p>{{ $mood['day'] }}</p>
                    </div>
                @endforeach
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
@endsection
