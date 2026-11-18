Written against the unreleased `main` branch.

A plugin made from the template publishes a GitHub release for each version, and the release carries an upload ZIP for a site that installs by hand. The template itself publishes no releases.

**In a plugin made from this template:** replace `uams-plugin-template` and `UAMS_PLUGIN_TEMPLATE_VERSION` below with the plugin's own slug and constant, as [Renaming the template](Renaming-the-template.md) does everywhere else.

## Steps

1. Raise `Version` in the plugin header, and `Stable tag` and the changelog in `readme.txt`. The main file reads `UAMS_PLUGIN_TEMPLATE_VERSION` from the header with `get_file_data()`, so the header is the one place the number is written.
2. Merge to `main`, then publish a GitHub release whose tag is the version (`v1.2.3`).
3. `release.yml` runs the download-archive check, builds `uams-plugin-template-1.2.3.zip` from the tag with the download keep-list, and attaches it to the release.

To build the ZIP locally, run `composer build`. It lands in `build/`, which is ignored.

**Note:** sites deploy a branch through WP Pusher, so nothing is built at deploy time and no `dist/` directory is committed. Runtime libraries the plugin needs are committed.

## Reference

- [Adding a runtime folder](Adding-a-runtime-folder.md): the keep-list the ZIP is built from.
- [Troubleshooting](Troubleshooting.md#no-version-header-in-uams-plugin-templatephp): what `composer build` prints when it cannot read the version.
