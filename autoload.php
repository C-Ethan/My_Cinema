<?php
define('ROOT', dirname(__DIR__) . '/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier');
define('BASE_URL', '/my_cinema/W-PHP-501-LIL-1-1-mycinema-ethan.carpentier');

require ROOT . '/config/Database.php';

require ROOT . '/controllers/Member.Controller.php';
require ROOT . '/controllers/Movie.Controller.php';

require ROOT . '/models/Distributor.php';
require ROOT . '/models/Genre.php';
require ROOT . '/models/History.php';
require ROOT . '/models/Member.php';
require ROOT . '/models/Movie.php';
require ROOT . '/models/Room.php';
require ROOT . '/models/Subscription.php';