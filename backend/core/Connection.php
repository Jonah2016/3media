<?php

// Globals are declared in Config.php file
require ROOT_PATH.'/vendor/autoload.php';

// Get db params from .env file
$dotenv =  Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

class DB_CONN
{
    public function connect()
    {
        try {
            // Set Database Parameters from .env file
            $DATABASE_HOST = $_ENV['DATABASE_HOST'];
            $DATABASE_USER = $_ENV['DATABASE_USER'];
            $DATABASE_PASS = $_ENV['DATABASE_PASS'];
            $DATABASE_NAME = $_ENV['DATABASE_NAME'];

            $db_connect = new PDO("mysql:host={$DATABASE_HOST};dbname={$DATABASE_NAME}", $DATABASE_USER, $DATABASE_PASS);
            $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db_connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $db_connect;
        } catch (PDOException $e) {
            echo '<h3 align="center">ERROR E001: CONNECTION_TO_SERVER_FAILED.</h3>';
            die();
        }
    }
}
