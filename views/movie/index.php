<?php require ROOT . '/views/layouts/header.php'; ?>

<form method="GET" class="search-form">
    <select name="search_type" class="search-type">
        <option value="all" <?= $searchType === 'all' ? 'selected' : '' ?>>All</option>
        <option value="title" <?= $searchType === 'title' ? 'selected' : '' ?>>Title</option>
        <option value="director" <?= $searchType === 'director' ? 'selected' : '' ?>>Director</option>
    </select>

    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="Search for a film or director..."
        value="<?= htmlspecialchars($search) ?>">

    <select name="sort" class="genre-select">
        <option value="">All genre</option>
        <?php foreach ($genres as $genre): ?>
            <option value="<?= htmlspecialchars($genre['id']) ?>"
                <?= isset($_GET['sort']) && $_GET['sort'] == $genre['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($genre['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="limit" onchange="this.form.submit()">
        <?php foreach ($allowedLimits as $limitOption): ?>
            <option value="<?= $limitOption ?>" <?= $limit == $limitOption ? 'selected' : '' ?>>
                <?= $limitOption ?> per page
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="search-button">Search</button>
</form>

<?php if (!empty($movies)): ?>
    <div class="movie-grid">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <h2 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h2>
                <h3 class="movie-director">Directed by : <?= htmlspecialchars($movie['director']) ?></h3>
                <h3 class="movie-genre">Genre : <?= htmlspecialchars($movie['genre']) ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
    <?php require_once ROOT . '/views/components/pagination.php'; ?>
<?php else: ?>
    <p style="text-align: center">No movies found in database.</p>
<?php endif; ?>