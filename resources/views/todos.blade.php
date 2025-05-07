<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo App</title>
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <h1>Todo App</h1>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="active"><a href="#"><i>📋</i>Todos</a></li>
                </ul>
            </div>
            <div class="logout">
                <a href="#"><i>🔓</i>Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header><h2>My Tasks</h2></header>
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
