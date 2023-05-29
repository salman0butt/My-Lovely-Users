<?php

/**
 * Template Name: Users Table Page
 *
 * This template file is used to display a users table page.
 *
 * @package MyLovelyUsers
 */

declare(strict_types=1);

// Check if the header file exists before including it
if (!empty(locate_template('header.php'))) {
    get_header();
}

// Get the users data passed from the template function
$usersData = apply_filters('my_lovely_users_template_data', []);
// Display the users table if data is available
if (!empty($usersData)) {
    echo wp_kses_post($usersData);
}

// Check if the footer file exists before including it
if (!empty(locate_template('footer.php'))) {
    get_footer();
}
exit();
