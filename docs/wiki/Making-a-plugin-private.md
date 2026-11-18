Written against the unreleased `main` branch.

A plugin made from the template is public by default, where GitHub Actions minutes are free. A plugin that must be private runs the same checks on a developer's machine instead, because private repositories pay for Actions minutes.

**In a plugin made from this template:** a public plugin can delete this page and its entries in Home, the sidebar and the footer. A private plugin keeps it as the record of the switch.

## Steps

1. Make the repository private.
2. Delete `.github/workflows/ci.yml`.
3. Run the same checks with the shared local CI runner: the `local-ci` skill and its `local-ci.json` template, which the shared sync delivers once the plugin is onboarded.
4. Keep `.github/workflows/release.yml`. It runs only when a release is published.

## Reference

- [Continuous integration](Continuous-integration.md): the jobs `ci.yml` runs, which the local runner replaces.
- [Cutting a release](Cutting-a-release.md): what `release.yml` does.
