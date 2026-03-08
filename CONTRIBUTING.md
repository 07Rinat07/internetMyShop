# Contributing

## Engineering bar

All changes in this repository must be made at a senior full-stack level.
That means each change should be:

- correct before clever;
- explicit in behavior and tradeoffs;
- safe by default;
- testable in isolation;
- documented where it changes public behavior or architecture.

## Required quality gates

Before a change is considered complete, it must include:

- updated code that follows project conventions;
- tests for the changed behavior, or a short written reason why a test is not practical;
- documentation updates if the change affects setup, architecture, API contracts, auth, seed data, or runtime assumptions;
- a short self-review covering risks, regressions, and follow-up work.

## Documentation rules

Documentation is required for:

- public HTTP endpoints;
- environment setup and runtime requirements;
- non-obvious domain rules;
- migrations that affect data shape or behavior;
- architectural decisions that change boundaries between frontend, backend, storage, or auth.

Use the following locations:

- `README.md` for setup, run, and high-level project usage;
- `docs/architecture.md` for architectural direction and boundaries;
- `docs/openapi.yaml` for API contracts;
- `docs/development-standards.md` for coding and documentation conventions;
- `docs/review-checklist.md` for review expectations.

## Comment and annotation rules

Do not add comments that restate obvious code.
Comments must explain one of these:

- why a decision exists;
- what invariant must hold;
- why an implementation is intentionally unusual;
- how a security or data-integrity constraint is enforced.

Use PHPDoc or TSDoc on:

- public controllers, actions, services, queries, DTO-like objects, and reusable composables when the contract is not obvious from types alone;
- methods with important side effects or invariants;
- complex query scopes and search logic.

Avoid decorative or redundant annotations.

## Review standard

Every completed change must be reviewed for:

- correctness;
- security;
- backwards compatibility;
- data consistency;
- test coverage;
- documentation drift.

Findings must be listed before summaries.

## Change policy

Prefer small, reviewable increments over broad rewrites.
If a change introduces a temporary compromise, document it in the same change.
