<nav class="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-title">My_Cinema</h1>
    </div>
    <div class="sidebar-menu">
        <!-- Lien vers la page d'accueil -->
        <a href="?page=home" class="sidebar-item <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : '' ?>">
            <span class="sidebar-text">Accueil</span>
        </a>

        <!-- Lien vers la page des films -->
        <a href="?page=movie" class="sidebar-item <?= (isset($_GET['page']) && $_GET['page'] === 'movie') ? 'active' : '' ?>">
            <span class="sidebar-text">Films</span>
        </a>

        <!-- Lien vers la page des membres -->
        <a href="?page=member" class="sidebar-item <?= (isset($_GET['page']) && $_GET['page'] === 'member') ? 'active' : '' ?>">
            <span class="sidebar-text">Membres</span>
        </a>
    </div>
</nav>