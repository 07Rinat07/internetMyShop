# Architecture

## Current stage

This repository is in the fourth stage of an API-first refactor:

- legacy Blade storefront remains available;
- `api/v1` now covers catalog, basket, checkout, auth, profiles and order history;
- auth for external frontend clients is now handled through Sanctum personal access tokens;
- a separate `Nuxt 3` frontend exists under `apps/web` and already consumes auth, catalog, profiles and orders;
- critical ownership and mass-assignment bugs are fixed before deeper migration;
- local runtime is pinned to PHP 7.4 for the legacy app while the codebase is prepared for a later Laravel 12 migration.

## Target direction

- backend: Laravel API with versioned endpoints;
- frontend: Nuxt 3 application in `apps/web`;
- documentation: OpenAPI spec under `docs/openapi.yaml`;
- tests: feature tests for web and API flows, then frontend unit and e2e coverage.

## Next refactor steps

1. Move basket and checkout UX into `apps/web`, then decide whether to keep cookie baskets or unify signed-in baskets server-side.
2. Expand frontend coverage from account pages to category, brand and product detail routes.
3. Expand API coverage to admin, search and CMS/page content flows.
4. Add frontend test coverage with `Vitest` and `Playwright`.
5. Add OpenAPI generation directly from PHP attributes during the Laravel 12 upgrade.
6. Upgrade framework and dependencies major by major until Laravel 12.
