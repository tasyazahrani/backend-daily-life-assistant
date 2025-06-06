@extends('layouts.app')

@section('title', 'Self-Care Tracker')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/selfcare.css') }}">
@endpush

@section('content')
    <header>
        <h2>Self-care Tracker</h2>
    </header>

    <section class="todays-activities">
        <h3>Today's Self-Care Activities</h3>
        
        <div class="activities-grid">
            <div class="activity-card">
                <div class="activity-icon water">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="activity-details">
                    <h4>Water Intake</h4>
                    <p>Take your daily hydration</p>
                    <span class="progress-text">5/8 glasses</span>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon exercise">
                    <i class="fas fa-running"></i>
                </div>
                <div class="activity-details">
                    <h4>Exercise</h4>
                    <p>30 minutes of physical activity</p>
                </div>
                <div class="checkbox checked">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon meditation">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="activity-details">
                    <h4>Meditation</h4>
                    <p>10 minutes of mindfulness</p>
                </div>
                <div class="checkbox"></div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon sleep">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="activity-details">
                    <h4>Sleep</h4>
                    <p>7 - 8 hours of quality sleep</p>
                </div>
                <div class="checkbox"></div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon meals">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="activity-details">
                    <h4>Healthy meals</h4>
                    <p>Balance nutrition</p>
                </div>
                <div class="checkbox checked">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon reading">
                    <i class="fas fa-book"></i>
                </div>
                <div class="activity-details">
                    <h4>Reading</h4>
                    <p>20 minutes of reading</p>
                </div>
                <div class="checkbox"></div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon skincare">
                    <i class="fas fa-pump-soap"></i>
                </div>
                <div class="activity-details">
                    <h4>Skincare</h4>
                    <p>Morning and evening routine</p>
                </div>
                <div class="checkbox checked">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="activity-icon digital-detox">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="activity-details">
                    <h4>Digital Detox</h4>
                    <p>1 hour away from screens</p>
                </div>
                <div class="checkbox"></div>
            </div>
        </div>
    </section>
    
    <section class="custom-activities">
        <h3>Custom Self-Care Activities</h3>
        <div class="add-activity">
            <input type="text" placeholder="Add new self-care activity">
            <button id="add-activity-btn">Add</button>
        </div>
    </section>
    
    <section class="weekly-progress">
        <h3>Weekly Progress</h3>
        <div class="days">
            <div class="day">
                <span class="day-name">Mon</span>
                <span class="day-score">5/8</span>
            </div>
            <div class="day">
                <span class="day-name">Tue</span>
                <span class="day-score">7/8</span>
            </div>
            <div class="day">
                <span class="day-name">Wed</span>
                <span class="day-score">8/8</span>
            </div>
            <div class="day">
                <span class="day-name">Thu</span>
                <span class="day-score">7/8</span>
            </div>
            <div class="day">
                <span class="day-name">Fri</span>
                <span class="day-score">6/8</span>
            </div>
            <div class="day">
                <span class="day-name">Sat</span>
                <span class="day-score">7/8</span>
            </div>
            <div class="day">
                <span class="day-name">Sun</span>
                <span class="day-score">8/8</span>
            </div>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: 60%;"></div>
        </div>
        <p class="overall-progress">Overall Progress: 60%</p>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/selfcare.js') }}"></script>
@endpush