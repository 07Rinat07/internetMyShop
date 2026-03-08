import { existsSync, mkdirSync, openSync, closeSync } from 'node:fs'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import { spawn, spawnSync } from 'node:child_process'

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)
const repositoryRoot = resolve(__dirname, '../..', '..')
const databasePath = resolve(repositoryRoot, 'database', 'playwright.sqlite')

const phpBinary = resolvePhpBinary()

ensurePlaywrightDatabase()
runPhpCommand(['artisan', 'config:clear'])
runPhpCommand([
  'artisan',
  'migrate:fresh',
  '--force',
  '--seed',
  '--seeder=App\\Seeders\\E2eDemoSeeder',
])

const server = spawn(
  phpBinary,
  ['artisan', 'serve', '--host', 'localhost', '--port', '8010'],
  {
    cwd: repositoryRoot,
    env: process.env,
    stdio: 'inherit',
  },
)

forwardSignal('SIGINT', server)
forwardSignal('SIGTERM', server)

server.on('exit', (code, signal) => {
  if (signal) {
    process.kill(process.pid, signal)
    return
  }

  process.exit(code ?? 0)
})

function ensurePlaywrightDatabase() {
  const databaseDirectory = dirname(databasePath)

  if (! existsSync(databaseDirectory)) {
    mkdirSync(databaseDirectory, { recursive: true })
  }

  if (! existsSync(databasePath)) {
    closeSync(openSync(databasePath, 'w'))
  }
}

function resolvePhpBinary() {
  const candidates = [
    process.env.PLAYWRIGHT_PHP_BINARY,
    process.platform === 'win32' ? 'C:\\OSPanel\\modules\\PHP-8.4\\php.exe' : null,
    process.platform === 'win32' ? 'php.exe' : 'php',
  ].filter(Boolean)

  for (const candidate of candidates) {
    const result = spawnSync(candidate, ['-v'], {
      cwd: repositoryRoot,
      env: process.env,
      stdio: 'ignore',
    })

    if (! result.error && result.status === 0) {
      return candidate
    }
  }

  throw new Error(
    'Unable to resolve a PHP 8.4 binary for Playwright. Set PLAYWRIGHT_PHP_BINARY in the environment.',
  )
}

function runPhpCommand(argumentsList) {
  const result = spawnSync(phpBinary, argumentsList, {
    cwd: repositoryRoot,
    env: process.env,
    stdio: 'inherit',
  })

  if (result.error) {
    console.error(result.error)
    process.exit(1)
  }

  if (result.status !== 0) {
    process.exit(result.status ?? 1)
  }
}

function forwardSignal(signal, child) {
  process.on(signal, () => {
    child.kill(signal)
  })
}
