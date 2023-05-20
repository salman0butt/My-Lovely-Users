<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test\Unit;

use Inpsyde\MyLovelyUsers\Includes\EndpointRegistration;
use Inpsyde\MyLovelyUsers\Test\Unit\AbstractTestCase;
use Brain\Monkey;

class EndpointRegistrationTest extends AbstractTestCase
{

    private EndpointRegistration $endpointRegistration;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the get_option function.
        Monkey\Functions\when('get_option')
            ->justReturn(false);

        Monkey\Functions\when('sanitize_text_field')
            ->justReturn('my-lovely-users-table');

        // Expect the add_rewrite_rule function to be called.
        Monkey\Functions\expect('add_rewrite_rule')
            ->once()
            ->with(
                'my-lovely-users-table',
                'index.php?my_lovely_users_table=1',
                'top'
            );

        // Expect the add_rewrite_tag function to be called.
        Monkey\Functions\expect('add_rewrite_tag')
            ->once()
            ->with('%my_lovely_users_table%', '1');

        // Expect the flush_rewrite_rules function to be called.
        Monkey\Functions\expect('flush_rewrite_rules')
            ->once();

        $this->endpointRegistration = new EndpointRegistration();
    }

    /**
     * Test registerCustomEndpoint method.
     */
    public function testRegisterCustomEndpoint()
    {

        $this->endpointRegistration->registerCustomEndpoint();

        // Assert that the method execution completes without throwing an exception.
        $this->expectNotToPerformAssertions();
    }

}
