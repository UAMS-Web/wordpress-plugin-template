Written against the unreleased `main` branch.

The template ships one example screen, **Settings > UAMS Plugin Template**, which saves a single text option. It exists to show WordPress's [Security APIs](https://developer.wordpress.org/apis/security/) in use, each covered by a test: a capability check, a nonce, input sanitized on the way in, and output escaped on the way out.

**In a plugin made from this template:** delete the example screen once the plugin has its own, keep the pattern below, and rewrite this page as the reference for the plugin's own settings.

## Where it lives

| File | Role |
| --- | --- |
| `includes/Plugin.php` | `Plugin::boot()` registers every hook: the text domain on `init`, the page on `admin_menu`, the setting on `admin_init`, and the save handler on `admin_post_uams_plugin_template_save`. |
| `includes/Settings.php` | The page, the setting, the sanitizer and the save handler. |
| `uninstall.php` | Deletes the option, on every site of a multisite. |
| `tests/Unit/SettingsTest.php` | The unit tests, with Brain Monkey and no WordPress. |
| `tests/Integration/SettingsTest.php` | The integration tests, against a real WordPress and database. |

## Names

| Constant | Value | Used for |
| --- | --- | --- |
| `Settings::ACTION` | `uams_plugin_template_save` | The admin-post action and the nonce action |
| `Settings::NONCE` | `uams_plugin_template_nonce` | The nonce field name |
| `Settings::CAPABILITY` | `manage_options` | Who may view the page and save the setting |
| `Settings::OPTION` | `uams_plugin_template_greeting` | The option that holds the value |
| `Settings::PAGE` | `uams-plugin-template` | The menu and page slug |

## The pattern

1. **Check the capability first.** Both `render_page()` and `handle_save()` call `current_user_can()` and stop with a `403` through `wp_die()` when it fails.
2. **Verify the nonce.** The form prints one with `wp_nonce_field()`, and `handle_save()` checks it with `check_admin_referer()` before it reads any input.
3. **Sanitize on the way in.** The submitted value goes through `wp_unslash()` and `sanitize_text_field()`, and the registered setting's `sanitize_callback` applies `sanitize_text_field()` too.
4. **Escape on the way out.** Every dynamic value is escaped where it is printed: `esc_html()`, `esc_attr()` and `esc_url()`.
5. **Redirect after saving.** `handle_save()` sends the browser back to the page with `wp_safe_redirect()`.

## Data the plugin keeps

| Option | Written by | Removed by |
| --- | --- | --- |
| `uams_plugin_template_greeting` | the settings screen | `uninstall.php` |
| `uams_plugin_template_version` | activation, the first time (the version, so a later release can tell which migrations to run) | `uninstall.php` |

Activation and deactivation never delete data; `uninstall.php` is the one place it is removed. Deactivation clears the `uams_plugin_template_cron` scheduled hook.
