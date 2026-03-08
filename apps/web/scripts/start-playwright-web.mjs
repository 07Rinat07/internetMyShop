import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import { spawn, spawnSync } from 'node:child_process'

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)
const webRoot = resolve(__dirname, '..')
const npmBinary = 'npm'

runNpmCommand(['run', 'build'])

const server = spawn(process.execPath, ['.output/server/index.mjs'], {
  cwd: webRoot,
  env: process.env,
  stdio: 'inherit',
})

forwardSignal('SIGINT', server)
forwardSignal('SIGTERM', server)

server.on('exit', (code, signal) => {
  if (signal) {
    process.kill(process.pid, signal)
    return
  }

  process.exit(code ?? 0)
})

function runNpmCommand(argumentsList) {
  const result = spawnSync(npmBinary, argumentsList, {
    cwd: webRoot,
    env: process.env,
    shell: process.platform === 'win32',
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
