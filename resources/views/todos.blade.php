<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                    <li><a href="/page/user/dashboard.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="active"><a href="todo.html"><i class="fas fa-list-check"></i> To-Do List</a></li>
                    <li><a href="/page/user/mood.html"><i class="fas fa-face-smile"></i> Mood Tracker</a></li>
                    <li><a href="/page/user/financial.html"><i class="fas fa-wallet"></i> Financial Tracker</a></li>
                    <li><a href="/page/user/daily.html"><i class="fas fa-quote-left"></i> Daily Quote</a></li>
                    <li><a href="/page/user/selfcare.html"><i class="fas fa-heart"></i> Self-Care</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="/Landingpage.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header><h2>To-Do List</h2></header>
            <div class="add-task-container">
                <input type="text" id="task-input" placeholder="New task">
                <button class="add-btn" onclick="addTask()">Add</button>
            </div>
            <div class="tasks-container" id="tasks-container">
                <!-- Task items will be injected here -->
            </div>
        </div>
    </div>

    <script>
        async function fetchTasks() {
            const response = await fetch('/api/todos');
            const tasks = await response.json();
            const container = document.getElementById('tasks-container');
            container.innerHTML = '';
            tasks.forEach(task => {
                const taskEl = document.createElement('div');
                taskEl.className = 'task-item';
                taskEl.innerHTML = `
                    <div class="task-left">
                        <div class="checkbox ${task.completed ? 'checked' : ''}"></div>
                        <div class="task-text">${task.task}</div>
                    </div>
                    <div class="task-right">
                        <span class="task-date">${task.date}</span>
                    </div>
                `;
                container.appendChild(taskEl);
            });
        }

        async function addTask() {
            const task = document.getElementById('task-input').value;
            if (!task) return;

            await fetch('/api/todos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ task, date: "Today" })
            });

            document.getElementById('task-input').value = '';
            fetchTasks();
        }

        document.addEventListener('DOMContentLoaded', fetchTasks);
    </script>
</body>
</html>