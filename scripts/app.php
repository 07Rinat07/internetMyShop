<?php

declare(strict_types=1);

$root = dirname(__DIR__);
chdir($root);

$isWindows = DIRECTORY_SEPARATOR === '\\';
$launcherPhp = PHP_BINARY;
$projectPhp = resolveProjectPhp($launcherPhp, $isWindows);
$npm = $isWindows ? 'npm.cmd' : 'npm';
$docker = 'docker';

$command = $argv[1] ?? 'help';

$commandMap = [
    'help' => [],
    'doctor' => [],
    'deps:install' => [
        ['type' => 'composer', 'args' => ['install']],
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:install']],
    ],
    'local:prepare' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-local-environment.php']),
    ],
    'local:setup' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-local-environment.php']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'key:generate', '--ansi', '--force']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'migrate', '--force', '--no-interaction']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'db:seed', '--force', '--no-interaction']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'storage:link', '--force']),
    ],
    'local:refresh' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-local-environment.php']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'migrate:fresh', '--seed', '--force', '--no-interaction']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'storage:link', '--force']),
    ],
    'local:seed:content' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-local-environment.php']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'db:seed', '--class=Database\\Seeders\\StorefrontSiteContentSeeder', '--force', '--no-interaction']),
    ],
    'local:serve' => [
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'serve', '--host=127.0.0.1', '--port=8000']),
    ],
    'local:clear' => [
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'optimize:clear']),
    ],
    'backend:lint' => [
        ['type' => 'composer', 'args' => ['lint']],
    ],
    'backend:analyse' => [
        projectPhpStep($projectPhp, $isWindows, ['vendor/bin/phpstan', 'analyse', '--memory-limit=1G', '--no-progress']),
    ],
    'backend:test' => [
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'test']),
    ],
    'backend:quality' => [
        ['type' => 'composer', 'args' => ['lint']],
        projectPhpStep($projectPhp, $isWindows, ['vendor/bin/phpstan', 'analyse', '--memory-limit=1G', '--no-progress']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'test']),
    ],
    'docker:prepare' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-docker-environment.php']),
    ],
    'docker:up' => [
        projectPhpStep($projectPhp, $isWindows, ['scripts/prepare-docker-environment.php']),
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'up', '-d', '--build']],
    ],
    'docker:down' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'down']],
    ],
    'docker:logs' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'logs', '-f', 'app']],
    ],
    'docker:migrate' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'exec', 'app', 'php', 'artisan', 'migrate', '--force', '--no-interaction']],
    ],
    'docker:seed' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'exec', 'app', 'php', 'artisan', 'db:seed', '--force', '--no-interaction']],
    ],
    'docker:seed:content' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'exec', 'app', 'php', 'artisan', 'db:seed', '--class=Database\\Seeders\\StorefrontSiteContentSeeder', '--force', '--no-interaction']],
    ],
    'docker:refresh' => [
        ['type' => 'process', 'bin' => $docker, 'args' => ['compose', 'exec', 'app', 'php', 'artisan', 'migrate:fresh', '--seed', '--force', '--no-interaction']],
    ],
    'web:install' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:install']],
    ],
    'web:dev' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:dev']],
    ],
    'web:build' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:build']],
    ],
    'web:lint' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:lint']],
    ],
    'web:typecheck' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:typecheck']],
    ],
    'web:test:unit' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:test:unit']],
    ],
    'web:test:e2e:install' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:test:e2e:install']],
    ],
    'web:test:e2e' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:test:e2e']],
    ],
    'web:quality' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:quality']],
    ],
    'verify:all' => [
        ['type' => 'composer', 'args' => ['lint']],
        projectPhpStep($projectPhp, $isWindows, ['vendor/bin/phpstan', 'analyse', '--memory-limit=1G', '--no-progress']),
        projectPhpStep($projectPhp, $isWindows, ['artisan', 'test']),
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:quality']],
    ],
    'verify:e2e' => [
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:test:e2e:install']],
        ['type' => 'process', 'bin' => $npm, 'args' => ['run', 'web:test:e2e']],
    ],
];

