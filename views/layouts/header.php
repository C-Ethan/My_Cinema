<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCinema</title>
    <link rel="stylesheet" href="/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier/public/css/style.css">
</head>
<body>
    <?php
    $showSidebar = isset($_GET['page']) && ($_GET['page'] === 'movie' || $_GET['page'] === 'member');
    ?>
    <div class="main-container <?= $showSidebar ? 'with-sidebar' : 'no-sidebar' ?>">
        <?php
        if ($showSidebar) {
            require ROOT . '/views/layouts/sidebar.php';
        }
        ?>