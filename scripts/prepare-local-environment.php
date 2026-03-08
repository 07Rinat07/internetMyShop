<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$envPath = $root.'/.env';
$envExamplePath = $root.'/.env.example';
$sqlitePath = $root.'/database/database.sqlite';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);
    fwrite(STDOUT, "Created .env from .env.example.\n");
}

$databaseDirectory = dirname($sqlitePath);

if (! is_dir($databaseDirectory)) {
    mkdir($databaseDirectory, 0777, true);
}

if (! file_exists($sqlitePath)) {
    touch($sqlitePath);
    fwrite(STDOUT, "Created database/database.sqlite.\n");
}

fwrite(STDOUT, "Local environment is ready.\n");
