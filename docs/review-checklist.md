# Review Checklist

Use this checklist after each non-trivial change.

## Correctness

- Does the code do exactly what the request requires?
- Are edge cases handled explicitly?
- Are local and Docker runtimes still aligned?

## Security

- Is every write path validated?
- Is authorization enforced in the backend, not only in UI flow?
- Are mass-assignment, token handling, and upload paths safe?

## Data integrity

- Are transactions needed?
- Can the client tamper with protected fields?
- Does the change behave the same on sqlite and MySQL where tests rely on both?

## Tests

- Were tests added or updated for the changed behavior?
- Do existing feature and unit tests still pass?
- If no test was added, is the reason documented?

## Documentation

- Was `README.md` updated if setup or runtime changed?
- Was `docs/architecture.md` updated if boundaries changed?
- Was `docs/openapi.yaml` updated if API behavior changed?
- Was `docs/hosting-deployment.md` updated if production or hosting assumptions changed?
- Was `docs/documentation-maintenance.md` updated if documentation workflow changed?

## Code quality

- Is the code readable without hidden assumptions?
- Are comments useful rather than decorative?
- Are names aligned with Laravel and Vue conventions?

## Output format for self-review

Each completed task should end with:

- key changes;
- findings or residual risks;
- verification performed.
