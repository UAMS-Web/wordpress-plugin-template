The UAMS Plugin Template is the starting point for a UAMS-Web WordPress plugin. A plugin made from it passes the shared WordPress standard on its first commit.

This wiki holds the long-form documentation: renaming the template, the task guides, the reference and troubleshooting. The [README](https://github.com/UAMS-Web/wordpress-plugin-template#readme) keeps the overview, what is in the repository, how to create a plugin from the template, and the development commands.

**In a plugin made from this template:** these pages arrive with it in `docs/wiki/`. Replace this paragraph and the one above with what the plugin does and who it is for, delete [Renaming the template](Renaming-the-template.md) once the rename is done, and keep the other pages as a starting point: each one says which parts a new plugin replaces. Keep Home, the sidebar and the footer listing the same pages under the same labels.

## Getting started

- [Create a plugin from this template (README)](https://github.com/UAMS-Web/wordpress-plugin-template#create-a-plugin-from-this-template): the steps from **Use this template** to a green first commit.
- [Renaming the template](Renaming-the-template.md): every name to replace, and the rules for choosing the namespace.

## Guides

- [Adding a runtime folder](Adding-a-runtime-folder.md): put a new folder in the download and keep the keep-list check passing.
- [Cutting a release](Cutting-a-release.md): raise the version, publish a release, and get the upload ZIP.
- [Making a plugin private](Making-a-plugin-private.md): move the checks from GitHub Actions to the local runner.

## Troubleshooting

- [Troubleshooting](Troubleshooting.md): one entry per message or behavior, with its cause and fix.

## Reference

- [Continuous integration](Continuous-integration.md): the jobs in `ci.yml`, the shared chain it calls, and the `CI` check.
- [The settings example](The-settings-example.md): the example screen and the security pattern it shows.

## Project

- [Project](Project.md): where the template is developed, the decision log, and how to report a problem.
