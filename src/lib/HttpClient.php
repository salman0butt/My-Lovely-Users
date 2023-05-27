<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Lib;

use Inpsyde\MyLovelyUsers\Exceptions\HttpClientException;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

/**
 * Class HttpClient
 *
 * Implementation of the HttpClientInterface using the WordPress HTTP API.
 */
class HttpClient implements HttpClientInterface
{
    /**
     * Sends a GET request to the specified URL and returns the response as an array.
     *
     * @param string $url The URL to send the GET request to.
     *
     * @return array The response data as an associative array.
     *
     * @throws HttpClientException If the HTTP request fails or if the response has an error.
     */
    public function get(string $url): array
    {
        // Send the GET request using the WordPress HTTP API
        $response = wp_remote_get($url);

        // Check if the response is a WordPress error object
        if (is_wp_error($response)) {
            throw new HttpClientException(
                sprintf('HTTP request failed: %s', $response->get_error_message())
            );
        }

        // Retrieve the response status code
        $statusCode = wp_remote_retrieve_response_code($response);

        // Check if the status code is not 200 (OK)
        if ($statusCode !== 200) {
            throw new HttpClientException(
                sprintf('HTTP request failed with status code %d', $statusCode)
            );
        }

        // Retrieve the response body
        $body = wp_remote_retrieve_body($response);

        // Check if the response body is empty
        if (!$body) {
            throw new HttpClientException('HTTP response body is empty');
        }

        // Decode the response body as JSON
        $data = json_decode($body, true);

        // Check if there was an error while decoding the JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpClientException(
                sprintf('Failed to decode JSON response: %s', json_last_error_msg())
            );
        }

        // Return the decoded JSON response as an array
        return $data;
    }
}
