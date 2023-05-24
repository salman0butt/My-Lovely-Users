<?php

/**
 * Interface for plugin settings.
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface SettingInterface
{
     /**
     * Register the hooks for settings.
     *
     * @return void
     */
    public function register(): void;
    /**
    * Define the settings page.
    *
    * @return void
    */
    public function settingsPage(): void;

    /**
    * Display the settings page.
    *
    * @return void
    */
    public function displayPage(): void;

    /**
     * Save the plugin settings.
     *
     * @return void
     */
    public function saveSettings(): void;
}
