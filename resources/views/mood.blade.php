@extends('layouts.app')

@section('title', 'Mood Tracker')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/mood.css') }}">
@endpush

@section('content')
    <header>
        <h2>Mood Tracker</h2>
    </header>

    <div class="dashboard-grid">
        <!-- Mood Selection Card -->
        <div class="card">
            <div class="mood-selection">
                <h3>How Are You Feeling Today?</h3>
                <div class="mood-icons">
                    <div class="mood-icon" data-mood="excited">
                        <div class="emoji">😄</div>
                        <span>Excited</span>
                    </div>
                    <div class="mood-icon" data-mood="happy">
                        <div class="emoji">🙂</div>
                        <span>Happy</span>
                    </div>
                    <div class="mood-icon" data-mood="good">
                        <div class="emoji">😊</div>
                        <span>Good</span>
                    </div>
                    <div class="mood-icon" data-mood="okay">
                        <div class="emoji">😐</div>
                        <span>Okay</span>
                    </div>
                    <div class="mood-icon" data-mood="sad">
                        <div class="emoji">😞</div>
                        <span>Sad</span>
                    </div>
                    <div class="mood-icon" data-mood="stressed">
                        <div class="emoji">😣</div>
                        <span>Stressed</span>
                    </div>
                    <div class="mood-icon" data-mood="exhausted">
                        <div class="emoji">😩</div>
                        <span>Exhausted</span>
                    </div>
                </div>

                <!-- Diary Entry - HANYA 1 SAJA -->
                <div class="diary-container">
                    <h3>Write in your diary</h3>
                    <form action="{{ route('moods.store') }}" method="POST" id="diary-form">
                        @csrf
                        <input type="hidden" name="mood" id="selected-mood" required>
                        <input type="hidden" name="emoji" id="selected-emoji" required>
                        <textarea name="diary_text" id="diary-text" placeholder="Write about your day and how you're feeling..." required></textarea>
                        <button type="submit" class="save-btn" id="save-btn">Save Entry</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mood History Card -->
        @if($moods->isNotEmpty())
        <div class="card">
            <div class="mood-history">
                <h3>Mood History</h3>
                <div class="history-entries" id="history-container">
                    @foreach ($moods as $mood)
                        <div class="history-entry">
                            <div class="entry-header">
                                <span class="entry-date">{{ $mood->created_at->format('F d, Y') }}</span>
                                <span class="entry-emoji">
                                    @switch($mood->mood)
                                        @case('excited')
                                            😄
                                            @break
                                        @case('happy')
                                            🙂
                                            @break
                                        @case('good')
                                            😊
                                            @break
                                        @case('okay')
                                            😐
                                            @break
                                        @case('sad')
                                            😞
                                            @break
                                        @case('stressed')
                                            😣
                                            @break
                                        @case('exhausted')
                                            😩
                                            @break
                                        @default
                                            😐
                                    @endswitch
                                </span>
                                <div class="entry-actions">
                                    <!-- Edit Button -->
                                    <button type="button" class="entry-edit" data-entry-id="{{ $mood->id }}">Edit</button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('moods.destroy', $mood->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="entry-delete" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div class="entry-content" id="content-{{ $mood->id }}">
                                {{ $mood->diary_text }}
                            </div>
                            
                            <!-- Edit Form (Hidden by default) -->
                            <form action="{{ route('moods.update', $mood->id) }}" method="POST" class="edit-form" id="edit-form-{{ $mood->id }}" style="display: none;">
                                @csrf
                                @method('PUT')
                                <textarea name="diary_text" class="edit-textarea" required>{{ $mood->diary_text }}</textarea>
                                <div class="edit-buttons">
                                    <button type="submit" class="save-edit-btn">Save</button>
                                    <button type="button" class="cancel-edit" data-entry-id="{{ $mood->id }}">Cancel</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/mood.js') }}"></script>
@endpush