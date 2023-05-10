# My Lovely Users Wordpress Plugin
This Plugin Fetch Users Data and Display
## Requirements

1. PHP version 8.1 or higher
1. Composer dependency manager to install required depdencies like Inpsyde code style, PHPCS, PHPUNIT, Brain Monkey.. etc


## Installation

Install My Lovely Users


1. Upload `my-lovely-users` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to /wp-content/plugins/my-lovely-users and run the following command to install the dependencies:

```bash
  composer install
```
    
## Usage

Once the plugin is installed and activated, a new endpoint will be available at /my-lovely-users-table. Visiting this endpoint will display a table of users fetched from the third-party API endpoint.

## Configuration

The Plugin Have Extra Feature To Customize the End Point Just Goto the Settings and Click My Lovely Users Settings under Settings Tab in admin pannel.
Here You Can Change the EndPoint Dynamically

Default Endpoint: my-lovely-users-table

the following constants can be defined to customize its behavior:

MY_LOVELY_USERS_VERSION - the version number of the plugin (default is 1.0.0)
MY_LOVELY_USERS_NAME - the name of the plugin (default is my-lovely-users)

## Cache
The plugin implements its own CacheInterface rather than relying on WordPress. This choice was likely made to provide more flexibility and control over how caching is handled within the plugin. By defining its own interface, the plugin can more easily switch to a different caching implementation in the future if needed. WE Made Own WpCache Class and Used WordPress transient Functions as cache as for now in future we can use redis memcache etc.

## Running Tests

To run tests, run the following command

```bash
  vendor/bin/phpunit
```


## Running PHPCS

To run PHPCS, run the following command

```bash
  vendor/bin/phpcs
```

## non-obvious implementation choices

1. Dependency Injection: The plugin uses Dependency Injection to decouple its code from specific implementation details of external dependencies. By using interfaces, rather than concrete classes, the plugin can more easily swap out one implementation for another without needing to modify the code that depends on it. This approach can make the code more modular and easier to maintain over time.

1. CacheInterface: The plugin implements its own CacheInterface rather than relying on WordPress caching functions (WE Make Own WpCache Class and Implemented WordPress transient Functions as cache). This choice was likely made to provide more flexibility and control over how caching is handled within the plugin. By defining its own interface, the plugin can more easily switch to a different caching implementation in the future if needed.

1. Http Client: The plugin uses an Http Client interface to perform HTTP requests. This choice was likely made to make it easier to mock the HTTP requests during testing, as well as to switch to a different HTTP client implementation in the future if needed.

1. Custom Endpoint: This choice was likely made to provide more control over the display of the users table, as well as to allow for more flexibility in how the table is integrated with other WordPress content.

1. Nonces: The plugin uses WordPress nonces to provide security for AJAX requests. This choice was likely made to prevent CSRF attacks and ensure that only authorized users can access the plugin's AJAX functions.
## License

[MIT](https://choosealicense.com/licenses/mit/)

