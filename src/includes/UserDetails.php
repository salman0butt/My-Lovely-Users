<?php
/**
 * UserDetails class provides functionality to fetch user details via AJAX request and render them.
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 * @package    MyLovelyUsers
 * @subpackage MyLovelyUsers\includes
 * @author     Salman Raza <salman0butt@gmail.com>
*/
declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Includes;

use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;

class UserDetails
{
    /**
     * UserFetcher instance to fetch user details.
     *
     * @var UserFetcherInterface
    */
    private UserFetcherInterface $userFetcher;

    /**
     * UserRenderer instance to render user details.
     *
     * @var UserRendererInterface
    */
    private UserRendererInterface $userDeatilRenderer;

    /**
     * UserDetails constructor.
     *
     * @param UserFetcherInterface $userFetcher
     * @param UserRendererInterface $userDeatilRenderer
    */
    public function __construct(UserFetcherInterface $userFetcher, UserRendererInterface $userDeatilRenderer)
    {
        $this->userFetcher = $userFetcher;
        $this->userDeatilRenderer = $userDeatilRenderer;
    }

    /**
     * Registers AJAX action to handle fetching user details.
    */
    public function register(): void
    {

        add_action('wp_ajax_fetch_user_details', [$this, 'handleAjaxRequest']);
        add_action(
            'wp_ajax_nopriv_fetch_user_details',
            [$this, 'handleAjaxRequest']
        );
    }

    /**
     * Renders user details using the UserRenderer instance.
     *
     * @param $user
     */
    public function render($user): void
    {
        $this->userDeatilRenderer->render($user);
       
    }


    /**
     * Handles AJAX request to fetch user details.
    */
    public function handleAjaxRequest(): void
    {
        // Sanitize the user_id and nonce.
        $userId = intval(filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT));
        $nonce = sanitize_key($_POST['my_plugin_nonce']);

        // Check if user ID is valid.
        if (!$userId) {
            wp_send_json_error("Invalid user ID.");
        }

        // Verify nonce to prevent CSRF attacks.
        $nonceVerified = isset($nonce) && wp_verify_nonce($nonce, 'my_lovely_user_nonce');

        if (!$nonceVerified) {
            wp_send_json_error('Security check failed.');
        }


        try {
             // Fetch user details using the UserFetcher instance.
            $user = $this->userFetcher->fetchUser($userId);
            // Render user details using the UserRenderer instance.
            $output = $this->userDeatilRenderer->render($user);
            wp_send_json_success($output);
        } catch (\Exception $exp) {
            error_log("Error fetching user details: " . $exp->getMessage());
            wp_send_json_error("Something went wrong.");
        }
    }
}
