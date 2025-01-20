<?php
// Déterminer la page actuelle en fonction du nom du fichier
$currentPage = basename($_SERVER['PHP_SELF']); // Retourne le nom du fichier actuel (ex: "index.php", "movie.php")
?>

<nav class="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">My_Cinema</h1>
    </div>
    <div class="sidebar-menu">
        <!-- Lien vers la page d'accueil -->
        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/" class="sidebar-item <?= ($currentPage === 'index.php' || $currentPage === '') ? 'active' : '' ?>">
            <span class="sidebar-text">Accueil</span>
        </a>

        <!-- Lien vers la page des films -->
        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/movie.php" class="sidebar-item <?= ($currentPage === 'movie.php') ? 'active' : '' ?>">
            <span class="sidebar-text">Films</span>
        </a>

        <!-- Lien vers la page des membres -->
        <a href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/member.php" class="sidebar-item <?= ($currentPage === 'member.php') ? 'active' : '' ?>">
            <span class="sidebar-text">Membres</span>
        </a>
    </div>
</nav>