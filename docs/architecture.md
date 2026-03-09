# Architecture

## System overview

`internetMyShop` is a modular Laravel monolith with three active delivery layers:

1. `Blade storefront` for the legacy and compatibility-facing web UI.
2. `REST API /api/v1` for external and decoupled frontend clients.
3. `Nuxt 4 frontend` in `apps/web` that talks to the backend through a `BFF` layer.

The admin panel is implemented with `MoonShine` and runs inside the same Laravel application under `/admin`.

## Runtime topology

### Local development

- backend: Laravel 12 on PHP 8.4
- database: sqlite (`database/database.sqlite`)
- legacy storefront: served by Laravel
- admin: MoonShine inside Laravel
- separate frontend: Nuxt dev server on port `3000`

### Docker development

- backend: Laravel in `app` container
- frontend: Nuxt dev server in `web` container
- database: MySQL 8 in `db` container

Important:

- the current Docker stack is a development stack;
- it uses `php artisan serve` and `nuxt dev`;
- it is not the target production runtime.

## Architecture diagram

```text
Browser
  -> Blade storefront
      -> Laravel controllers
      -> Actions / Domain / Policies / Eloquent
      -> sqlite locally or MySQL in Docker

Browser
  -> Nuxt frontend
      -> Nuxt BFF (/bff)
          -> Laravel API /api/v1
          -> Sanctum token hidden behind HttpOnly cookie

Administrator
  -> MoonShine /admin
      -> same Laravel app
      -> same models and database

Storefront content manager
  -> MoonShine resource "Site Content"
      -> site_contents table
      -> runtime translation override middleware
```

## Delivery layers

### Blade storefront

The Blade storefront remains active because it still covers:

- the public catalog;
- basket and checkout;
- the user account;
- SEO-friendly storefront routes;
- direct access to MoonShine-adjacent admin flows from the same Laravel app.

Blade is treated as a compatibility layer, not the long-term frontend target.

### API layer

The API lives under `/api/v1` and currently covers:

- auth;
- catalog;
- basket;
- checkout;
- payment initiation and webhook integration;
- profiles;
- orders.

The API contract is maintained in `docs/openapi.yaml` and validated against registered routes by tests.

### Nuxt frontend and BFF

`apps/web` is the target frontend direction.

Key rules:

- browser requests should go through the Nuxt BFF;
- the BFF forwards requests to Laravel API;
- access tokens are stored behind `HttpOnly` cookies rather than exposed to browser JavaScript;
- basket state is synchronized through cookies and backend responses.

## Admin architecture

The old custom admin UI has been removed.
The project now uses `MoonShine` as the single admin panel.

MoonShine currently manages:

- categories;
- brands;
- products;
- orders;
- users;
- pages;
- storefront content text overrides.

Admin access is protected by the `access-admin` gate and enforced through middleware in the backend.

## Content management model

Storefront text is no longer only file-based.

The project now has a dual-layer content model:

1. translation files in `resources/lang/{locale}/site.php` act as defaults;
2. records in `site_contents` override those translations at runtime.

This is applied through `ApplySiteContentTranslations` middleware and `SiteContentService`.

Benefits:

- the site remains functional even if the table is empty;
- admin can override texts without changing files;
- Russian and English content can be managed independently.

## Domain boundaries

The preferred logical split is:

- `Catalog`
- `Basket`
- `Accounts`
- `Orders`
- `Payments`
- `Admin`
- `Content`

## Payment integration model

Платёжная интеграция построена как shared backend module, а не как frontend-specific implementation.

Stable backend layers:

- `CheckoutBasket` and `CreateOrderFromBasket` create the local order;
- `PaymentService` creates and resolves local payment records;
- `PaymentManager` selects the active provider driver;
- provider-specific code is isolated behind `PaymentProviderDriver`.

This means a real provider integration should normally change:

- `config/payments.php`
- `app/Enums/PaymentProvider.php`
- `app/Services/Payments/Providers/*`
- provider-specific frontend branch if the checkout flow differs

and should normally not require rewriting:

- order creation flow;
- basket flow;
- order and payment API resource shapes unless the public contract really changes;
- status page behavior.

Current first-class storefront flow is `hosted_fields`.
`redirect` providers are still valid in the backend model, but storefront UI must explicitly handle redirect continuation if such provider is introduced.

Within those modules, new work should prefer:

- `Actions` for transactional writes;
- `Queries` and `Filters` for read composition;
- `Policies` and `Gates` for authorization;
- `Resources` for API output contracts;
- `Services` only where orchestration is clearer outside controllers or models.

## Security boundaries

The backend remains the primary security boundary.

Core security rules:

- ownership must be enforced in backend code, not only in UI;
- client-sent protected fields must never be trusted;
- basket and checkout totals are server-derived;
- payment success must be confirmed by a verified backend webhook, not by browser return URLs;
- provider secrets and webhook secrets must never cross into browser-readable config;
- admin access is backend-guarded;
- upload handling must validate MIME, path and storage;
- browser auth should remain `HttpOnly`/BFF-based;
- security headers are added to web responses.

## Data and persistence

### Local

- sqlite is the default local database;
- it keeps setup friction low and makes local verification fast.

### Docker and production-like environments

- MySQL is used for containerized runs and recommended server deployment;
- image paths and admin uploads are stored in the application database and public storage.

## Quality and verification model

The repository treats documentation and tests as first-class parts of architecture.

Current verification layers:

- `PHPUnit` for backend behavior;
- `Larastan/PHPStan` for backend static analysis;
- `Pint` for formatting;
- `Vitest` for Nuxt unit logic;
- `Playwright` for end-to-end browser flow;
- OpenAPI route contract tests.

## Production deployment direction

Recommended production topology:

- `Nginx`
- `PHP-FPM 8.4`
- `MySQL 8`
- `Node 24`
- `systemd` or process supervisor for the Nuxt server

Detailed operational instructions live in `docs/hosting-deployment.md`.

## Documentation contract

This architecture document must be updated when changes affect:

- frontend/backend boundaries;
- auth or session flow;
- payment provider or webhook flow;
- admin model;
- content model;
- runtime topology;
- deployment assumptions.
