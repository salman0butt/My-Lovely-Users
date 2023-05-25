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

use Exception;
use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserDetailsInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserFetcherInterface;
use Inpsyde\MyLovelyUsers\Interfaces\UserRendererInterface;

class UserDetails implements UserDetailsInterface
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
    private UserRendererInterface $userRenderer;

    /**
     * The logger to log
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UserDetails constructor.
     *
     * @param UserFetcherInterface $userFetcher UserFetcherInterface instance to fetch users.
     * @param UserRendererInterface $userRenderer UserRendererInterface instance to render users.
     * @param LoggerInterface $logger LoggerInterface instance to log.
     */
    public function __construct(
        UserFetcherInterface $userFetcher,
        UserRendererInterface $userRenderer,
        LoggerInterface $logger
    ) {

        $this->userFetcher = $userFetcher;
        $this->userRenderer = $userRenderer;
        $this->logger = $logger;
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
    public function render(array $user): void
    {
        $this->userRenderer->renderUserDetail($user);
    }

    /**
     * Handles AJAX request to fetch user details.
     */
    public function handleAjaxRequest(): void
    {
        try {
            // Sanitize the user_id and nonce.
            $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
            $nonce = isset($_POST['my_plugin_nonce']) ?
            sanitize_key($_POST['my_plugin_nonce']) :
            '';

            // Check if user ID is valid.
            if (!$userId) {
                throw new Exception('Invalid user ID.');
            }

            // Verify nonce to prevent CSRF attacks.
            $nonceVerified = isset($nonce) && wp_verify_nonce($nonce, 'my_lovely_user_nonce');

            if (!$nonceVerified) {
                throw new Exception('Security check failed.');
            }

            // Fetch user details using the UserFetcher instance.
            $user = $this->userFetcher->fetchUser($userId);
            // Render user details using the UserRenderer instance.
            $output = $this->userRenderer->renderUserDetail($user);

            wp_send_json_success($output);
        } catch (Exception $exception) {
            // Log the error message
            $this->logger->logError('An error occurred: ' . $exception->getMessage());
            wp_send_json_error("Something went wrong.");
        }
    }
}
