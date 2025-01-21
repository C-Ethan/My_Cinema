<form method="GET" class="search-form">
    <div class="search-bar">
        <!-- Barre de recherche pour lastname -->
        <input
            type="text"
            name="lastnameSearch"
            class="search-input"
            placeholder="Search by last name..."
            value="<?= htmlspecialchars($lastnameSearch ?? '') ?>">

        <!-- Barre de recherche pour firstname -->
        <input
            type="text"
            name="firstnameSearch"
            class="search-input"
            placeholder="Search by first name..."
            value="<?= htmlspecialchars($firstnameSearch ?? '') ?>">

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
                <th>Actions</th>
            </tr>
        </thead>

        <!-- Corps de la table -->
        <tbody>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member['lastname']) ?></td>
                    <td><?= htmlspecialchars($member['firstname']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= htmlspecialchars($member['subscription']) ?></td>
                    <td>
                        <a href="#" class="button subscription">Subscription</a>
                        <a href="#" class="button history">History</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
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
    <p style="text-align: center">No members found in database.</p>
<?php endif; ?>