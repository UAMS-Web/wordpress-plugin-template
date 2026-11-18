Written against the unreleased `main` branch.

The plugin needs a new folder at run time (`assets/`, `templates/`, a committed library), and it has to reach the sites that install the plugin.

## Why the download needs a keep-list

Sites install a branch download through WP Pusher, and a server may serve the plugin folder for every file type but PHP. A branch download and the release ZIP are both `git archive`, so they hold every file in the repository unless `.gitattributes` leaves it out. The template's `.gitattributes` therefore excludes everything and names back only what the plugin runs:

```gitattributes
/* export-ignore
/.* export-ignore
/uams-plugin-template.php -export-ignore
/uninstall.php -export-ignore
/readme.txt -export-ignore
/LICENSE -export-ignore
/includes -export-ignore
/includes/** -export-ignore
/languages -export-ignore
/languages/** -export-ignore
```

The first two lines exclude every top-level entry, dot-entries included. Each `-export-ignore` line after them puts one runtime path back.

## Steps

1. Add the folder and its files.
2. Add two lines to the keep-list in `.gitattributes`, one for the folder and one for everything under it, in the same change:

   ```gitattributes
   /assets -export-ignore
   /assets/** -export-ignore
   ```

3. Commit, then run `composer check:archive`. It runs `git archive` on `HEAD`, prints how many files the download holds, and ends with `PASS` when nothing in it is configuration, documentation, tests or build tooling.
4. Confirm the new folder is in the download: `git archive HEAD | tar -t | grep '^assets/'` lists its files. A folder missing from the keep-list is missing from every install, and the check above does not report a missing runtime file.

**Note:** the check reads `HEAD`, so a folder that is not yet committed is not in what it checks.

## Reference

- [Troubleshooting](Troubleshooting.md#fail-files-in-the-download-are-not-what-the-plugin-runs): what the check prints when the download holds something it should not.
- [Continuous integration](Continuous-integration.md): the download-archive check the `checks` call runs on every pull request.
