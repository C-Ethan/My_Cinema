<?php
require __DIR__ . '/autoload.php';
require ROOT . '/views/layouts/header.php';
?>

<div class="main-container no-sidebar">
    <div class="content home-page">
        <div class="home-container">
            <h1 class="home-title">Welcome to MyCinema</h1>
            <p class="home-description">Discover our collection of films and manage your cinema members.</p>

            <div class="home-buttons">
                <a href="./movie.php" class="home-button">
                    <span>See the films</span>
                </a>

                <a href="./member.php" class="home-button">
                    <span>See the members</span>
                </a>
            </div>
        </div>
    </div>
</div>