<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://github.com/salman0butt
 * @since      1.0.0
 *
 * @package    My_Lovely_Users
 * @subpackage My_Lovely_Users/includes
 */

 declare(strict_types=1);

 namespace Inpsyde\MyLovelyUsers;

class MyLovelyUsersLoader
{
    protected $actions;

    protected $filters;

    public function __construct()
    {

        $this->actions = [];
        $this->filters = [];
    }

    public function addAction(string $hook, array $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        $this->actions = $this->add($this->actions, $hook, $callback, $priority, $acceptedArgs);
    }

    public function addFilter(string $hook, array $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        $this->filters = $this->add($this->filters, $hook, $callback, $priority, $acceptedArgs);
    }

    private function add(array $hooks, string $hook, array $callback, int $priority, int $acceptedArgs): array
    {

        $hooks[] = [
            'hook' => $hook,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $acceptedArgs,
        ];

        return $hooks;
    }

    public function run(): void
    {

        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
