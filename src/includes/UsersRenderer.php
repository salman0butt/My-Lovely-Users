<?php

/**
 * Class UsersRenderer
 *
 * This class is responsible for rendering a table of users.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;

class UsersRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array $users An array of user data.
     *
     * @return string The HTML for the rendered table.
     */
    public function render(array $users): string
    {
        // Create the table header.
        $header = '<thead>
                        <tr>
                            <th>' . esc_html__('ID', 'my-lovely-users') . '</th>
                            <th>' . esc_html__('Name', 'my-lovely-users') . '</th>
                            <th>' . esc_html__('Username', 'my-lovely-users') . '</th>
                            <th>' . esc_html__('Email', 'my-lovely-users') . '</th>
                        </tr>
                    </thead>';
// Create the table body.
        $body = '<tbody>';
        if ($users && count($users) > 0) {
            foreach ($users as $user) {
                $body .= '<tr>';
                $body .= '<td>';
                $body .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $body .= isset($user['id']) ? esc_html($user['id']) : '';
                $body .= '</a>';
                $body .= '</td>';
                $body .= '<td>';
                $body .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $body .= isset($user['name']) ? esc_html($user['name']) : '';
                $body .= '</a>';
                $body .= '</td>';
                $body .= '<td>';
                $body .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $body .= isset($user['username']) ? esc_html($user['username']) : '';
                $body .= '</a>';
                $body .= '</td>';
                $body .= '<td>';
                $body .= '<a href="#" class="user-details-link" data-user-id="' . (isset($user['id']) ? esc_attr($user['id']) : '') . '">';
                $body .= isset($user['email']) ? esc_html($user['email']) : '';
                $body .= '</a>';
                $body .= '</td>';
                $body .= '</tr>';
            }
        }

        $body .= '</tbody>';
        // Create the final HTML output.
        $html = '<h3 style="text-align:center; margin-bottom: 10px !important;">' . esc_html__('My Lovely Users Table', 'my-lovely-users') . '</h3>';
        $html .= '<div class="table-container">';
        $html .= '<table id="users-table">';
        $html .= $header;
        $html .= $body;
        $html .= '</table>';
        $html .= '</div>';
        // User details will be displayed here via AJAX 
        $html .= '<div id="user-details-container"></div>';

        return $html;
    }
}
