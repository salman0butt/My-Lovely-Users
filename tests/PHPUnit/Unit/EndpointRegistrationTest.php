<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test;

use Inpsyde\MyLovelyUsers\Includes\EndpointRegistration;
use Inpsyde\MyLovelyUsers\Test\AbstractTestCase;
use Brain\Monkey;

class EndpointRegistrationTest extends AbstractTestCase
{
    /**
     * Test registerCustomEndpoint method.
     */
    public function testRegisterCustomEndpoint()
    {
        // Mock the get_option function.
        Monkey\Functions\when('get_option')
            ->justReturn(false);

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

        $endpoint_registration = new EndpointRegistration();
        $endpoint_registration->registerCustomEndpoint();

        // Assert that the method execution completes without throwing an exception.
        $this->expectNotToPerformAssertions();
    }

}
