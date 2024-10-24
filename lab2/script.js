class Todo {
    constructor() {
        this.tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        this.originalTasks = [...this.tasks];
        this.draw();
        document.getElementById('add_button').addEventListener('click', () => this.add_todo());
        document.getElementById('search').addEventListener('input', () => this.search_todo());
    }

    draw(tasks = this.tasks, search = false) {
        const taskList = document.getElementById('taskList');
        taskList.innerHTML = '';

        tasks.forEach((task, index) => {
            const taskItem = this.create_todo(task, index, search);
            taskList.appendChild(taskItem);
        });

        localStorage.setItem('tasks', JSON.stringify(this.tasks));
    }

    create_todo(task, index, isSearchMode = false) {
        const toDo = document.createElement('div');
        toDo.classList.add('task-item');

        const todo_checkbox = document.createElement('input');
        todo_checkbox.type = 'checkbox';
        todo_checkbox.checked = task.completed;
        todo_checkbox.onchange = () => this.checked_todo(index);

        const todo_name_text = document.createElement('span');
        todo_name_text.classList.add('task-name');
        todo_name_text.innerHTML = task.name;
        if (task.completed) {
            todo_name_text.style.textDecoration = 'line-through';
        }
        if (isSearchMode) {
            const query = document.getElementById('search').value.trim().toLowerCase();
            const regex = new RegExp(`(${query})`, 'gi');
            todo_name_text.innerHTML = task.name.replace(regex, '<span class="highlight">$1</span>');
        }

        todo_name_text.onclick = () => {
            const todo_name_input = document.createElement('input');
            todo_name_input.type = 'text';
            todo_name_input.value = task.name;
            todo_name_input.onblur = () => {
                const newName = todo_name_input.value.trim();
                if (newName.length >= 3 && newName.length <= 150) {
                    this.edit_todo_name(index, newName);
                    todo_name_text.innerHTML = newName;
                } else {
                    alert('Task length should be between 3 and 150.');
                }
                todo_name_input.remove();
                todo_name_text.style.display = 'block';
            };

            todo_name_text.style.display = 'none';
            toDo.insertBefore(todo_name_input, todo_name_text.nextSibling);
            todo_name_input.focus();
        };

        const todo_deadline_text = document.createElement('span');
        todo_deadline_text.classList.add('task-deadline');

        if (task.deadline) {
            todo_deadline_text.innerHTML = new Date(task.deadline).toLocaleString();
        } else {
            todo_deadline_text.innerHTML = 'No deadline';
            todo_deadline_text.style.display = 'none';
        }

        todo_deadline_text.onclick = () => {
            const todo_deadline_input = document.createElement('input');
            todo_deadline_input.type = 'datetime-local';
            todo_deadline_input.value = task.deadline;
            todo_deadline_input.onblur = () => {
                const newDeadline = todo_deadline_input.value;
                if (newDeadline && new Date(newDeadline) <= new Date()) {
                    alert("You can't go back to your past");
                    todo_deadline_text.style.display = 'block';
                    todo_deadline_input.remove();
                    return;
                }

                this.edit_todo_deadline(index, newDeadline);
                todo_deadline_text.innerHTML = newDeadline ? new Date(newDeadline).toLocaleString() : 'No deadline';
                todo_deadline_input.remove();
                todo_deadline_text.style.display = 'block';
            };
            todo_deadline_text.style.display = 'none';
            toDo.insertBefore(todo_deadline_input, todo_deadline_text.nextSibling);
            todo_deadline_input.focus();
        };

        const delete_button = document.createElement('button');
        delete_button.innerText = 'Delete';
        delete_button.onclick = () => this.delete_todo(index);

        toDo.appendChild(todo_checkbox);
        toDo.appendChild(todo_name_text);
        if (task.deadline) toDo.appendChild(todo_deadline_text);
        toDo.appendChild(delete_button);

        return toDo;
    }

    add_todo() {
        const todo_input = document.getElementById('todo_input').value.trim();
        const todo_deadline = document.getElementById('todo_deadline').value;

        if (todo_input.length < 3 || todo_input.length > 150) {
            alert('Task length should be between 3 and 150.');
            return;
        }

        const now = new Date();
        const deadline = new Date(todo_deadline);

        if (todo_deadline && deadline <= now) {
            alert("You can't go back to your past");
            return;
        }

        this.tasks.push({ name: todo_input, deadline: todo_deadline, completed: false });
        this.originalTasks = [...this.tasks];
        document.getElementById('todo_input').value = '';
        document.getElementById('todo_deadline').value = '';
        this.draw();
    }

    edit_todo_name(index, newName) {
        this.tasks[index].name = newName;
        this.originalTasks = [...this.tasks];
        this.draw();
    }

    edit_todo_deadline(index, newDeadline) {
        const now = new Date();
        const deadline = new Date(newDeadline);

        if (newDeadline && deadline <= now) {
            alert("You can't go back to your past");
            return;
        }

        this.tasks[index].deadline = newDeadline;
        this.originalTasks = [...this.tasks];
        this.draw();
    }

    delete_todo(index) {
        this.tasks.splice(index, 1);
        this.originalTasks = [...this.tasks];
        this.draw();
    }

    checked_todo(index) {
        this.tasks[index].completed = !this.tasks[index].completed;
        this.originalTasks = [...this.tasks];
        this.draw();
    }

    search_todo() {
        const query = document.getElementById('search').value.trim().toLowerCase();

        if (query.length < 2) {
            this.draw(this.originalTasks);
            return;
        }

        const filtered_todo = this.originalTasks.filter(task => task.name.toLowerCase().includes(query));
        this.draw(filtered_todo, true);
    }
}

const todo = new Todo();
