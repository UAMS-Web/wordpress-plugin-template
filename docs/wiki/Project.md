Where the template is developed, why it is the way it is, and how to report a problem.

**In a plugin made from this template:** replace `UAMS-Web/wordpress-plugin-template` in these links with the plugin's repository.

- [Report a problem](https://github.com/UAMS-Web/wordpress-plugin-template/issues): an issue in the repository, with what happened and what you expected.
- [Contributing](https://github.com/UAMS-Web/wordpress-plugin-template/blob/main/CONTRIBUTING.md): the path from an issue to a merged pull request, and the checks to run first.
- [Decision log](https://github.com/UAMS-Web/wordpress-plugin-template/blob/main/docs/DECISIONS.md): the decisions that have closed, with their reasons and the alternatives rejected. Read it before reopening a settled choice.
- [Repository](https://github.com/UAMS-Web/wordpress-plugin-template): the code, and `docs/wiki/`, where these pages are edited.

## Editing these pages

The pages live in `docs/wiki/` and are published to this wiki by the **Publish wiki** workflow (`.github/workflows/publish-wiki.yml`), run by hand from the repository's Actions tab. Each run replaces the whole wiki with the folder, so a page edited in the browser is overwritten by the next run.

- Keep the folder flat: page names are unique across the wiki, and pages in a subfolder are not rewritten.
- Link between pages with relative links that carry the extension (`[Troubleshooting](Troubleshooting.md)`); the publish turns them into wiki links.
- Link a file elsewhere in the repository, an issue or a pull request with its full URL.
- Keep Home, the sidebar and the footer listing the same pages under the same labels.
