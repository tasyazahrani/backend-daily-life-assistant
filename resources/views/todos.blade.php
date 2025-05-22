@extends('layouts.app')

@section('title', 'To-Do List')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
@endpush

@section('content')
    <header>
        <h2>To-Do List</h2>
    </header>

    <!-- Card: Today's Tasks -->
    <div class="dashboard-grid">
        <div class="card">
            
            <!-- Form tambah task -->
            <div class="add-task-container" style="margin-bottom: 1rem;">
                <form action="/todos" method="POST" style="display: flex; width: 100%; gap: 10px;">
                    @csrf
                    <input type="text" name="task" placeholder="Add a new task..." required>
                    <button type="submit" class="add-btn">Add</button>
                </form>
            </div>

            <!-- Daftar task -->
            <div class="task-list">
                @forelse ($todos as $todo)
                    <div class="task-item {{ $todo->is_completed ? 'completed' : '' }}">
                        <div class="task-left">
                            <!-- Checkbox toggle -->
                            <form action="/todos/{{ $todo->id }}/toggle" method="POST">
                                @csrf
                                <button type="submit" class="checkbox {{ $todo->is_completed ? 'checked' : '' }}">
                                    @if($todo->is_completed)
                                        <i class="fas fa-check"></i>
                                    @endif
                                </button>
                            </form>
                            <span class="task-text">{{ $todo->task }}</span>
                        </div>

                        <div class="task-right">
                            <span class="task-date">{{ $todo->created_at->format('d M Y') }}</span>

                            <!-- Edit task -->
                            <form action="/todos/{{ $todo->id }}/update" method="POST" style="display:inline;">
                                @csrf
                                <input type="text" name="task" value="{{ $todo->task }}" style="display:none;" class="edit-input">
                                <button type="submit" class="task-edit">Edit</button>
                            </form>

                            <!-- Delete -->
                            <form action="/todos/{{ $todo->id }}/delete" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="task-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No tasks yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.task-edit').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const input = form.querySelector('.edit-input');
            if (input.style.display === 'none') {
                input.style.display = 'inline-block';
                input.focus();
                this.textContent = 'Save';
            } else {
                form.submit();
            }
        });
    });
</script>
@endpush
