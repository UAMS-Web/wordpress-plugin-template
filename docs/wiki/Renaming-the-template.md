Written against the unreleased `main` branch.

Step 2 of [Create a plugin from this template (README)](https://github.com/UAMS-Web/wordpress-plugin-template#create-a-plugin-from-this-template): replace the template's names with the plugin's own. By the end of this page every placeholder name is gone and the plugin's own names are in place.

**In a plugin made from this template:** delete this page, and its entries in Home, the sidebar and the footer, once the rename is done.

## 1. Replace each name

Search for each name case-sensitively and replace every occurrence.

| Find | Replace with | Notes |
| --- | --- | --- |
| `uams-plugin-template` | the plugin slug | File name `uams-plugin-template.php`, the text domain, the `.pot` file name, `composer.json` package name, `scripts/build-zip.mjs`, `.gitattributes`, `phpcs.xml.dist`, `phpstan.neon.dist`, `rector.php`, `phpunit.xml`, `tests/` |
| `UAMSWeb\PluginTemplate` and `UAMSWeb\\PluginTemplate` | the plugin's namespace (see below) | `includes/`, `includes/autoload.php`, `tests/`, `composer.json`, `phpcs.xml.dist` |
| `uams_plugin_template` and `UAMS_PLUGIN_TEMPLATE` | the plugin's prefix | Options, hooks, constants, the test database name |
| `UAMS Plugin Template` | the plugin's name | Header, `readme.txt`, `.pot`, page titles, `docs/wiki/` |
| `UAMS-Web/wordpress-plugin-template` | the plugin's repository | Links in `README.md` and `docs/wiki/`, the header's `Plugin URI` |

## 2. Choose the namespace

Make it `UAMSWeb\Aether\<Product>` or `UAMSWeb\Aether\<Family>\<Product>` for a plugin in the Aether ecosystem, and `UAMSWeb\<Product>` for one outside it; the family level is optional. The prefix can be any depth, because [PSR-4](https://www.php-fig.org/psr/psr-4/) allows it, so the files under `includes/` do not move when the prefix changes. Three rules keep two packages from colliding:

- A prefix has one owner or none. Two packages never map the same one, and no package maps a bare family prefix: `UAMSWeb\Aether\Forms\Settings\` and `UAMSWeb\Aether\Forms\Multisite\` are two packages' prefixes, and nobody maps `UAMSWeb\Aether\Forms\`.
- A package may own a prefix with a companion nested inside it, but then the outer package has no directory under `includes/` named after the inner one. Composer picks the longest matching prefix, so an inner `UAMSWeb\People\Listings\` package is reached only if the outer `UAMSWeb\People\` package has no `includes/Listings/`.
- The template's own placeholder is `UAMSWeb\PluginTemplate`, the shape for a plugin outside the Aether ecosystem. A plugin in the Aether ecosystem renames it to `UAMSWeb\Aether\<Product>` instead.

## 3. Change the autoloader's prefix too

The plugin loads its classes with its own small autoloader (`includes/autoload.php`), not Composer's, because a branch deploy has no `vendor/`. That changes two things:

- The prefix is a string in `includes/autoload.php` as well as in `composer.json`, which maps only `autoload-dev` (the tests), so change both and keep them in step.
- The autoloader maps one prefix to `includes/` and does no longest-prefix matching, so the no-directory-under-`includes/` rule above is the only thing that keeps an outer plugin from claiming an inner plugin's classes.

## Go further

- [Create a plugin from this template (README)](https://github.com/UAMS-Web/wordpress-plugin-template#create-a-plugin-from-this-template): the steps after the rename.
- [Troubleshooting](Troubleshooting.md): what a missed rename looks like.
