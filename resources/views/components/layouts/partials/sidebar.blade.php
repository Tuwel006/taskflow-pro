<div class="bg-dark text-white p-3" style="width: 250px;">
    <h4>Task Manager</h4>

    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link text-white">Dashboard</a>
        </li>

        <li class="nav-item">
            <a 
                href="/tasks" 
                class="nav-link text-white {{ request()->is('tasks') ? 'fw-bold' : '' }}"
            >
                Tasks
            </a>
        </li>
    </ul>
</div>