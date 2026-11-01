# Agent notes

This repository is a GitHub template for UAMS-Web WordPress plugins. It is not a sync target: the sync delivers shared skills and rules to a plugin once that plugin is onboarded.

- Read `README.md` for the layout and commands, and `docs/DECISIONS.md` before changing a settled choice.
- Everything the plugin runs is listed in the keep-list in `.gitattributes`. A new runtime folder needs its `-export-ignore` line, and `composer check:archive` must pass.
- The unit suite (Pest) never loads WordPress. The integration suite (PHPUnit 9.6) has its own `composer.json` in `tests/Integration/` and drops its test database's tables on every run.
