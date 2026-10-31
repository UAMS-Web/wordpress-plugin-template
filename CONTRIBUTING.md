# Contributing

1. Work from an issue. Branch from `main` as `<issue number>-<short-name>`.
2. Run the checks listed in the README before opening a pull request: `composer test`, `composer stan`, `composer test:pint`, `composer test:phpcs`, `composer test:refactor` and `composer check:archive`.
3. Open the pull request against `main` with `Closes #<issue>` in its body, and fill in the test plan.
4. Record a decision that closes a question in `docs/DECISIONS.md` and in the issue's `## Decision` section.

Code follows the [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/) and the [Security APIs](https://developer.wordpress.org/apis/security/): check capabilities, verify nonces, sanitize input, escape output.
