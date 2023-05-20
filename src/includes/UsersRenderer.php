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
use RuntimeException;

class UsersRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array  $data An array of user data.
     * @param string $type The type of rendering to perform ('table' or 'details').
     *
     * @return string The HTML for the rendered table.
     * @throws \RuntimeException If an invalid rendering type is provided or the template file cannot be found or included.
     */
    public function render(array $data, string $type): string
    {
        $templatePath = $this->getTemplatePath($type);
        
        if (!file_exists($templatePath)) {
            throw new RuntimeException('Template file not found.');
        }

        return $this->includeTemplate($templatePath, $data);
    }

    /**
     * Get the template path based on the rendering type.
     *
     * @param string $type The type of rendering to perform ('table' or 'details').
     *
     * @return string The path to the template file.
     * @throws \RuntimeException If an invalid rendering type is provided.
     */
    private function getTemplatePath(string $type): string
    {
        $templateDirectory = plugin_dir_path(__FILE__) . '/../templates/';

        switch ($type) {
            case 'table':
                return $templateDirectory . 'users-table.php';
            case 'details':
                return $templateDirectory . 'users-detail.php';
            default:
                throw new RuntimeException('Invalid rendering type.');
        }
    }

    /**
     * Include the template file and return the rendered content.
     *
     * @param string $templatePath The path to the template file.
     * @param array  $data         An array of data to pass to the template.
     *
     * @return string The rendered content.
     * @throws \RuntimeException If the template file cannot be included.
     */
    private function includeTemplate(string $templatePath, array $data): string
    {
        ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
    }
}
