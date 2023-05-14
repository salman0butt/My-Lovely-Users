<?php

declare(strict_types=1);

if (function_exists('get_header')) {
    get_header();
}

$users = $users ?? [];

?>

<h3 style="text-align:center; margin-bottom: 10px !important;"><?php echo esc_html__('My Lovely Users Table', 'my-lovely-users'); ?></h3>
<div class="table-container">
<table id="users-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($users && count($users) > 0) :
        foreach ($users as $user) : ?>
                  <tr>
                    <td>
                      <a 
                      href="#" 
                      class="user-details-link" 
                      data-user-id="<?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>"
                      >
                            <?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>
                      </a>
                    </td>
                    <td>
                      <a 
                      href="#" 
                      class="user-details-link" 
                      data-user-id="<?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>"
                      >
                            <?php echo isset($user['name']) ? esc_html($user['name']) : ''; ?>
                      </a>
                </td>
                    <td>
                      <a 
                      href="#" 
                      class="user-details-link" 
                      data-user-id="<?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>"
                      >
                            <?php echo isset($user['username'])
                            ? esc_html($user['username'])
                            : ''; ?>
                      </a>
                </td>
                    <td>
                      <a 
                      href="#" 
                      class="user-details-link" 
                      data-user-id="<?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>"
                      >
                            <?php echo isset($user['email']) ? esc_html($user['email']) : ''; ?>
                      </a>
                    </td>
                  </tr>
                    <?php
        endforeach;
    endif;
    ?>
  </tbody>
</table>
</div>
<div id="user-details-container">
  <!-- User details will be displayed here via AJAX -->
</div>
<?php
// Check if footer.php file exists in the theme
if (function_exists('get_footer')) {
    get_footer();
}

?>
