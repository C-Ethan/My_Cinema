<form method="GET" class="search-form">
        <div class="select-container">
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
                name="movieSearch"
                class="search-input"
                placeholder="Search by movie..."
                value="<?= htmlspecialchars($movieSearch ?? '') ?>">

            <input
                type="text"
                name="directorSearch"
                class="search-input"
                placeholder="Search by director..."
                value="<?= htmlspecialchars($directorSearch ?? '') ?>">

            <button type="submit" class="search-button">Search</button>
        </div>
    </form>

    <?php if (!empty($movies)): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Director</th>
                    <th>Genre</th>
                    <th>Distributor</th>
                    <th>Release date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['title']) ?></td>
                        <td><?= htmlspecialchars($movie['director']) ?></td>
                        <td><?= htmlspecialchars($movie['genre']) ?></td>
                        <td><?= htmlspecialchars($movie['distributor_name']) ?></td>
                        <td>
                            <?php if (!empty($movie['release_date'])): ?>
                                <?= htmlspecialchars((new DateTime($movie['release_date']))->format('d F Y')) ?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="button session" data-movie-id="<?= htmlspecialchars($movie['id']) ?>">Sessions</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <?php require ROOT . '/views/components/pagination.php'; ?>
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

    <?php require __DIR__ . '/components/modals.php'; ?>
    <script src="<?= BASE_URL ?>/public/js/movie.js"></script>