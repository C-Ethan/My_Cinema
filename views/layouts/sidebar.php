<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">My_Cinema</h1>
    </div>
    <div class="sidebar-menu">
        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/" class="sidebar-item <?= ($currentPage === 'index.php' || $currentPage === '') ? 'active' : '' ?>">
            <span class="sidebar-text">Home</span>
        </a>

        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/movie.php" class="sidebar-item <?= ($currentPage === 'movie.php') ? 'active' : '' ?>">
            <span class="sidebar-text">Movies</span>
        </a>

        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/member.php" class="sidebar-item <?= ($currentPage === 'member.php') ? 'active' : '' ?>">
            <span class="sidebar-text">Members</span>
        </a>
    </div>
</nav>