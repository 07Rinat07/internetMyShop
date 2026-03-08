$ErrorActionPreference = 'Stop'

$webRoot = Resolve-Path (Join-Path $PSScriptRoot '..')

Set-Location $webRoot

npm run build
if ($LASTEXITCODE -ne 0) {
    exit $LASTEXITCODE
}

& node .output/server/index.mjs
exit $LASTEXITCODE
