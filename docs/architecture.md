# Architecture

## Current stage

This repository is in the third stage of an API-first refactor:

- legacy Blade storefront remains available;
- `api/v1` now covers catalog, basket, checkout, auth, profiles and order history;
- auth for external frontend clients is now handled through Sanctum personal access tokens;
- critical ownership and mass-assignment bugs are fixed before deeper migration;
- local runtime is pinned to PHP 7.4 for the legacy app while the codebase is prepared for a later Laravel 12 migration.

## Target direction

- backend: Laravel API with versioned endpoints;
- frontend: Nuxt 3 application in a separate app;
- documentation: OpenAPI spec under `docs/openapi.yaml`;
- tests: feature tests for web and API flows, then frontend unit and e2e coverage.

## Next refactor steps

1. Introduce a separate Nuxt 3 frontend app that consumes `api/v1`.
2. Decide whether basket should stay cookie-based or move to authenticated server-side baskets for signed-in users.
3. Expand API coverage to admin, search and CMS/page content flows.
4. Add OpenAPI generation directly from PHP attributes during the Laravel 12 upgrade.
5. Upgrade framework and dependencies major by major until Laravel 12.
