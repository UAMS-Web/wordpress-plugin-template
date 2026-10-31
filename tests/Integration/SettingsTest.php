<?php

/**
 * The settings page inside a real WordPress: what the Unit suite's mocks cannot see.
 *
 * A class-based PHPUnit 9.6 test, run from tests/Integration's own Composer
 * setup, because WordPress' test suite supports PHPUnit 9 only.
 *
 * @see includes/Settings.php
 */

declare(strict_types=1);

namespace UAMS\PluginTemplate\Tests\Integration;

use UAMS\PluginTemplate\Settings;
use UAMS\PluginTemplate\Tests\Support\IntegrationTestCase;
use WPDieException;

final class SettingsTest extends IntegrationTestCase
{
    public function test_registers_its_hooks(): void
    {
        $this->assertNotFalse(has_action('admin_menu', [Settings::class, 'register_page']));
        $this->assertNotFalse(has_action('admin_post_'.Settings::ACTION, [Settings::class, 'handle_save']));
    }

    public function test_sanitizes_the_option_on_update(): void
    {
        update_option(Settings::OPTION, '<b>Hi</b>');

        $this->assertSame('Hi', get_option(Settings::OPTION));
    }

    public function test_the_page_escapes_the_stored_greeting(): void
    {
        wp_set_current_user(self::factory()->user->create(['role' => 'administrator']));
        update_option(Settings::OPTION, 'a"b');

        ob_start();
        Settings::render_page();
        $html = (string) ob_get_clean();

        $this->assertStringContainsString('value="a&quot;b"', $html);
        $this->assertStringContainsString(Settings::NONCE, $html);
    }

    public function test_a_subscriber_cannot_view_the_page(): void
    {
        wp_set_current_user(self::factory()->user->create(['role' => 'subscriber']));
        add_filter('wp_die_handler', static fn (): callable => static function (): void {
            throw new WPDieException('denied');
        });

        $this->expectException(WPDieException::class);

        Settings::render_page();
    }

    public function test_a_save_without_a_valid_nonce_is_refused(): void
    {
        wp_set_current_user(self::factory()->user->create(['role' => 'administrator']));
        add_filter('wp_die_handler', static fn (): callable => static function (): void {
            throw new WPDieException('bad nonce');
        });
        $_POST['greeting'] = 'x';

        $this->expectException(WPDieException::class);

        try {
            Settings::handle_save();
        } finally {
            unset($_POST['greeting']);
        }
    }

    public function test_activation_records_the_version_and_uninstall_is_the_only_remover(): void
    {
        delete_option('uams_plugin_template_version');

        \UAMS\PluginTemplate\Plugin::activate();
        \UAMS\PluginTemplate\Plugin::deactivate();

        $this->assertSame(UAMS_PLUGIN_TEMPLATE_VERSION, get_option('uams_plugin_template_version'));
    }
}
