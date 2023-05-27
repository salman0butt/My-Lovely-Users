# My Lovely Users Wordpress Plugin
The My Lovely Users plugin is designed to fetch users' data from a third-party API endpoint and display it in a table format. It provides customization options and implements various features to enhance its functionality.

## Requirements
To use the My Lovely Users plugin, ensure that your environment meets the following requirements:

1. PHP version 8.1 or higher
1. Composer dependency manager to install required dependencies like Inpsyde code style, PHPCS, PHPUNIT, Brain Monkey, etc.


## Installation

Follow these steps to install the My Lovely Users plugin:

1. Upload `my-lovely-users` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to /wp-content/plugins/my-lovely-users and run the following command to install the required dependencies using Composer:

```bash
  composer install
```
    
## Usage

Once the plugin is installed and activated, a new endpoint will be available at /my-lovely-users-table. Accessing this endpoint will display a table of users fetched from the third-party API endpoint.

## Extending Features with Custom Hooks
The My Lovely Users plugin provides custom hooks that allow you to extend its features and functionality.

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

## Configuration

The My Lovely Users plugin offers a feature to customize the endpoint. To modify the endpoint, follow these steps:

1. Go to the 'Settings' tab in the WordPress admin panel.
1. Click on 'My Lovely Users Settings' under the 'Settings' menu.
1. Here, you can dynamically change the endpoint.

The default endpoint is my-lovely-users-table. Additionally, you can define the following constants to customize the plugin's behavior:

MY_LOVELY_USERS_VERSION - the version number of the plugin (default is 1.0.0)
MY_LOVELY_USERS_NAME - the name of the plugin (default is my-lovely-users)

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

1. Dependency Injection: The plugin uses the PHP-DI container to manage its dependencies and achieve loose coupling between components. This approach allows for easier testing, maintainability, and flexibility in swapping out implementations without modifying the code that depends on them.

1. Cache Interface: Instead of relying on WordPress caching functions, the plugin implements its own CacheInterface using the WpCache class. This choice provides greater control and flexibility over caching mechanisms, allowing for easy integration with different caching systems like Redis or Memcache in the future.

1. HTTP Client: The plugin utilizes an HTTP Client interface to perform HTTP requests. By abstracting the HTTP communication, it becomes easier to mock and test the plugin's interactions with external APIs, as well as allowing for the possibility of switching to a different HTTP client implementation if needed.

1. Custom Endpoint: The plugin registers a custom endpoint /my-lovely-users-table to display the table of users fetched from a third-party API. This decision grants more control over the display and integration of the user table with other content in the WordPress site.

1. Nonces: To enhance security and prevent Cross-Site Request Forgery (CSRF) attacks, the plugin utilizes WordPress nonces for AJAX requests. This safeguard ensures that only authorized users can access the plugin's AJAX functions, maintaining the integrity of user data.

1. PHP-DI Container: The plugin employs the PHP-DI container to manage dependencies throughout its codebase. This container provides automatic dependency injection, reducing coupling between classes and allowing for easier maintenance and extensibility of the plugin.
## License

[MIT](https://choosealicense.com/licenses/mit/)

