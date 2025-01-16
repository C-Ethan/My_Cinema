<nav class="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">My_Cinema</h1>
    </div>
    <div class="sidebar-menu">
        <a href="?page=movies" class="sidebar-item <?= !isset($_GET['page']) || $_GET['page'] === 'movies' ? 'active' : '' ?>">
            <span class="sidebar-text">Movies</span>
        </a>
        <a href="?page=members" class="sidebar-item <?= isset($_GET['page']) && $_GET['page'] === 'members' ? 'active' : '' ?>">
            <span class="sidebar-text">Members</span>
        </a>
        <a href="?page=sessions" class="sidebar-item <?= isset($_GET['page']) && $_GET['page'] === 'sessions' ? 'active' : '' ?>">
            <span class="sidebar-text">Sessions</span>
        </a>
    </div>
</nav>