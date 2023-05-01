<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test;
use Brain\Monkey;
use Inpsyde\MyLovelyUsers\Core;
use PHPUnit\Framework\TestCase;
use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class UserDetailsTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    public function testFetchUserDetailsCallbackReturnsValidUserDetails()
    {
        $cacheMock = $this->createMock(CacheInterface::class);
        $cacheMock
            ->expects($this->once())
            ->method('get')
            ->with('my_lovely_users_data_detail_1')
            ->willReturn('');

        $userDetails = [
            'id' => 1,
            'name' => 'Leanne Graham',
            'username' => 'Bret',
            'email' => 'Sincere@april.biz',
            'address' => [
                'street' => 'Kulas Light',
                'suite' => 'Apt. 556',
                'city' => 'Gwenborough',
                'zipcode' => '92998-3874',
                'geo' => [
                    'lat' => '-37.3159',
                    'lng' => '81.1496',
                ],
            ],
            'phone' => '1-770-736-8031 x56442',
            'website' => 'hildegard.org',
            'company' => [
                'name' => 'Romaguera-Crona',
                'catchPhrase' => 'Multi-layered client-server neural-net',
                'bs' => 'harness real-time e-markets',
            ],
        ];

        
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock
        ->expects($this->once())
        ->method('get')
        ->with('https://jsonplaceholder.typicode.com/users/1')
        ->willReturn($userDetails);

        // Mock Wordpress Functions
        Monkey\Functions\expect('wp_create_nonce')
            ->once()
            ->with('my_lovely_user_nonce')
            ->andReturn('my_mocked_nonce');

        Monkey\Functions\expect('wp_verify_nonce')
            ->once()
            ->with('my_mocked_nonce', 'my_lovely_user_nonce')
            ->andReturn(true);

        $_POST['user_id'] = '1';
        $_POST['my_plugin_nonce'] = wp_create_nonce('my_lovely_user_nonce');
        
        Monkey\Functions\when('esc_html__')->returnArg();
        Monkey\Functions\when('esc_html')->returnArg();
        Monkey\Functions\when('sanitize_text_field')->justReturn($_POST['my_plugin_nonce']);
        Monkey\Functions\when('wp_unslash')->justReturn($_POST['my_plugin_nonce']);
        Monkey\Functions\when('plugin_dir_path')->justReturn(dirname(__FILE__) . '/../../../src/');
        Monkey\Functions\when('wp_send_json_success')
            ->justReturn(['success' => true, 'data' => ['html' => '<h1>Expected Result<h1>']]);


        $core = new Core($cacheMock, $httpClientMock);
        $result = $core->fetchUserDetailsCallback();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertIsBool($result['success']);
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
        $this->assertArrayHasKey('html', $result['data']);
        $this->assertNotEmpty($result['data']['html']);
    }
}
