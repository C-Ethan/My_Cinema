<?php
class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            $dbname = 'cinema';
            $host = 'localhost';
            $user = 'root';
            $password = '';
            
            try {
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ]
                );
            } catch (PDOException $e) {
                die("La connexion a échoué : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}