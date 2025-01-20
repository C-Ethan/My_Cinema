<div class="pagination">
    <?php
    // Construire l'URL de base pour la pagination
    $queryParams = $_GET;
    unset($queryParams['page']); // Retirer le paramètre page existant
    $baseUrl = '?' . http_build_query($queryParams) . '&page=';
    ?>

    <?php if ($currentPage > 1): ?>
        <a href="<?= $baseUrl . ($currentPage - 1) ?>" class="pagination-link">Previous</a>
    <?php endif; ?>

    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
        <a href="<?= $baseUrl . $i ?>" 
           class="pagination-link <?= $i === $currentPage ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="<?= $baseUrl . ($currentPage + 1) ?>" class="pagination-link">Next</a>
    <?php endif; ?>
</div>