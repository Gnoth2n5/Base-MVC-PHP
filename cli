<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;

// Create a new application
$app = new Application();

// Register commands

$commadsDir = __DIR__ . '/app/Console/Commands';
foreach (scandir($commadsDir) as $file) {
    if (is_file($commadsDir . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
        $className = 'App\\Console\\Commands\\' . pathinfo($file, PATHINFO_FILENAME);
        if(class_exists($className)){
            $app->add(new $className());
        }
    }
}

// Run the application
$app->run();