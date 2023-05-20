<?php

/**
 * This interface defines the methods required for the UserTableShortcode class.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 */

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserTableShortcodeInterface
{
    /**
     * Registers the hooks for the plugin settings.
     *
     * @return void
     */
    public function register(): void;

    /**
     * Renders the user table.
     *
     * @param string $atts Shortcode attributes.
     * @return string Rendered user table HTML.
     */
    public function renderUserTable(string $atts): string;
}
