<form method="GET" class="search-form">
    <div class="select-container">
        <select name="search_type" class="search-type">
            <option value="all" <?= $searchType === 'all' ? 'selected' : '' ?>>All</option>
            <option value="lastname" <?= $searchType === 'lastname' ? 'selected' : '' ?>>Name</option>
            <option value="email" <?= $searchType === 'email' ? 'selected' : '' ?>>Email</option>
        </select>
    </div>
    <div class="search-bar">
        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search for a member..."
            value="<?= htmlspecialchars($search) ?>">

        <button type="submit" class="search-button">Search</button>
    </div>
</form>

<?php if (!empty($members)): ?>
    <table>
        <!-- En-tête de la table -->
        <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Actions</th> <!-- Nouvelle colonne pour les boutons -->
            </tr>
        </thead>

        <!-- Corps de la table -->
        <tbody>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member['lastname']) ?></td>
                    <td><?= htmlspecialchars($member['firstname']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
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
    <p style="text-align: center">No members found in database.</p>
<?php endif; ?>