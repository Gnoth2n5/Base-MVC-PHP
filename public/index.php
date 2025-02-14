<?php
// Index file
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ .'/../config/app.php';
date_default_timezone_set($_ENV['TIMEZONE']);
require_once __DIR__ . '/../config/database.php';
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__."/../routes/web.php";