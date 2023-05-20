<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test\Unit;

use Brain\Monkey;
use Inpsyde\MyLovelyUsers\Includes\Setting;
use Inpsyde\MyLovelyUsers\Test\Unit\AbstractTestCase;
class SettingTest extends AbstractTestCase
{

    private Setting $setting;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an instance of the Setting class
        $this->setting = new Setting();

        // Mock the register_setting() function
        Monkey\Functions\expect('register_setting')
        ->once()
        ->with(
            'my_lovely_users_settings',
            'my_lovely_users_endpoint'
        );
    }

    /**
     * Test saveSettings method.
     */
    public function testSaveSettings()
    {
        // Call the saveSettings() method
        $this->setting->saveSettings();

       // Assert that the method execution completes without throwing an exception.
       $this->expectNotToPerformAssertions();
    }

}
