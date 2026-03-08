$ErrorActionPreference = 'Stop'

$projectRoot = Resolve-Path (Join-Path $PSScriptRoot '..\..\..')
$phpBinary = if ($env:PLAYWRIGHT_PHP_BINARY) { $env:PLAYWRIGHT_PHP_BINARY } else { 'C:\OSPanel\modules\PHP-8.4\php.exe' }
$databasePath = Join-Path $projectRoot 'database\playwright.sqlite'

Set-Location $projectRoot

if (-not (Test-Path $databasePath)) {
    New-Item -ItemType File -Path $databasePath -Force | Out-Null
}

& $phpBinary artisan config:clear
if ($LASTEXITCODE -ne 0) {
    exit $LASTEXITCODE
}

& $phpBinary artisan migrate:fresh --force --seed --seeder=App\Seeders\E2eDemoSeeder
if ($LASTEXITCODE -ne 0) {
    exit $LASTEXITCODE
}

& $phpBinary artisan serve --host localhost --port 8010
exit $LASTEXITCODE
