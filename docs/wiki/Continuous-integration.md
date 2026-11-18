Written against the unreleased `main` branch.

A plugin made from the template is public and runs its checks in GitHub Actions, from `.github/workflows/ci.yml`. It runs on every pull request, on every push to `main`, and by hand. [Making a plugin private](Making-a-plugin-private.md) covers the other case.

**In a plugin made from this template:** the jobs stay as they are. Change this page when the plugin adds a job beside the call or moves the pin.

## The jobs

| Job | What it runs | Notes |
| --- | --- | --- |
| `checks` | The shared chain in `UAMS-Web/uams-ci-workflows`, pinned to the tag `v0.13.0` | Linux, Windows and macOS legs and mutation testing (the chain's defaults), plus the plugin jobs: floor lint on PHP 8.2, the download-archive check and phpcs. The unit suite runs as `composer test:unit`. Its checks report as `checks / <job name> (<operating system>)`. |
| `legs` | The chain's `runner-legs.yml`, at the same tag | Fails when a job of the `checks` call did not run on the runners its classification names. |
| `integration` | `composer test:integration`, single site and multisite | A plain job beside the call, because its MySQL service and WordPress download are not in the chain. It downloads WordPress 7.0.8, the version most sites run. |
| `CI` | Reads the results of `checks`, `legs` and `integration` | The one check a ruleset requires from this workflow. It runs `if: always()` and fails unless every needed job reports `success`; a `skipped` or `cancelled` job fails it. |

The setup action (`.github/actions/setup/action.yml`) installs the integration suite's Composer dependencies by default, because the chain's PHPStan job needs them.

## Adding a job, or moving the pin

- **A job added beside the call goes in the `needs:` list of `CI`.** The chain's `aggregate-needs` job fails the pull request when one is missing. Do not rename `CI`, and do not rename `checks` without changing that list.
- **The two pins move together.** `checks` and `legs` name the same tag, because `legs` reads the classification of the chain that ran. To take a newer chain, move both pins to the next tag.

## Required checks

A ruleset on `main` requires three contexts: `CI`, and the two pull-request body checks, `Attribution footer` and `Closing keywords`. Because only `CI` names this workflow, adding or renaming a job needs no ruleset edit. Step 6 of [Create a plugin from this template (README)](https://github.com/UAMS-Web/wordpress-plugin-template#create-a-plugin-from-this-template) sets the ruleset up for a new plugin.

## Background

The [decision log](https://github.com/UAMS-Web/wordpress-plugin-template/blob/main/docs/DECISIONS.md) records why the chain is shared, why `integration` stays beside it, and why one aggregate check is required instead of each job.
