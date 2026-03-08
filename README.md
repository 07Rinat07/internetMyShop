# internetMyShop

Legacy Laravel storefront that is being migrated to an API-first architecture.

## Current stack

- legacy app runtime: Laravel 7.29 + PHP 7.4 for the current codebase;
- migration target: Laravel API + separate Nuxt frontend;
- API documentation: `docs/openapi.yaml`;
- test runtime: PHPUnit feature tests with sqlite in memory.

## Local run

1. Use `C:\OSPanel\modules\PHP-7.4\php.exe`.
2. Run `artisan migrate:fresh` against the local sqlite database from `.env`.
3. Run tests with `C:\OSPanel\modules\PHP-7.4\php.exe artisan test`.

## API v1

The first API-first migration stage adds read-only catalog endpoints:

- `GET /api/v1/catalog`
- `GET /api/v1/categories/{slug}`
- `GET /api/v1/brands/{slug}`
- `GET /api/v1/products/{slug}`

## Documentation

- architecture notes: `docs/architecture.md`
- OpenAPI spec: `docs/openapi.yaml`
