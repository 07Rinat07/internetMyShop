# Architecture

## Current stage

This repository is in the fourth stage of an API-first refactor:

- legacy Blade storefront remains available;
- `api/v1` now covers catalog, basket, checkout, auth, profiles and order history;
- external API clients use Sanctum personal access tokens;
- the Nuxt frontend now uses a BFF layer with `HttpOnly` cookies instead of client-readable bearer token storage;
- a separate `Nuxt 4` frontend exists under `apps/web` and already consumes auth, catalog, brand detail, product detail, basket, checkout, profiles and orders through that BFF layer;
- critical ownership and mass-assignment bugs are fixed before deeper migration;
- policy and gate authorization is in place for profile ownership, order ownership and admin access;
- catalog search and filtering are being moved into a dedicated query and filter layer under `app/Domain/Catalog`;
- frontend coverage now includes `Vitest` unit tests and a `Playwright` e2e flow over isolated Laravel/Nuxt test servers;
- backend quality gates now include `Pint`, `Larastan/PHPStan`, `PHPUnit`, and an OpenAPI route-contract check;
- backend runtime is now Laravel 12 on PHP 8.4 for both local verification and Docker.

## Target direction

- architecture style: modular monolith, not microservices;
- backend: Laravel API with versioned endpoints and explicit domain boundaries;
- frontend: Nuxt 4 application in `apps/web` with BFF routing for browser auth;
- documentation: OpenAPI spec under `docs/openapi.yaml`, with contract validation against registered routes;
- tests: feature tests for web and API flows plus frontend unit and e2e coverage.

## Domain boundaries

The preferred module split is now:

- `app/Domain/Catalog`
- `app/Domain/Accounts`
- `app/Domain/Orders`
- `app/Domain/Admin`
- `app/Domain/Content`
- `app/Domain/Basket`

Inside each module, new work should prefer:

- `Actions` for transactional writes;
- `Queries` for read-side composition and search;
- `Policies` for ownership and permissions;
- `DTO` or `Data` objects when payload shape becomes non-trivial;
- `Http` only for delivery concerns.

## Next refactor steps

1. Decide whether to keep cookie baskets as-is or merge them into a server-side customer basket after login.
2. Expand API coverage to admin, search and CMS/page content flows.
3. Add more frontend e2e scenarios around profile CRUD, guest checkout and order history.
4. Replace the proxy-managed bearer token with a full first-party session and CSRF flow if the frontend remains same-origin.
5. Add OpenAPI generation directly from PHP attributes so the spec is emitted from backend code instead of being maintained manually.
6. Expand admin, CMS, upload and seed consistency coverage to match the customer API quality bar.

## Engineering process

The repository now treats documentation, review, and code conventions as first-class deliverables.
The active standards live in:

- `CONTRIBUTING.md`
- `docs/development-standards.md`
- `docs/review-checklist.md`

This means each future change should ship with:

- code aligned to Laravel and Nuxt conventions;
- tests or an explicit reason why coverage is not practical;
- static analysis and formatting green in the relevant scope;
- documentation updates where behavior or contracts changed;
- a short self-review covering correctness, security, regressions, and residual risks.
