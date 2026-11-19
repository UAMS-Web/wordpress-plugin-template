# UAMS Plugin Template

A GitHub template for a new UAMS-Web WordPress plugin. A plugin made from it passes the shared WordPress standard on its first commit: PHP 8.2 floor, Pest 5 unit suite, PHPUnit 9.6 integration suite against a real WordPress, Rector, PHPStan, Pint, WordPress security sniffs, and a download that holds only what the plugin runs.

This README covers what is in the template, creating a plugin from it, and the development commands. The rest of the documentation (renaming, task guides, reference and troubleshooting) is in the repository's wiki, published from [`docs/wiki/`](docs/wiki/Home.md).

## What is in it

| Path | Purpose |
| --- | --- |
| `uams-plugin-template.php` | The main file: full plugin header, direct-access guard, PHP floor guard, GPL notice. |
| `includes/` | Namespaced code (`UAMSWeb\PluginTemplate`) and a small autoloader, so a deployed branch needs no `vendor/`. `Settings` is a worked example of a capability check, a nonce, sanitized input and escaped output. |
| `uninstall.php` | The one place data is removed. Multisite-aware. Activation and deactivation never delete data. |
| `readme.txt` | WordPress.org-format readme. |
| `languages/` | The `.pot` file. |
| `tests/Unit/` | Pest 5 and Brain Monkey: no WordPress, no database. |
| `tests/Integration/` | PHPUnit 9.6 on `wp-phpunit`, with its own `composer.json`. |
| `scripts/` | `build-zip.mjs` (upload ZIP), `check-download-archive.mjs` (keep-list check), `lint-floor.php` (floor lint). |
| `docs/DECISIONS.md` | The decision log. |
| `docs/wiki/` | The wiki's pages, published by `.github/workflows/publish-wiki.yml`. |

## Create a plugin from this template

1. On GitHub, choose **Use this template**, and name the new repository for the plugin. Make it public unless it must be private (see below).
2. Rename the template's names, everywhere they appear: [Renaming the template](docs/wiki/Renaming-the-template.md) lists each name to find, what replaces it and where it appears, and the rules for choosing the plugin's namespace.
3. Update the header's `Plugin URI` and `Description`, `readme.txt`, and this README. Delete the example `Settings` screen once the plugin has its own, keeping the pattern. Replace the placeholder under `## Credits` with the plugin's developers; the header's `Author` and `Author URI` stay as they are.
   Keep the version constant read from the header (`get_file_data()` in the main file) so the release number is written once; `tests/Unit/PluginHeaderTest.php` ships with the template and holds the `Plugin URI` shape, the `Author` and `Author URI` values, a three-segment `Version`, and that single source. It finds the main file by its `Plugin Name:` header, so it needs no edit after the rename.
4. Run `composer install` and `composer setup:integration`, then `composer test`, so the first commit is green.
5. Onboard the plugin to the shared sync, which delivers the shared skills and rules (this template is not itself a sync target). The synced copy of the archive check can replace `scripts/check-download-archive.mjs`.
6. Set the repository's visibility and checks (below), and require the `CI` check in a ruleset. `node .claude/skills/repository-settings/scripts/apply-repository-settings.mjs --profile plugin UAMS-Web/<repo>` prints the plan for the settings and the ruleset; add `--apply` once the owner has said yes.

## Develop

```bash
composer install
composer setup:integration            # the integration suite's own Composer setup
composer test:unit                    # Pest
composer test:integration             # PHPUnit 9.6 against WordPress and a database
composer stan                         # PHPStan
composer test:pint                    # formatting (composer fix:pint to apply)
composer test:phpcs                   # WordPress security sniffs
composer test:refactor                # Rector, dry run
composer check:archive                # the download holds only what the plugin runs
LINT_PHP=/path/to/php8.2 composer lint:floor   # parse shipped files on the floor PHP
```

### The integration suite

It boots WordPress through `wp-phpunit` and **drops and rebuilds every table in its test database**.

1. Create a database you can afford to lose: `mysql -u root -e 'CREATE DATABASE uams_plugin_template_tests'`.
2. Check the plugin out inside a WordPress install (`wp-content/plugins/<slug>`), or point `WP_TESTS_ABSPATH` at a core copy: `wp core download --path=/tmp/wordpress --version=7.0.8`.
3. Run `composer test:integration`. Set `WP_MULTISITE=1` to run it as a multisite. `WP_TESTS_DB_NAME`, `WP_TESTS_DB_USER`, `WP_TESTS_DB_PASSWORD` and `WP_TESTS_DB_HOST` override the defaults. The bootstrap refuses to run against the install's own database.

## Public by default, and the switch for a private plugin

A plugin made from the template is **public** and runs its checks in GitHub Actions (`.github/workflows/ci.yml`), which calls the shared chain in `UAMS-Web/uams-ci-workflows`. [Continuous integration](docs/wiki/Continuous-integration.md) lists its jobs, the pins and the one check a ruleset requires.

To make a plugin **private**, follow [Making a plugin private](docs/wiki/Making-a-plugin-private.md): the checks move to the shared local CI runner, because private repositories pay for Actions minutes.

## Cut a release

[Cutting a release](docs/wiki/Cutting-a-release.md) covers raising the version, publishing the release, and the upload ZIP that `release.yml` attaches to it. Sites deploy a branch through WP Pusher, so nothing is built at deploy time.

## The download keep-list

`.gitattributes` excludes everything from a branch download and names back only what the plugin runs, and `composer check:archive` and CI fail a change that ships anything else. [Adding a runtime folder](docs/wiki/Adding-a-runtime-folder.md) explains why and how to add a folder to it.

## Credits

Developed and maintained by UAMS Web Services.

Developers:

- First Last

A plugin made from the template replaces the placeholder with its own developers: a person with a merged commit on the default branch, by full name, in alphabetical order by surname. Bots and AI tools are not listed. The header names UAMS Web Services as the `Author` and not individual developers, and a fork of a third-party project keeps the upstream `Author` and `Author URI` and credits UAMS Web Services' changes here instead.

## Licence

GPL-3.0-or-later. Copyright (C) 2026 University of Arkansas for Medical Sciences.
