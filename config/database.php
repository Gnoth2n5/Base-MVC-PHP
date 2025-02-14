<?php

require_once 'vendor/autoload.php';

use Core\BaseModel;

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

// Kết nối CSDL
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// Thiết lập kết nối cho BaseModel
BaseModel::setConnection($pdo);
