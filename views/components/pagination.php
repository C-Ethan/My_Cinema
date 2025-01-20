<?php
// Vérifier si la pagination est nécessaire
if ($totalPages > 1): ?>
    <div class="pagination">
        <?php
        // Construire l'URL de base pour la pagination
        $queryParams = $_GET;
        unset($queryParams['page']); // Retirer le paramètre page existant
        $baseUrl = '?' . http_build_query($queryParams) . '&page=';
        ?>

        <!-- Bouton "Previous" -->
        <?php if ($currentPage > 1): ?>
            <a href="<?= $baseUrl . ($currentPage - 1) ?>" class="pagination-link" aria-label="Page précédente">
                Previous
            </a>
        <?php endif; ?>

        <!-- Sélecteur de page -->
        <form method="get" class="pagination-form">
            <?php foreach ($queryParams as $key => $value): ?>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endforeach; ?>
            
            <select name="page" onchange="this.form.submit()" class="pagination-select" aria-label="Sélectionner une page">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <option value="<?= $i ?>" <?= $i === $currentPage ? 'selected' : '' ?>>
                        Page <?= $i ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>

        <!-- Bouton "Next" -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= $baseUrl . ($currentPage + 1) ?>" class="pagination-link" aria-label="Page suivante">
                Next
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>