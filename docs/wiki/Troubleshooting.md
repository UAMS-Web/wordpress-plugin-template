Written against the unreleased `main` branch.

One entry per symptom, as you meet it: the message or behavior, its cause, and the fix.

**In a plugin made from this template:** the messages below name the template's placeholders (`uams-plugin-template`, `UAMSWeb\PluginTemplate`); after the rename they name the plugin's own. Add an entry for each problem the plugin's users meet.

- [Refusing to run: the Integration suite's own Composer setup is not installed](#refusing-to-run-the-integration-suites-own-composer-setup-is-not-installed)
- [Refusing to run: no WordPress at the path](#refusing-to-run-no-wordpress-at-the-path)
- [Refusing to run: WP_TESTS_DB_NAME is the database the install uses](#refusing-to-run-wp_tests_db_name-is-the-database-the-install-uses)
- [FAIL: files in the download are not what the plugin runs](#fail-files-in-the-download-are-not-what-the-plugin-runs)
- [A file the plugin needs is missing after a WP Pusher install](#a-file-the-plugin-needs-is-missing-after-a-wp-pusher-install)
- [Class not found after the rename](#class-not-found-after-the-rename)
- [The plugin requires PHP 8.2 or newer and has not loaded](#the-plugin-requires-php-82-or-newer-and-has-not-loaded)
- [No Version header in uams-plugin-template.php](#no-version-header-in-uams-plugin-templatephp)
- [Fixed](#fixed)

## Refusing to run: the Integration suite's own Composer setup is not installed

`composer test:integration` stops with:

```text
Refusing to run: the Integration suite's own Composer setup is not installed.
Run `composer setup:integration` (or `composer install` in tests/Integration) first.
```

**Cause:** the integration suite has its own `composer.json` in `tests/Integration/` (PHPUnit 9.6, `wp-phpunit`, the polyfills), separate from the root's Pest setup, and its `vendor/` is missing.

**Fix:** run `composer setup:integration`.

## Refusing to run: no WordPress at the path

`composer test:integration` stops with `Refusing to run: no WordPress at <path>.`

**Cause:** the suite boots a real WordPress. Unset, `WP_TESTS_ABSPATH` points at the install this checkout sits in, five levels up from `tests/Integration/`, and there is none there.

**Fix:** check the plugin out inside a WordPress install (`wp-content/plugins/<slug>`), or point `WP_TESTS_ABSPATH` at a core copy, for example one fetched with `wp core download --path=<dir>`.

## Refusing to run: WP_TESTS_DB_NAME is the database the install uses

`composer test:integration` stops with:

```text
Refusing to run: WP_TESTS_DB_NAME is '<name>', the database the
WordPress install at <path> uses. The test installer drops every table it
finds. Point WP_TESTS_DB_NAME at a database you can afford to lose.
```

**Cause:** the test installer drops every table it finds and rebuilds the schema. The bootstrap reads `DB_NAME` from the surrounding install's `wp-config.php` and refuses when the test database is the same one.

**Fix:** set `WP_TESTS_DB_NAME` to a database nothing else uses, and create it first (the default is `uams_plugin_template_tests`).

## FAIL: files in the download are not what the plugin runs

`composer check:archive`, or the download-archive check in CI, ends with:

```text
FAIL: <n> of <m> file(s) in the download are not what the plugin runs; add a keep-list to .gitattributes (see the keep-the-download-to-what-runs rule)
```

Each offending path is listed above it as `not for the download: <path>`.

**Cause:** a keep-list line puts back a path that is configuration, documentation, tests or build tooling, or the first two deny lines of `.gitattributes` were removed.

**Fix:** remove the offending `-export-ignore` line, or restore `/* export-ignore` and `/.* export-ignore` at the top of the keep-list. [Adding a runtime folder](Adding-a-runtime-folder.md) shows the shape.

## A file the plugin needs is missing after a WP Pusher install

The plugin works in development and fails on a site, and the site's copy of the plugin has no folder the code loads from.

**Cause:** the folder is not in the keep-list, so `git archive` leaves it out of the branch download and the release ZIP. The download-archive check reports files that should not ship; it does not report a runtime file that is missing.

**Fix:** add the folder's two `-export-ignore` lines, as [Adding a runtime folder](Adding-a-runtime-folder.md) describes.

## Class not found after the rename

Activating the plugin, or loading any page once it is active, fails with a fatal error such as `Uncaught Error: Class "UAMSWeb\Example\Plugin" not found`.

**Cause:** the namespace was renamed in the classes and the main file, and not in the prefix string of `includes/autoload.php`, so the autoloader ignores every class.

**Fix:** set the prefix in `includes/autoload.php` to the new namespace, and keep it in step with `autoload-dev` in `composer.json`. See [Renaming the template](Renaming-the-template.md#3-change-the-autoloaders-prefix-too).

## The plugin requires PHP 8.2 or newer and has not loaded

An administrator sees the notice `UAMS Plugin Template requires PHP 8.2 or newer and has not loaded.`, and none of the plugin's screens appear.

**Cause:** the site runs a PHP older than the floor. `Requires PHP` in the header stops an install on an older PHP, but not a site that is downgraded underneath an active plugin; the floor guard in the main file shows this notice instead of a fatal error.

**Fix:** move the site to PHP 8.2 or newer.

## No Version header in uams-plugin-template.php

`composer build` stops with `Error: No Version header in uams-plugin-template.php`.

**Cause:** `scripts/build-zip.mjs` names the ZIP from the main file's `Version` header when no `--version` is passed, and the header has no `Version:` line.

**Fix:** restore the `Version:` line in the plugin header. [Cutting a release](Cutting-a-release.md) covers where the number is written.

## Fixed

Problems fixed in a release stay here, with the release that fixed them, instead of being deleted.
