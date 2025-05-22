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
                <form action="/moods" method="POST" id="mood-form">
                    @csrf
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
                    <input type="hidden" name="mood" id="selected-mood" required>
                </form>
            </div>

            <!-- Diary Entry -->
            <div class="diary-container">
                <h3>Write in your diary</h3>
                <form action="/moods" method="POST" id="diary-form">
                    @csrf
                    <input type="hidden" name="mood" id="diary-mood" required>
                    <textarea name="diary_text" id="diary-text" placeholder="Write about your day and how you're feeling..." required></textarea>
                    <button type="submit" class="save-btn">Save Entry</button>
                </form>
            </div>
        </div>

        <!-- Mood History Card -->
        <div class="card">
            <div class="mood-history">
                <h3>Mood History</h3>
                <div class="history-entries" id="history-container">
                    @forelse ($moods as $mood)
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
                                    <!-- Edit Entry -->
                                    <form action="/moods/{{ $mood->id }}/update" method="POST" style="display:inline;">
                                        @csrf
                                        <textarea name="diary_text" style="display:none;" class="edit-textarea">{{ $mood->diary_text }}</textarea>
                                        <input type="hidden" name="mood" value="{{ $mood->mood }}">
                                        <button type="submit" class="entry-edit">Edit</button>
                                    </form>

                                    <!-- Delete Entry -->
                                    <form action="/moods/{{ $mood->id }}/delete" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="entry-delete" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div class="entry-content">
                                {{ $mood->diary_text }}
                            </div>
                        </div>
                    @empty
                        <div class="no-entries">
                            <p>No mood entries yet. Start tracking your mood today!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let selectedMood = '';

    // Handle mood selection
    document.querySelectorAll('.mood-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            // Remove active class from all icons
            document.querySelectorAll('.mood-icon').forEach(i => i.classList.remove('active'));
            
            // Add active class to clicked icon
            this.classList.add('active');
            
            // Store selected mood
            selectedMood = this.dataset.mood;
            document.getElementById('selected-mood').value = selectedMood;
            document.getElementById('diary-mood').value = selectedMood;
        });
    });

    // Handle diary form submission
    document.getElementById('diary-form').addEventListener('submit', function(e) {
        if (!selectedMood) {
            e.preventDefault();
            alert('Please select a mood first!');
            return;
        }
    });

    // Handle edit functionality
    document.querySelectorAll('.entry-edit').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const textarea = form.querySelector('.edit-textarea');
            const entryContent = this.closest('.history-entry').querySelector('.entry-content');
            
            if (textarea.style.display === 'none') {
                // Show edit mode
                textarea.style.display = 'block';
                textarea.style.width = '100%';
                textarea.style.minHeight = '100px';
                textarea.focus();
                entryContent.style.display = 'none';
                this.textContent = 'Save';
            } else {
                // Submit the form
                form.submit();
            }
        });
    });
</script>
@endpush