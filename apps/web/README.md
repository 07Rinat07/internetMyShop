# apps/web

Separate `Nuxt 4` frontend for the API-first migration.

## Commands

- `npm install`
- `npm run dev`
- `npm run build`
- `npm run preview`
- `npm run test:unit`
- `npm run test:e2e:install`
- `npm run test:e2e`

## Runtime

- target local Node runtime: `24`
- default API base: `http://localhost/api/v1`
- override with `NUXT_PUBLIC_API_BASE`
- Playwright uses its own isolated ports: `http://localhost:8010` for Laravel API and `http://localhost:3010` for Nuxt.

## Current pages

- `/`
- `/catalog`
- `/catalog/category/:slug`
- `/brands/:slug`
- `/products/:slug`
- `/basket`
- `/checkout`
- `/login`
- `/profile`
- `/orders`

## Test coverage

- unit: `tests/unit/checkout.test.ts`, `tests/unit/pagination.test.ts`
- e2e: `tests/e2e/login-basket-checkout.spec.ts`
- seeded browser-test account: `buyer@example.test` / `Password123!`
