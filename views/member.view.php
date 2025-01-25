<form method="GET" class="search-form">
    <div class="search-bar">
        <input
            type="text"
            name="lastnameSearch"
            class="search-input"
            placeholder="Search by last name..."
            value="<?= htmlspecialchars($lastnameSearch ?? '') ?>">

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
        <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Subscription</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member['lastname']) ?></td>
                    <td><?= htmlspecialchars($member['firstname']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td>
                        <?= !empty($member['subscriptions']) ? htmlspecialchars($member['subscriptions']) : 'No subscriptions' ?>
                    </td>
                    <td>
                        <button class="button subscription" data-user-id="<?= $member['id'] ?>">Subscription</button>
                        <button class="button history" data-user-id="<?= $member['id'] ?>">History</button>
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
    <p style="text-align: center">No members found in database.</p>
<?php endif; ?>

<?php require __DIR__ . '/components/modals.php'; ?>  