<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test\Unit;

use Inpsyde\MyLovelyUsers\Includes\UserFetcher;
use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Inpsyde\MyLovelyUsers\Test\Unit\AbstractTestCase;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class UserFetcherTest extends AbstractTestCase
{
    private CacheInterface $cacheMock;
    private HttpClientInterface $httpClientMock;
    private LoggerInterface $loggerMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock cache service
        $this->cacheMock = $this->createMock(CacheInterface::class);
        $this->cacheMock->expects($this->any())
            ->method('get')->willReturn(null);

        // Create a mock HTTP client
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);

        // Create a mock logger
        $this->loggerMock = $this->createMock(LoggerInterface::class);
    }

    public function testFetchUsers(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
            ],
            [
                'id' => 2,
                'name' => 'Jane Doe',
                'username' => 'janedoe',
                'email' => 'janedoe@example.com',
            ],
        ];

        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->willReturn($users);

        // Create a new UserFetcher instance with the mock objects
        $userFetcher = new UserFetcher($this->cacheMock, $this->httpClientMock, $this->loggerMock);

        // Assert that the fetched user data matches the expected data
        $this->assertSame($users, $userFetcher->fetchUsers());
    }

    public function testFetchUser(): void
    {
        $user = [
            "id" => 1,
            "name" => "Leanne Graham",
            "username" => "Bret",
            "email" => "Sincere@april.biz",
            "address" => [
                "street" => "Kulas Light",
                "suite" => "Apt. 556",
                "city" => "Gwenborough",
                "zipcode" => "92998-3874",
                "geo" => [
                    "lat" => "-37.3159",
                    "lng" => "81.1496",
                ],
            ],
            "phone" => "1-770-736-8031 x56442",
            "website" => "hildegard.org",
            "company" => [
                "name" => "Romaguera-Crona",
                "catchPhrase" => "Multi-layered client-server neural-net",
                "bs" => "harness real-time e-markets",
            ],
        ];

        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->willReturn($user);

        // Create a new UserFetcher instance with the mock objects
        $userFetcher = new UserFetcher($this->cacheMock, $this->httpClientMock, $this->loggerMock);

        // Assert that the fetched user data matches the expected data
        $this->assertSame($user, $userFetcher->fetchUser(1));
    }

}
