<?php

declare(strict_types=1);

use DI\Container;
use Inpsyde\MyLovelyUsers\Lib\WpCache;
use Inpsyde\MyLovelyUsers\MyLovelyUsers;
use Inpsyde\MyLovelyUsers\Lib\HttpClient;
use Inpsyde\MyLovelyUsers\Includes\Setting;
use Inpsyde\MyLovelyUsers\Lib\MonologLogger;
use Inpsyde\MyLovelyUsers\Includes\UserTable;
use Inpsyde\MyLovelyUsers\Includes\UserDetails;
use Inpsyde\MyLovelyUsers\Includes\UserFetcher;
use Inpsyde\MyLovelyUsers\Includes\UsersRenderer;
use Inpsyde\MyLovelyUsers\Includes\UserTableShortcode;
use Inpsyde\MyLovelyUsers\Includes\EndpointRegistration;

// Define the dependencies
return [
    WpCache::class => new WpCache(),
    HttpClient::class => new HttpClient(),
    MonologLogger::class => new MonologLogger(),
    Setting::class => new Setting(),
    UserFetcher::class => static function (Container $container): UserFetcher {
        return new UserFetcher(
            $container->get(WpCache::class),
            $container->get(HttpClient::class),
            $container->get(MonologLogger::class)
        );
    },
    UsersRenderer::class => new UsersRenderer(),
    UserTable::class => static function (Container $container): UserTable {
        return new UserTable(
            $container->get(UserFetcher::class),
            $container->get(UsersRenderer::class),
            $container->get(MonologLogger::class)
        );
    },
    UserDetails::class => static function (Container $container): UserDetails {
        return new UserDetails(
            $container->get(UserFetcher::class),
            $container->get(UsersRenderer::class),
            $container->get(MonologLogger::class)
        );
    },
    UserTableShortcode::class => static function (Container $container): UserTableShortcode {
        return new UserTableShortcode($container->get(UserTable::class));
    },
    EndpointRegistration::class => new EndpointRegistration(),
    MyLovelyUsers::class => static function (Container $container): MyLovelyUsers {
        return new MyLovelyUsers(
            $container->get(EndpointRegistration::class),
            $container->get(Setting::class),
            $container->get(UserTable::class),
            $container->get(UserDetails::class),
            $container->get(UserTableShortcode::class),
            $container->get(MonologLogger::class)
        );
    },
];
