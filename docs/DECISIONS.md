# Decision log

The canonical record of why the template is the way it is: the reasoning and the rejected alternatives behind decisions that have closed. It guards against silently reopening a settled decision.

**Consult it before acting.** Before proposing a change, reopening a question or picking an approach, check here first.

**When a decision closes, record the verdict in both places.** Here (the cross-ticket index) and in the GitHub issue's `## Decision` section (the per-ticket record).

## How to add an entry

Entries run oldest first, so a new entry is appended to the end of the file. Every heading is `## YYYY-MM-DD`, a space, and a short title, with exactly one blank line above it.

```markdown
## YYYY-MM-DD <short decision title> (<#issue or area>)

**Decision.** <what was decided>

**Why.** <the reasoning that settled it>

**Rejected.** <the alternatives considered, and why each lost>

**Companion.** <link to the docs/ companion or the GitHub issue>
```

## 2026-10-30 First version of the template (#1)

**Decision.** A plugin made from the template is public by default, with checks in GitHub Actions; the README documents the switch to the shared local CI runner for a private plugin. Sites deploy a branch through WP Pusher, so runtime libraries are committed and nothing is built at deploy time; a script builds the upload ZIP and a workflow attaches it to a GitHub release, with no `dist/` directory committed. The release workflow, `release.yml`, builds it.

**Why.** Most new plugins are expected to be public, where Actions minutes are free. A branch install needs no build step, and a release ZIP serves a manual upload.

**Rejected.** Private by default with the local CI runner (kept as the documented switch). A committed `dist/` ZIP (every change to a packaged file conflicts on the binary). Branch only with no ZIP (no artifact for a manual upload). Deriving the template from `UAMS-Web/uamswp-search` (carries that plugin's code and history into every new plugin).

**Companion.** https://github.com/UAMS-Web/wordpress-plugin-template/issues/1

## 2026-10-31 Choices the build made (#1)

**Decision.**

- **Names.** Slug and text domain `uams-plugin-template`, namespace `UAMSWeb\PluginTemplate`, prefix `uams_plugin_template` (constants `UAMS_PLUGIN_TEMPLATE_`). The README lists every place to rename.
- **WordPress pin.** The integration suite pins `wp-phpunit` `~7.0.0` and CI downloads WordPress 7.0.8: two UAMS sites (`uamshealth.com`, `medicine.uams.edu`) served core asset version `7.0.8` on 2026-10-31. `uams.edu` hides its version and was not measured. The header's `Requires at least` stays 6.9, the oldest the example code works on.
- **No Composer autoloader at runtime.** The plugin loads its classes with a small PSR-4 autoloader in `includes/autoload.php`, so the deployed branch needs no `vendor/` directory. Composer holds development tools only.
- **The archive check is a copy.** This repository is not a sync target, so `scripts/check-download-archive.mjs` is a verbatim copy of the shared download-archive check. A plugin that onboards to the sync takes the synced copy and may delete this one.
- **No shared sync files.** The template carries no `.claude/`, `.agents/` or `.cursor/` files: the sync delivers them when a plugin is onboarded.
- **Multisite.** The integration suite runs in Actions both as a single site and as a multisite (`WP_MULTISITE=1`).

**Why.** Each follows from the ticket's decision and the shared WordPress standard.

**Rejected.** Pinning WordPress 7.1, the latest, because the measured sites run 7.0.8. Committing Composer's `vendor/` for the autoloader, which would put development tooling beside runtime code.

**Companion.** https://github.com/UAMS-Web/wordpress-plugin-template/issues/1

## 2026-10-31 WordPress.org directory guidelines the template leaves out (#1)

**Decision.** The directory guidelines bind only plugins published on WordPress.org, which these are not. The template follows the ones that are also good practice: no bundled libraries WordPress already ships, no remote code, local assets. It leaves out:

- **The `readme.txt` `Contributors` list naming WordPress.org accounts.** It names `uams`, a placeholder, because no plugin here is published there.
- **WordPress.org's rule against a plugin updating itself from outside the directory.** `Update URI: false` blocks updates from the directory, and updates arrive by WP Pusher or a manual ZIP upload.
- **The 64-character plugin-slug and trademark review.** A UAMS plugin's name is the institution's own.
- **A `languages/` folder left to WordPress.org's translation service.** The plugin loads its own translations with `load_plugin_textdomain()`, which WordPress.org plugins no longer need.

**Why.** Following them would add steps with no reader.

**Rejected.** Treating the directory guidelines as binding for every plugin.

**Companion.** https://github.com/UAMS-Web/wordpress-plugin-template/issues/1
