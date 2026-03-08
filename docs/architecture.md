# Architecture

## Current stage

This repository is in the first stage of an API-first refactor:

- legacy Blade storefront remains available;
- `api/v1` is introduced for catalog read endpoints;
- critical ownership and mass-assignment bugs are fixed before deeper migration;
- local runtime is pinned to PHP 7.4 for the legacy app while the codebase is prepared for a later Laravel 12 migration.

## Target direction

- backend: Laravel API with versioned endpoints;
- frontend: Nuxt 3 application in a separate app;
- documentation: OpenAPI spec under `docs/openapi.yaml`;
- tests: feature tests for web and API flows, then frontend unit and e2e coverage.

## Next refactor steps

1. Extract basket and checkout into API endpoints.
2. Add authentication API and token/session strategy.
3. Move profile and order history to API resources.
4. Introduce frontend app that consumes `api/v1`.
5. Upgrade framework and dependencies major by major until Laravel 12.
