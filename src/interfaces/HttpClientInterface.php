<?php
/**
 * Interface HttpClientInterface
 * 
 * An interface for HTTP clients.
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface HttpClientInterface
{
    /**
    * Get data from an API endpoint.
    * 
    * @param string $key The API endpoint key.
    * 
    * @return array An array of data retrieved from the API.
    */
    public function get(string $key): array;
}
