<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Life Assistant - To-Do List</title>
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
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
                <li><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="active"><a href="/todos"><i class="fas fa-list-check"></i> To-Do List</a></li>
                <li><a href="#"><i class="fas fa-face-smile"></i> Mood Tracker</a></li>
                <li><a href="#"><i class="fas fa-wallet"></i> Financial Tracker</a></li>
                <li><a href="#"><i class="fas fa-quote-left"></i> Daily Quote</a></li>
                <li><a href="#"><i class="fas fa-heart"></i> Self-Care</a></li>
                <li><a href="#"><i class="fas fa-user"></i> Profil</a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="/"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>To-Do List</h2>
        </header>

        <!-- Add Task Form -->
        <div class="add-task-container">
            <form action="/todos" method="POST" style="display: flex; width: 100%; gap: 10px;">
                @csrf
                <input type="text" name="task" placeholder="Add a new task..." required>
                <button type="submit" class="add-btn">Add</button>
            </form>
        </div>

        <!-- Tasks List -->
        <div class="tasks-container">
            @foreach ($todos as $todo)
                <div class="task-item {{ $todo->is_completed ? 'completed' : '' }}">
                    <div class="task-left">
                        <!-- Checkbox -->
                        <form action="/todos/{{ $todo->id }}/toggle" method="POST">
                            @csrf
                            <button type="submit" class="checkbox {{ $todo->is_completed ? 'checked' : '' }}">
                                @if($todo->is_completed)
                                    <i class="fas fa-check"></i>
                                @endif
                            </button>
                        </form>
                        <!-- Task text -->
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
            @endforeach
        </div>
    </div>
</div>

<script>
    // Optional: Toggle edit input visibility
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

</body>
</html>