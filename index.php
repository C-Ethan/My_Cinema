<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/autoload.php';
require ROOT . '/views/layouts/header.php';
?>

<div class="main-container no-sidebar">
    <div class="content home-page">
        <div class="home-container">
            <h1 class="home-title">Bienvenue sur MyCinema</h1>
            <p class="home-description">Découvrez notre collection de films et gérez les membres de votre cinéma.</p>

            <div class="home-buttons">
                <a href="./movie.php" class="home-button">
                    <span>Voir les films</span>
                </a>

                <a href="./member.php" class="home-button">
                    <span>Voir les membres</span>
                </a>
            </div>
        </div>
    </div>
</div>