<?php
// Récupérer les variables depuis $data
$movies = $data['movies'];
$genres = $data['genres'];
$distributors = $data['distributors'];
$search = $data['search'];
$searchType = $data['searchType'];
$currentPage = $data['currentPage'];
$totalPages = $data['totalPages'];
$limit = $data['limit'];
$allowedLimits = $data['allowedLimits'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCinema - Films</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <h1>Liste des films</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" class="search-form">
        <div class="select-container">
            <select name="search_type" class="search-type">
                <option value="all" <?= $searchType === 'all' ? 'selected' : '' ?>>Tout</option>
                <option value="title" <?= $searchType === 'title' ? 'selected' : '' ?>>Titre</option>
                <option value="director" <?= $searchType === 'director' ? 'selected' : '' ?>>Réalisateur</option>
            </select>

            <select name="genre" class="genre-select">
                <option value="">Tous les genres</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre['id']) ?>"
                        <?= isset($_GET['genre']) && $_GET['genre'] == $genre['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="distributor" class="distributor-select">
                <option value="">Tous les distributeurs</option>
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
                placeholder="Rechercher un film ou un réalisateur..."
                value="<?= htmlspecialchars($search) ?>">

            <button type="submit" class="search-button">Rechercher</button>
        </div>
    </form>

    <!-- Affichage des films -->
    <?php if (!empty($movies)): ?>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Réalisateur</th>
                    <th>Genre</th>
                    <th>Distributeur</th>
                    <th>Date de sortie</th>
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
                            <a href="#" class="button add">Ajouter</a>
                            <a href="#" class="button delete">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-container">
            <?php if ($totalPages > 1): ?>
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

            <!-- Sélecteur de limite (nombre de résultats par page) -->
            <form method="get">
                <?php foreach ($_GET as $key => $value): ?>
                    <?php if ($key !== 'limit'): ?>
                        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>

                <select name="limit" onchange="this.form.submit()">
                    <?php foreach ($allowedLimits as $limitOption): ?>
                        <option value="<?= $limitOption ?>" <?= $limit == $limitOption ? 'selected' : '' ?>>
                            <?= $limitOption ?> par page
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
    <?php else: ?>
        <p style="text-align: center">Aucun film trouvé.</p>
    <?php endif; ?>
</body>
</html>