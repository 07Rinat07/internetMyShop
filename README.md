# internetMyShop

Legacy Laravel storefront that is being migrated to an API-first architecture.

## Current stack

- legacy app runtime: Laravel 7.30 + PHP 7.4 for the current codebase;
- migration target: Laravel API + separate Nuxt frontend;
- API documentation: `docs/openapi.yaml`;
- test runtime: PHPUnit feature tests with sqlite in memory.

## Local run

1. Use `C:\OSPanel\modules\PHP-7.4\php.exe`.
2. Run `artisan migrate:fresh` against the local sqlite database from `.env`.
3. Run tests with `C:\OSPanel\modules\PHP-7.4\php.exe artisan test`.

## API v1

The current API-first migration stage adds catalog, basket, auth, profile and order endpoints.

Auth is now based on `Laravel Sanctum` personal access tokens:

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `GET /api/v1/auth/me`
- `POST /api/v1/auth/logout`

- `GET /api/v1/catalog`
- `GET /api/v1/categories/{category}`
- `GET /api/v1/brands/{brand}`
- `GET /api/v1/products/{product}`
- `GET /api/v1/basket`
- `POST /api/v1/basket/items`
- `PATCH /api/v1/basket/items/{product}`
- `DELETE /api/v1/basket/items/{product}`
- `DELETE /api/v1/basket`
- `POST /api/v1/basket/checkout`
- `GET /api/v1/profiles`
- `POST /api/v1/profiles`
- `GET /api/v1/profiles/{profile}`
- `PATCH /api/v1/profiles/{profile}`
- `DELETE /api/v1/profiles/{profile}`
- `GET /api/v1/orders`
- `GET /api/v1/orders/{order}`

`profiles` and `orders` now require `Authorization: Bearer <token>`.
`basket` remains guest-friendly and still uses the transitional cookie-based basket contract.

## Documentation

- architecture notes: `docs/architecture.md`
- OpenAPI spec: `docs/openapi.yaml`
