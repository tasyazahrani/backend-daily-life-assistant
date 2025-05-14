document.addEventListener('DOMContentLoaded', function () {
    const newTaskInput = document.getElementById('new-task');
    const addTaskBtn = document.getElementById('add-task-btn');
    const tasksContainer = document.getElementById('tasks');

    // Ambil semua task dari backend Laravel
    fetch('/api/todos')
        .then(res => res.json())
        .then(todos => {
            todos.forEach(todo => renderTask(todo));
        });

    // Tambah task baru
    addTaskBtn.addEventListener('click', function () {
        const taskText = newTaskInput.value.trim();
        if (taskText === '') return alert('Please enter a task!');

        fetch('/api/todos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ task: taskText })
        })
        .then(res => res.json())
        .then(todo => {
            renderTask(todo);
            newTaskInput.value = '';
        });
    });

    function renderTask(todo) {
        const taskItem = document.createElement('div');
        taskItem.className = 'task-item';
        if (todo.is_completed) taskItem.classList.add('completed');
        taskItem.dataset.id = todo.id;

        taskItem.innerHTML = `
            <div class="task-left">
                <div class="checkbox ${todo.is_completed ? 'checked' : ''}">
                    ${todo.is_completed ? '<i class="fas fa-check"></i>' : ''}
                </div>
                <span class="task-text">${todo.task}</span>
            </div>
            <div class="task-right">
                <span class="task-date">Today</span>
                <button class="task-edit">Edit</button>
                <button class="task-delete">Delete</button>
            </div>
        `;

        tasksContainer.appendChild(taskItem);
        addTaskEventListeners(taskItem);
    }

    function addTaskEventListeners(taskItem) {
        const checkbox = taskItem.querySelector('.checkbox');
        const deleteBtn = taskItem.querySelector('.task-delete');
        const editBtn = taskItem.querySelector('.task-edit');

        checkbox.addEventListener('click', function () {
            this.classList.toggle('checked');
            const isDone = this.classList.contains('checked');
            this.innerHTML = isDone ? '<i class="fas fa-check"></i>' : '';
            taskItem.classList.toggle('completed');

            const id = taskItem.dataset.id;
            fetch(`/api/todos/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ is_completed: isDone })
            });
        });

        deleteBtn.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete this task?')) {
                const id = taskItem.dataset.id;
                fetch(`/api/todos/${id}`, { method: 'DELETE' })
                    .then(() => taskItem.remove());
            }
        });

        editBtn.addEventListener('click', function () {
            const taskText = taskItem.querySelector('.task-text');
            const newText = prompt('Edit task:', taskText.textContent);

            if (newText !== null && newText.trim() !== '') {
                taskText.textContent = newText.trim();
                const id = taskItem.dataset.id;
                fetch(`/api/todos/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ task: newText.trim() })
                });
            }
        });
    }
});