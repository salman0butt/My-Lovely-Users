<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test;

use Brain\Monkey;
use Inpsyde\MyLovelyUsers\Test\AbstractTestCase;
use Inpsyde\MyLovelyUsers\Includes\UsersRenderer;

class UsersRendererTest  extends AbstractTestCase
{

    private UsersRenderer $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the plugin_dir_path() function
        Monkey\Functions\when('plugin_dir_path')->justReturn(dirname(__DIR__).'\..\..\src');
        Monkey\Functions\when('esc_html__')->returnArg();
        Monkey\Functions\when('esc_html')->returnArg();

        $this->renderer = new UsersRenderer();
    }

    public function testRender(): void
    {
        // Create a mock user data array
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com'
            ],
            [
                'id' => 2,
                'name' => 'Jane Doe 2',
                'username' => 'janedoe2',
                'email' => 'janedoe2@example.com'
            ],
        ];


        // Call the render method and capture the output
        $output = $this->renderer->render(compact('users'), 'table');

        // Assert that the output contains the expected HTML
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('John Doe', $output);
        $this->assertStringContainsString('johndoe', $output);
        $this->assertStringContainsString('johndoe@example.com', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Jane Doe 2', $output);
        $this->assertStringContainsString('janedoe2', $output);
        $this->assertStringContainsString('janedoe2@example.com', $output);
    }

    public function testSingleUserRender(): void
    {
        // Create a mock user data
        $user = [
            'id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com'
        ];

        // Call the render method and capture the output
        $output = $this->renderer->render(compact('user'), 'details');

        // Assert that the output contains the expected HTML
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('John Doe', $output);
        $this->assertStringContainsString('johndoe', $output);
        $this->assertStringContainsString('johndoe@example.com', $output);
    }
}
