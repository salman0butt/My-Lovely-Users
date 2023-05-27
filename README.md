# My Lovely Users Wordpress Plugin
The My Lovely Users plugin is designed to fetch users' data from a third-party API endpoint and display it in a table format. It provides customization options and implements various features to enhance its functionality.

## Requirements
To use the My Lovely Users plugin, ensure that your environment meets the following requirements:

1. PHP version 8.1 or higher
1. Composer dependency manager to install required dependencies like Inpsyde code style, PHPCS, Phpunit, Brain Monkey, PHP-DI, Monolog etc.

## Installation

Follow these steps to install the My Lovely Users plugin:

1. Upload `my-lovely-users` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to `/wp-content/plugins/my-lovely-users` and run the following command to install the required dependencies using Composer:

```bash
  composer install
```
    
## Usage

Once the plugin is installed and activated, a new endpoint will be available at /my-lovely-users-table. Accessing this endpoint will display a table of users fetched from the third-party API endpoint.
## Configuration

The My Lovely Users plugin offers a feature to customize the endpoint. To modify the endpoint, follow these steps:

1. Go to the 'Settings' tab in the WordPress admin panel.
1. Click on 'My Lovely Users Settings' under the 'Settings' menu.
1. Here, you can dynamically change the endpoint.

The default endpoint is my-lovely-users-table. Additionally, you can define the following constants to customize the plugin's behavior:

MY_LOVELY_USERS_VERSION - the version number of the plugin (default is 1.0.0)
MY_LOVELY_USERS_NAME - the name of the plugin (default is my-lovely-users)
MY_LOVELY_USERS_ENDPOINT - the default endpoint (default is my-lovely-users-table)

## Extending Features with Custom Hooks
The My Lovely Users plugin provides custom hooks that allow you to extend its features and functionality.

1. Shortcode (Display the Usertable Via Shortcode)

`[my_lovely_user_table]` use this Shortcode to display Userstable

1. Custom Hooks

`my_lovely_users_before_table`
This hook is triggered before the users table is displayed. You can use it to add custom content or modify the table structure.

Example usage:

```php
function my_custom_function() {
  echo '<p>This is my custom content before the users table.</p>';
}
add_action('my_lovely_users_before_table', 'my_custom_function');

```

`my_lovely_users_after_table`
This hook is triggered after the users table is displayed. You can use it to add custom content or perform additional actions.

Example usage:


```php
function my_custom_function() {
  echo '<p>This is my custom content after the users table.</p>';
}
add_action('my_lovely_users_after_table', 'my_custom_function');
```

`my_lovely_users_table_detail_before`
This hook is triggered before the user details table is displayed. You can use it to add custom content or modify the table structure.

Example usage:
```php
function my_custom_function() {
  echo '<p>This is my custom content before the user details table.</p>';
}
add_action('my_lovely_users_table_detail_before', 'my_custom_function');
```

`my_lovely_users_table_detail_after`
This hook is triggered after the user details table is displayed. You can use it to add custom content or perform additional actions.

Example usage:
```php
function my_custom_function() {
  echo '<p>This is my custom content after the user details table.</p>';
}
add_action('my_lovely_users_table_detail_after', 'my_custom_function');
```
You can add these custom hook functions to your theme's functions.php file or create a custom plugin for them.

## Cache
The plugin implements its own caching mechanism, utilizing the WordPress transient functions as a cache for now (WE created our own WpCache class and used WordPress transient functions). This approach provides flexibility and allows for future integration with other caching implementations such as Redis or Memcache.

## Running Tests

To run tests for the My Lovely Users plugin, execute the following command:

```bash
  vendor/bin/phpunit
```

## Running PHPCS

To run PHPCS (PHP CodeSniffer), execute the following command:

```bash
  vendor/bin/phpcs
```

## non-obvious implementation choices

1. Dependency Injection with PHP-DI Container: To improve dependency management and facilitate testing, the plugin utilizes the PHP-DI container. The container allows for easy management of dependencies and promotes loose coupling between classes. This helps to make the code more modular and maintainable. For example, the plugin uses the container to inject the `UserFetcher` into the main plugin class, allowing seamless retrieval and manipulation of user data. This also makes it easier to swap out implementations or extend functionality in a flexible manner.

1. Custom Hooks for Extending Functionality: The My Lovely Users plugin provides custom hooks that allow developers to extend its features and add custom functionality. These hooks enable the addition of custom content, modification of table structures, and integration with other plugins or themes.

1. Interfaces for Better Code Architecture: The My Lovely Users plugin utilizes interfaces to define contracts for certain classes. These interfaces provide a clear separation between the contract and the implementation, making the code more flexible and maintainable.For example, the `UserFetcherInterface` defines the contract for a user fetcher class, allowing different implementations to be used interchangeably. This enables easy integration with various data sources or database systems without affecting other parts of the code.By leveraging interfaces, the plugin promotes a more modular and extensible codebase, making it easier to introduce new features or swap out implementations when needed.

1. Cache Interface: Instead of relying on WordPress caching functions, the plugin implements its own CacheInterface using the WpCache class. This choice provides greater control and flexibility over caching mechanisms, allowing for easy integration with different caching systems like Redis or Memcache in the future.

1. HTTP Client: The plugin utilizes an HTTP Client interface to perform HTTP requests. By abstracting the HTTP communication, it becomes easier to mock and test the plugin's interactions with external APIs, as well as allowing for the possibility of switching to a different HTTP client implementation if needed.

1. Custom Endpoint: The plugin registers a custom endpoint /my-lovely-users-table to display the table of users fetched from a third-party API. This decision grants more control over the display and integration of the user table with other content in the WordPress site.

1. Custom Exceptions for Error Handling: The My Lovely Users plugin utilizes custom exceptions to handle errors in a structured and manageable way. Custom exceptions are used to encapsulate specific error scenarios and provide meaningful error messages to users or developers.For example, the plugin may throw a `TemplateNotFoundException` if a requested template file not found. This exception can be caught and handled appropriately, allowing for graceful error handling and providing feedback to the user.By employing custom exceptions, the plugin ensures that error handling is consistent and allows for precise identification and resolution of potential issues.These implementation choices contribute to the overall maintainability, flexibility, and extensibility of the My Lovely Users plugin, enabling developers to customize and enhance its functionality according to their requirements.

1. Logger Interface and Mono Logger for Logging: The My Lovely Users plugin implements a logger interface to enable logging of important events or errors. The logger interface defines a contract for logging functionality, allowing different logger implementations to be used.The plugin includes the Mono Logger class as a concrete implementation of the logger interface. The Mono Logger class provides a simple and efficient logging solution, writing logs to a specified file or output channel.
By utilizing the logger interface and the Mono Logger class, the plugin enables developers to log relevant information, debug issues, and monitor the plugin's behavior.

1. Nonces: To enhance security and prevent Cross-Site Request Forgery (CSRF) attacks, the plugin utilizes WordPress nonces for AJAX requests. This safeguard ensures that only authorized users can access the plugin's AJAX functions, maintaining the integrity of user data.
## License

[MIT](https://choosealicense.com/licenses/mit/)

