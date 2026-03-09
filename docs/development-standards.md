# Development Standards

## Goals

This project is maintained with three priorities:

1. stability;
2. security;
3. explicit, reviewable architecture.

## Backend standards

### Laravel

- Target framework line: `Laravel 12`.
- Target local runtime: `PHP 8.4`.
- Prefer framework-native patterns before custom abstractions.
- Use `FormRequest` for validation, `Policies` or explicit ownership checks for authorization, `Resources` for API responses, and focused `Action` or `Query` classes for non-trivial business logic.

### Controllers

- Controllers should stay thin.
- No unvalidated `request()->all()` writes.
- No authorization hidden in views or only in routes if model ownership is involved.
- Public controller methods should remain easy to scan and delegate real work.

### Models and queries

- Use typed casts and clear fillable or guarded rules.
- Query scopes must be portable across the databases used in this repository.
- Raw SQL is allowed only when the query builder cannot express the intent clearly.
- When raw SQL is required, prefer ANSI-compatible expressions over vendor-specific syntax unless the runtime is intentionally locked to one engine.

### Security

- Validate all user input through explicit rules.
- Never trust client-sent ownership, status, amount, or role fields.
- Never trust browser return URLs or frontend callbacks as proof of successful payment.
- File uploads must validate mime type, size, and storage path handling.
- Auth and permission changes must include tests.
- For browser auth, prefer first-party `HttpOnly` cookie flows or a BFF boundary over client-readable bearer token storage.

## Frontend standards

### Nuxt and Vue

- Target frontend line: `Nuxt 4`.
- Use composables for reusable API and state logic.
- Keep view components focused on rendering and UI flow.
- Do not duplicate API contract knowledge across pages when it can live in shared types or composables.

### TypeScript

- Prefer explicit types for API payloads, composables, and shared utilities.
- Avoid `any` unless there is a documented boundary with third-party runtime data.

## Documentation standards

Update docs in the same change when you modify:

- setup or runtime prerequisites;
- environment variables;
- API routes or payloads;
- payment provider configuration, webhook flow, or payment status mapping;
- auth flow;
- admin routes or admin behavior;
- storefront content management behavior;
- seed data used for manual or automated testing;
- hosting or deployment assumptions;
- architecture boundaries;
- operational behavior in Docker or local environments.

The minimum documentation set to consider on every meaningful change is:

- `README.md`
- `docs/architecture.md`
- `docs/openapi.yaml`
- `docs/payments.md`
- `docs/hosting-deployment.md`
- `docs/documentation-maintenance.md`

## Commenting standards

Comments should explain intent, invariants, or risk.
Bad comments describe syntax.
Good comments explain business rules, edge cases, database portability, or security reasoning.

## Testing standards

Each meaningful code change should add or update the narrowest useful test:

- backend domain and request behavior: PHPUnit feature or unit tests;
- frontend pure logic: Vitest;
- cross-app user flows: Playwright.

At minimum, changes to auth, checkout, profile ownership, catalog filters, search, or admin actions must not ship without automated coverage.

## Quality gates

Before closing a meaningful backend change, the relevant scope should be green under:

- `php scripts/app.php backend:lint`
- `php scripts/app.php backend:analyse`
- `php scripts/app.php backend:test`

Before closing a meaningful frontend change, the relevant scope should be green under:

- `php scripts/app.php web:lint`
- `php scripts/app.php web:typecheck`
- `php scripts/app.php web:test:unit`

User-facing cross-app flows should add or update a `Playwright` scenario when practical.

Use `php scripts/app.php ...` as the primary documented project entrypoint for cross-platform local work. `composer` aliases may stay as convenience shortcuts, but documentation should prefer the universal launcher.

If tooling or commands change, ensure the documented commands still work on Windows, Ubuntu and macOS with the stated prerequisites.

## Review workflow

For each completed change, perform a written self-review:

1. what changed;
2. what could break;
3. what was tested;
4. what remains as technical debt or deliberate compromise.
