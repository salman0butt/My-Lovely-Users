<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers;

use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    public function get(string $url): array
    {
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            throw new \RuntimeException(
                sprintf('HTTP request failed: %s', $response->get_error_message())
            );
        }
        $statusCode = wp_remote_retrieve_response_code($response);
        if ($statusCode !== 200) {
            throw new \RuntimeException(
                sprintf('HTTP request failed with status code %d', $statusCode)
            );
        }
        $body = wp_remote_retrieve_body($response);
        if (!$body) {
            throw new \RuntimeException('HTTP response body is empty');
        }
        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(
                sprintf('Failed to decode JSON response: %s', json_last_error_msg())
            );
        }
        return $data;
    }
}
