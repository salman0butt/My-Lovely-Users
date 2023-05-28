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

### Shortcode (Display the Usertable Via Shortcode)

`[my_lovely_user_table]` use this Shortcode to display Userstable

### Custom Hooks

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

1. Dependency Injection with PHP-DI Container: The plugin uses a container to manage dependencies, making the code modular and testable.

1. Custom Hooks for Extending Functionality: Custom hooks allow developers to add custom features and integrate with other plugins or themes.

1. Interfaces for Better Code Architecture: Interfaces define contracts, promoting flexible and maintainable code.

1. Cache Interface: The plugin implements its own caching mechanism for better control and integration with different caching systems.

1. HTTP Client: An HTTP client interface is used for performing HTTP requests, making it easier to test and switch implementations.

1. Custom Endpoint: A custom endpoint is registered to display a user table fetched from a third-party API.

1. Custom Exceptions for Error Handling: Custom exceptions provide structured error handling and meaningful error messages.

1. Logger Interface and Mono Logger for Logging: A logger interface is used for logging events, and the Mono Logger class is a concrete implementation.

1. Nonces: WordPress nonces are used for security and preventing CSRF attacks in AJAX requests.

## License

[MIT](https://choosealicense.com/licenses/mit/)

