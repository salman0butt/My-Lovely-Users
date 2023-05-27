<?php

/**
 * Class UsersRenderer
 *
 * This class is responsible for rendering a table of users.
 *
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;
use Inpsyde\MyLovelyUsers\Exceptions\TemplateNotFoundException;

class UsersRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array $users An array of users data.
     *
     * @return string The HTML for the rendered table.
     * @throws TemplateNotFoundException If the template file cannot be found.
     */
    public function renderUsersTable(array $users): string
    {
        $templatePath = $this->getTemplatePath('users-table.php');

        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * Render a User Detail.
     *
     * @param array $user An array of user data.
     *
     * @return string The HTML for the rendered user detail.
     * @throws TemplateNotFoundException If the template file cannot be found.
     */
    public function renderUserDetail(array $user): string
    {
        $templatePath = $this->getTemplatePath('users-detail.php');

        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * Get the full path to the template file.
     *
     * @param string $template The template file name.
     *
     * @return string The full path to the template file.
     * @throws TemplateNotFoundException If the template file cannot be found.
     */
    private function getTemplatePath(string $template): string
    {
        $templatePath = plugin_dir_path(__FILE__) . '../templates/' . $template;

        if (!file_exists($templatePath)) {
            throw new TemplateNotFoundException('Template file not found: ' . $template);
        }

        return $templatePath;
    }
}
