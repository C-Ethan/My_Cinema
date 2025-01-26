<?php
require __DIR__ . '/autoload.php';
require ROOT . '/views/layouts/header.php';
require ROOT . '/views/layouts/sidebar.php';

$controller = new MemberController();
$controller->index();