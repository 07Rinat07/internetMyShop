import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import { defineConfig, devices } from '@playwright/test'

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)
const repositoryRoot = resolve(__dirname, '../..')
const apiOrigin = 'http://localhost:8010'
const webOrigin = 'http://localhost:3010'

export default defineConfig({
  testDir: './tests/e2e',
  fullyParallel: false,
  timeout: 60_000,
  retries: 0,
  reporter: 'list',
  use: {
    baseURL: webOrigin,
    trace: 'retain-on-failure',
  },
  projects: [
    {
      name: 'chromium',
      use: {
        ...devices['Desktop Chrome'],
      },
    },
  ],
  webServer: [
    {
      command: 'powershell -ExecutionPolicy Bypass -File ./apps/web/scripts/start-playwright-api.ps1',
      cwd: repositoryRoot,
      env: {
        ...process.env,
        APP_ENV: 'playwright',
        APP_URL: apiOrigin,
        FRONTEND_URL: webOrigin,
        DB_CONNECTION: 'sqlite',
        DB_DATABASE: resolve(repositoryRoot, 'database', 'playwright.sqlite'),
        CACHE_DRIVER: 'file',
        QUEUE_CONNECTION: 'sync',
        SESSION_DRIVER: 'file',
        SESSION_DOMAIN: 'localhost',
        SANCTUM_STATEFUL_DOMAINS: 'localhost:3010',
        PLAYWRIGHT_PHP_BINARY:
          process.env.PLAYWRIGHT_PHP_BINARY || 'C:\\OSPanel\\modules\\PHP-8.4\\php.exe',
      },
      timeout: 120_000,
      url: `${apiOrigin}/api/v1/catalog`,
      reuseExistingServer: false,
    },
    {
      command: 'powershell -ExecutionPolicy Bypass -File ./scripts/start-playwright-web.ps1',
      cwd: __dirname,
      env: {
        ...process.env,
        HOST: 'localhost',
        PORT: '3010',
        NUXT_API_BASE_INTERNAL: `${apiOrigin}/api/v1`,
      },
      timeout: 120_000,
      url: webOrigin,
      reuseExistingServer: false,
    },
  ],
})