if ($command === 'help') {
    printHelp();
    exit(0);
}

if ($command === 'doctor') {
    $composer = findComposer();

    echo "Project command doctor\n";
    echo "Root: {$root}\n";
    echo "Launcher PHP: {$launcherPhp} (".PHP_VERSION.")\n";
    echo 'Project PHP: '.$projectPhp.' ('.(detectPhpVersion($projectPhp) ?? 'unknown').')'.PHP_EOL;
    echo 'Composer: '.($composer ?? 'not found').PHP_EOL;
    echo "NPM: {$npm}\n";
    echo "Docker: {$docker}\n";
    exit(0);
}

if (! array_key_exists($command, $commandMap)) {
    fwrite(STDERR, "Unknown command: {$command}\n\n");
    printHelp();
    exit(1);
}

foreach ($commandMap[$command] as $step) {
    $exitCode = runStep($step);

    if ($exitCode !== 0) {
        exit($exitCode);
    }
}

exit(0);

function runStep(array $step): int
{
    if ($step['type'] === 'composer') {
        $composer = findComposer();

        if ($composer === null) {
            fwrite(STDERR, "Composer executable was not found.\n");
            fwrite(STDERR, "Use COMPOSER_BIN or install Composer from https://getcomposer.org/.\n");

            return 1;
        }

        $parts = isComposerPhar($composer)
            ? array_merge(resolveProjectPhpParts(resolveProjectPhp(PHP_BINARY, DIRECTORY_SEPARATOR === '\\'), DIRECTORY_SEPARATOR === '\\'), [$composer], $step['args'])
            : array_merge([$composer], $step['args']);

        return runCommand($parts);
    }

    $parts = $step['parts'] ?? array_merge([$step['bin']], $step['args']);

    return runCommand($parts);
}

function runCommand(array $parts): int
{
    $command = buildCommand($parts);
    applyProjectTempEnvironment();

    echo '> '.$command.PHP_EOL;
    passthru($command, $exitCode);
    echo PHP_EOL;

    return (int) $exitCode;
}

function buildCommand(array $parts): string
{
    return implode(' ', array_map(static function (string $part): string {
        return DIRECTORY_SEPARATOR === '\\'
            ? escapeWindowsArgument($part)
            : escapeshellarg($part);
    }, $parts));
}

function escapeWindowsArgument(string $arg): string
{
    if ($arg === '') {
        return '""';
    }

    if (! preg_match('/[\s"]/u', $arg)) {
        return $arg;
    }

    return '"'.str_replace('"', '\"', $arg).'"';
}

function findComposer(): ?string
{
    $fromEnv = getenv('COMPOSER_BIN');

    if (is_string($fromEnv) && $fromEnv !== '') {
        return $fromEnv;
    }

    $candidates = DIRECTORY_SEPARATOR === '\\'
        ? [
            'C:\\ProgramData\\ComposerSetup\\bin\\composer.phar',
            'C:\\ProgramData\\ComposerSetup\\bin\\composer.bat',
            'C:\\ProgramData\\ComposerSetup\\bin\\composer',
            'composer.phar',
            'composer.bat',
            'composer',
        ]
        : [
            'composer.phar',
            'composer',
        ];

    foreach ($candidates as $candidate) {
        if (isExecutableCommand($candidate)) {
            return $candidate;
        }
    }

    return null;
}

function isComposerPhar(string $command): bool
{
    return str_ends_with(strtolower($command), '.phar');
}

