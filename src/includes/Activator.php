<?php

/**
 * Fired during plugin activation
 *
 * This class handles all code necessary to run during the plugin's activation.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Exception;

class Activator
{
    /**
     * Activate the plugin.
     *
     * If the option 'my_lovely_users_endpoint' does not exist, it adds the option with the value
     * of MY_LOVELY_USERS_ENDPOINT. Then, it flushes the rewrite rules.
     *
     * @since 1.0.0
     */
    public static function activate(): void
    {
        try {
            // If the option does not exist, add it
            if (!get_option('my_lovely_users_endpoint')) {
                self::addEndpointOption();
            }
            // Flush rewrite rules on activation
            self::flushRewriteRules();
        } catch (Exception $exception) {
            // Handle the error or exception here
            error_log('Error: ' . $exception->getMessage());
        }
    }

    /**
     * Add the option for the endpoint value.
     *
     * @since 1.0.0
     */
    private static function addEndpointOption(): void
    {
        $optionName = 'my_lovely_users_endpoint';
        $endpointValue = self::endpointValue();

        // Add the option with the sanitized endpoint value
        add_option($optionName, sanitize_text_field($endpointValue));
    }

    /**
     * Get the value for the endpoint constant.
     *
     * @return string
     * @since 1.0.0
     */
    private static function endpointValue(): string
    {
        // You can define or retrieve the value of MY_LOVELY_USERS_ENDPOINT here
        return MY_LOVELY_USERS_ENDPOINT;
    }

    /**
     * Flush rewrite rules.
     *
     * @throws Exception If flushing rewrite rules fails.
     * @since 1.0.0
     */
    private static function flushRewriteRules(): void
    {
        if (!flush_rewrite_rules()) {
            throw new Exception('Flushing rewrite rules failed.');
        }
    }
}
