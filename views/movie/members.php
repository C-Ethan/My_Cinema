<?php require ROOT . '/views/layouts/header.php'; ?>

<form method="GET" class="search-form">
    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="Search for a user..."
        value="<?= htmlspecialchars($search) ?>">

    <select name="limit" onchange="this.form.submit()">
        <?php foreach ($allowedLimits as $limitOption): ?>
            <option value="<?= $limitOption ?>" <?= $limit == $limitOption ? 'selected' : '' ?>>
                <?= $limitOption ?> per page
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="search-button">Search</button>
</form>

<?php if (!empty($users)): ?>
    <div class="user-grid">
        <?php foreach ($users as $user): ?>
            <div class="user-card">
                <h2 class="user-name"><?= htmlspecialchars($user['name']) ?></h2>
                <h3 class="user-email">Email: <?= htmlspecialchars($user['email']) ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
    <?php require_once ROOT . '/views/components/pagination.php'; ?>
<?php else: ?>
    <p style="text-align: center">No members found in database.</p>
<?php endif; ?>