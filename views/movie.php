<?php 
require ROOT . '/views/layouts/header.php';

$controller = new MovieController();
$controller->index();
?>

<form method="GET" class="search-form">
    <div class="select-container">
        <select name="search_type" class="search-type">
            <option value="all" <?= $searchType === 'all' ? 'selected' : '' ?>>All</option>
            <option value="title" <?= $searchType === 'title' ? 'selected' : '' ?>>Title</option>
            <option value="director" <?= $searchType === 'director' ? 'selected' : '' ?>>Director</option>
        </select>

        <select name="genre" class="genre-select">
            <option value="">All genres</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= htmlspecialchars($genre['id']) ?>"
                    <?= isset($_GET['genre']) && $_GET['genre'] == $genre['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="distributor" class="distributor-select">
            <option value="">All distributors</option>
            <?php foreach ($distributors as $distributor): ?>
                <option value="<?= htmlspecialchars($distributor['id']) ?>"
                    <?= isset($_GET['distributor']) && $_GET['distributor'] == $distributor['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($distributor['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="search-bar">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search for a film or director..."
            value="<?= htmlspecialchars($search) ?>">

        <button type="submit" class="search-button">Search</button>
    </div>
</form>

<?php if (!empty($movies)): ?>
    <table>
        <!-- En-tête de la table -->
        <thead>
            <tr>
                <th>Title</th>
                <th>Director</th>
                <th>Genre</th>
                <th>Distributor</th>
                <th>Release Date</th>
                <th>Actions</th> <!-- Nouvelle colonne pour les boutons -->
            </tr>
        </thead>

        <!-- Corps de la table -->
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= htmlspecialchars($movie['title']) ?></td>
                    <td><?= htmlspecialchars($movie['director']) ?></td>
                    <td><?= htmlspecialchars($movie['genre']) ?></td>
                    <td><?= htmlspecialchars($movie['distributor_name']) ?></td>
                    <td><?= htmlspecialchars((new DateTime($movie['release_date']))->format('d F Y')) ?></td>
                    <td>
                        <a href="#" class="button add">Ajouter</a>
                        <a href="#" class="button delete">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination-container">
        <?php require_once ROOT . '/views/components/pagination.php'; ?>
        <form method="get">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if ($key !== 'limit'): ?>
                    <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>

            <select name="limit" onchange="this.form.submit()">
                <?php foreach ($allowedLimits as $limitOption): ?>
                    <option value="<?= $limitOption ?>" <?= $limit == $limitOption ? 'selected' : '' ?>>
                        <?= $limitOption ?> per page
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
<?php else: ?>
    <p style="text-align: center">No movies found in database.</p>
<?php endif; ?>