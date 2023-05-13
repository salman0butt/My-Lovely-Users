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

class UserDetailRenderer implements UserRendererInterface
{
    /**
     * Render a table of users.
     *
     * @param array $users An array of user data.
     *
     * @return string The HTML for the rendered table.
     */
    public function render(array $user): string
    {
        // Create the table header.
        $header = '<thead>
            <tr>
                <th>' . esc_html__('ID', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Name', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Username', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Email', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Phone', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Website', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Company', 'my-lovely-users') . '</th>
                <th>' . esc_html__('Address', 'my-lovely-users') . '</th>
            </tr>
        </thead>';
// Create the table body.
        $body = '<tbody>
            <tr>
                <th scope="row">' . (isset($user['id']) ? esc_html($user['id']) : '') . '</th>
                <td>' . (isset($user['name']) ? esc_html($user['name']) : '') . '</td>
                <td>' . (isset($user['username']) ? esc_html($user['username']) : '') . '</td>
                <td>' . (isset($user['email']) ? esc_html($user['email']) : '') . '</td>
                <td>' . (isset($user['phone']) ? esc_html($user['phone']) : '') . '</td>
                <td>' . (isset($user['website']) ? esc_html($user['website']) : '') . '</td>
                <td>' . (isset($user['company']['name']) ? esc_html($user['company']['name']) : '') . '<br>' .
                        (isset($user['company']['catchPhrase']) ? esc_html($user['company']['catchPhrase']) : '') . '<br>' .
                        (isset($user['company']['bs']) ? esc_html($user['company']['bs']) : '') . '</td>
                <td>' . (isset($user['address']['street']) ? esc_html($user['address']['street']) : '') . '<br>' .
                        (isset($user['address']['suite']) ? esc_html($user['address']['suite']) : '') . '<br>' .
                        (isset($user['address']['city']) ? esc_html($user['address']['city']) : '') . '<br>' .
                        (isset($user['address']['zipcode']) ? esc_html($user['address']['zipcode']) : '') . '<br>' .
                        (isset($user['address']['geo']['lat']) ? esc_html($user['address']['geo']['lat']) : '') . '<br>' .
                        (isset($user['address']['geo']['lng']) ? esc_html($user['address']['geo']['lng']) : '') . '<br>' .
                        '</td>
            </tr>
            </tbody>';
// Create the final HTML output.
        $html = '<h3 class="text-center mb-4">' . esc_html__('User Detail', 'my-lovely-users') . '</h3>';
        $html .= '<div class="table-container">';
        $html .= '<table id="users-details">';
        $html .= $header;
        $html .= $body;
        $html .= '</table>';
        $html .= '</div>';
        
        return $html;
    }
}
