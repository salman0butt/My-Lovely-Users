<?php

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface UserDetailsInterface
{
    /**
     * Registers AJAX action to handle fetching user details.
     */
    public function register(): void;

    /**
     * Renders user details.
     *
     * @param mixed $user The user details.
     */
    public function render($user): void;

    /**
     * Handles AJAX request to fetch user details.
     */
    public function handleAjaxRequest(): void;
}
