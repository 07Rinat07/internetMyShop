<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$envPath = $root.'/.env.docker';
$envExamplePath = $root.'/.env.docker.example';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);
    fwrite(STDOUT, "Created .env.docker from .env.docker.example.\n");
}

fwrite(STDOUT, "Docker environment is ready.\n");
