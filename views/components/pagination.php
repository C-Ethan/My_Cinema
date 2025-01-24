<div class="pagination">
    <?php
    $queryParams = $_GET;
    unset($queryParams['page']);
    $baseUrl = '?' . http_build_query($queryParams) . '&page=';
    ?>

    <?php if ($currentPage > 1): ?>
        <a href="<?= $baseUrl . ($currentPage - 1) ?>" class="pagination-link">Previous</a>
    <?php endif; ?>

    <form method="get" style="display: inline;">
        <?php foreach ($queryParams as $key => $value): ?>
            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
        <?php endforeach; ?>
        
        <select name="page" onchange="this.form.submit()" class="pagination-select">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <option value="<?= $i ?>" <?= $i === $currentPage ? 'selected' : '' ?>>
                    Page <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
    </form>

    <?php if ($currentPage < $totalPages): ?>
        <a href="<?= $baseUrl . ($currentPage + 1) ?>" class="pagination-link">Next</a>
    <?php endif; ?>
</div>