function resolveProjectPhp(string $launcherPhp, bool $isWindows): string
{
    $fromEnv = getenv('PROJECT_PHP_BIN');

    if (is_string($fromEnv) && $fromEnv !== '') {
        return $fromEnv;
    }

    if (isPhpVersionSupported(PHP_VERSION)) {
        return $launcherPhp;
    }

    $candidates = $isWindows
        ? [
            'C:\\OSPanel\\modules\\PHP-8.4\\php.exe',
            'php8.4',
            'php84',
            'php',
        ]
        : [
            'php8.4',
            'php84',
            'php',
        ];

    foreach ($candidates as $candidate) {
        if (! isExecutableCommand($candidate)) {
            continue;
        }

        $version = detectPhpVersion($candidate);

        if ($version !== null && isPhpVersionSupported($version)) {
            return $candidate;
        }
    }

    return $launcherPhp;
}

function projectPhpStep(string $projectPhp, bool $isWindows, array $args): array
{
    return [
        'type' => 'process',
        'parts' => array_merge(resolveProjectPhpParts($projectPhp, $isWindows), $args),
    ];
}

function resolveProjectPhpParts(string $projectPhp, bool $isWindows): array
{
    $parts = [$projectPhp];

    if (! $isWindows) {
        return $parts;
    }

    $version = detectPhpVersion($projectPhp);

    if ($version === null || ! isPhpVersionSupported($version)) {
        return $parts;
    }

    $tempDir = ensureProjectPhpTempDir();

    return array_merge($parts, [
        '-d',
        'sys_temp_dir='.$tempDir,
        '-d',
        'upload_tmp_dir='.$tempDir,
    ]);
}

function ensureProjectPhpTempDir(): string
{
    $tempDir = dirname(__DIR__).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'php84';

    if (! is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    return str_replace('\\', '/', $tempDir);
}

function applyProjectTempEnvironment(): void
{
    if (DIRECTORY_SEPARATOR !== '\\') {
        return;
    }

    // PhpStan and other subprocesses on Windows may still use TEMP/TMP even if PHP ini temp dirs are overridden.
    $tempDir = ensureProjectPhpTempDir();

    putenv('TMP='.$tempDir);
    putenv('TEMP='.$tempDir);
    putenv('TMPDIR='.$tempDir);
    $_ENV['TMP'] = $tempDir;
    $_ENV['TEMP'] = $tempDir;
    $_ENV['TMPDIR'] = $tempDir;
}

function detectPhpVersion(string $phpBinary): ?string
{
    $command = buildCommand([$phpBinary, '-r', 'echo PHP_VERSION;']);

    exec($command, $output, $exitCode);

    if ($exitCode !== 0 || $output === []) {
        return null;
    }

    return trim(implode('', $output));
}

function isPhpVersionSupported(string $version): bool
{
    return version_compare($version, '8.4.0', '>=');
}

function isExecutableCommand(string $command): bool
{
    if (str_contains($command, DIRECTORY_SEPARATOR) || preg_match('/^[A-Za-z]:\\\\/', $command) === 1) {
        return file_exists($command);
    }

    $checker = DIRECTORY_SEPARATOR === '\\'
        ? sprintf('where.exe %s >NUL 2>NUL', escapeshellarg($command))
        : sprintf('command -v %s >/dev/null 2>&1', escapeshellarg($command));

    exec($checker, $output, $exitCode);

    return $exitCode === 0;
}

function printHelp(): void
{
    echo <<<'TXT'
Universal project runner

Usage:
  php scripts/app.php <command>

Main commands:
  deps:install
  local:prepare
  local:setup
  local:refresh
  local:seed:content
  local:serve
  local:clear
  backend:lint
  backend:analyse
  backend:test
  backend:quality
  docker:prepare
  docker:up
  docker:down
  docker:logs
  docker:migrate
  docker:seed
  docker:seed:content
  docker:refresh
  web:install
  web:dev
  web:build
  web:lint
  web:typecheck
  web:test:unit
  web:test:e2e:install
  web:test:e2e
  web:quality
  verify:all
  verify:e2e
  doctor

Examples:
  php scripts/app.php deps:install
  php scripts/app.php local:setup
  php scripts/app.php docker:up
  php scripts/app.php docker:logs
  php scripts/app.php verify:all

TXT;
}
