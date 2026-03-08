# Documentation Maintenance

## Purpose

This repository treats documentation as part of the deliverable, not as optional follow-up.

After every meaningful change, the relevant documentation must be updated in the same change set.

## Core documentation files

### Repository entry and runbooks

- `README.md`
- `docs/hosting-deployment.md`

### Architecture and engineering rules

- `docs/architecture.md`
- `docs/development-standards.md`
- `docs/review-checklist.md`
- `CONTRIBUTING.md`

### API and contract documentation

- `docs/openapi.yaml`

## Update matrix

### If you change local setup, Docker setup, runtime prerequisites or commands

Update:

- `README.md`
- `docs/hosting-deployment.md`

### If you change env vars, ports, domains, cookies, auth flow or BFF behavior

Update:

- `README.md`
- `docs/architecture.md`
- `docs/openapi.yaml` if API auth contract changed
- `docs/hosting-deployment.md`

### If you change API routes, request payloads, response payloads or auth requirements

Update:

- `docs/openapi.yaml`
- `README.md` if the public usage or testing flow changed
- `docs/architecture.md` if boundaries changed

### If you change admin behavior, CMS behavior, MoonShine resources or storefront text management

Update:

- `README.md`
- `docs/architecture.md`
- `docs/hosting-deployment.md` if operational behavior changed

### If you change seeds, demo accounts or demo catalog/content data

Update:

- `README.md`
- `docs/hosting-deployment.md` if production guidance changes

### If you change quality gates, test commands or review expectations

Update:

- `README.md`
- `docs/development-standards.md`
- `docs/review-checklist.md`
- `CONTRIBUTING.md`

## Minimal completion checklist for every non-trivial change

1. Update code.
2. Add or update tests.
3. Update the relevant docs in the same branch.
4. Re-run the relevant verification commands.
5. Include a short self-review.

## Required verification commands

### Backend

```bash
php scripts/app.php backend:lint
php scripts/app.php backend:analyse
php scripts/app.php backend:test
```

### Frontend

```bash
php scripts/app.php web:lint
php scripts/app.php web:typecheck
php scripts/app.php web:test:unit
```

### When frontend runtime changed

```bash
php scripts/app.php web:build
php scripts/app.php web:test:e2e
```

### Cross-platform shortcut for team verification

```bash
php scripts/app.php verify:all
php scripts/app.php verify:e2e
```

## Review rule

A change is not complete if:

- commands changed but README was not updated;
- deployment assumptions changed but hosting docs were not updated;
- API changed but OpenAPI was not updated;
- auth or role logic changed but architecture docs were not updated.
