<?php

declare (strict_types = 1);

namespace Inpsyde\MyLovelyUsers\Test;

use Inpsyde\MyLovelyUsers\Core;
use PHPUnit\Framework\TestCase;
use Inpsyde\MyLovelyUsers\Interfaces\CacheInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Inpsyde\MyLovelyUsers\Interfaces\HttpClientInterface;

class UsersTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    public function testFetchUsersDataReturnsArray()
    {
        // Arrange
        $cacheMock = $this->createMock(CacheInterface::class);
        $cacheMock
            ->expects($this->once())
            ->method('get')
            ->with('my_lovely_users_data')
            ->willReturn('');

        $expectedUsers = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'jhon@gmail.com'],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jhon@gmail.com']
        ];

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock
        ->expects($this->once())
        ->method('get')
        ->with('https://jsonplaceholder.typicode.com/users')
        ->willReturn($expectedUsers);

        $core = new Core($cacheMock, $httpClientMock);

        // Act
        $result = $core->fetchUsersData();

        // Assert
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals('John Doe', $result[0]['name']);
        $this->assertEquals('jhon@gmail.com', $result[0]['email']);
        $this->assertEquals(2, $result[1]['id']);
        $this->assertEquals('Jane Doe', $result[1]['name']);
        $this->assertEquals('jhon@gmail.com', $result[1]['email']);
    }

}
