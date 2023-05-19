<?php

/**
* Interface for rendering users
*
*/

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserRendererInterface
{
    /**
     * Renders an array of user data as an HTML string.
     *
     * @param array $users An array of user data to render.
     * @param string $type An string of type.
     * @return string The rendered HTML string.
     */
    public function render(array $users, string $type): string;
}
