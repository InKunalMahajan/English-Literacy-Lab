# Phase 15.1: read-only local readiness checks. Run from repository root.
$ErrorActionPreference = 'Stop'
Set-Location (Resolve-Path (Join-Path $PSScriptRoot '..'))
function Invoke-Check([string]$Label, [string]$Command, [string[]]$Arguments) {
    Write-Host "`n== $Label ==" -ForegroundColor Cyan
    & $Command @Arguments
    if ($LASTEXITCODE -ne 0) { throw "$Label failed (exit code $LASTEXITCODE)." }
}
if (-not (Test-Path '.env')) { throw 'Missing .env. Follow README local setup. Do not overwrite an existing .env.' }
if (-not (Test-Path 'vendor/autoload.php')) { throw 'Missing vendor dependencies. Run composer install.' }
if (-not (Test-Path 'node_modules')) { throw 'Missing frontend dependencies. Run npm install.' }
Invoke-Check 'PHP version' 'php' @('-v')
Invoke-Check 'Composer manifest' 'composer' @('validate','--no-check-publish')
Invoke-Check 'Laravel tests' 'php' @('artisan','test')
Invoke-Check 'Frontend build' 'npm' @('run','build')
Invoke-Check 'Route registration' 'php' @('artisan','route:list')
Write-Host "`nLocal automated checks passed. This does NOT certify accessibility, privacy, backups, CI or production readiness." -ForegroundColor Green
