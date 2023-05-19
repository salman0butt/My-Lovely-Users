<?php

declare(strict_types=1);

// Check if $user is set and initialize it to an empty array if it isn't.
$user = $user ?? [];

?>

<h3 class="text-center mb-4"><?php echo esc_html__('User Detail', 'my-lovely-users'); ?></h3>
<table id="users-details" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col"><?php echo esc_html__('ID', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Name', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Username', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Email', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Phone', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Website', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Company', 'my-lovely-users'); ?></th>
      <th scope="col"><?php echo esc_html__('Address', 'my-lovely-users'); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">
        <?php echo isset($user['id']) ? esc_html($user['id']) : ''; ?>
      </th>
      <td>
        <?php echo isset($user['name']) ? esc_html($user['name']) : ''; ?>
      </td>
      <td>
        <?php echo isset($user['username']) ? esc_html($user['username']) : ''; ?>
      </td>
      <td>
        <?php echo isset($user['email']) ? esc_html($user['email']) : ''; ?>
      </td>
      <td>
        <?php echo isset($user['phone']) ? esc_html($user['phone']) : ''; ?>
      </td>
      <td>
        <?php echo isset($user['website']) ? esc_html($user['website']) : ''; ?>
      </td>
      <td>
        <?php echo isset($user['company']['name'])
        ? esc_html($user['company']['name'])
        : ''; ?><br>
        <?php echo isset($user['company']['catchPhrase'])
        ? esc_html($user['company']['catchPhrase'])
        : ''; ?><br>
        <?php echo isset($user['company']['bs'])
        ? esc_html($user['company']['bs'])
        : ''; ?>
      </td>
      <td>
        <?php echo isset($user['address']['street'])
        ? esc_html($user['address']['street'])
        : ''; ?><br>
        <?php echo isset($user['address']['suite'])
        ? esc_html($user['address']['suite'])
        : ''; ?><br>
        <?php echo isset($user['address']['city']) ?
        esc_html($user['address']['city'])
        : ''; ?><br>
        <?php echo isset($user['address']['zipcode'])
        ? esc_html($user['address']['zipcode'])
        : ''; ?><br>
        <?php echo isset($user['address']['geo']['lat'])
        ? esc_html($user['address']['geo']['lat'])
        : ''; ?><br>
        <?php echo isset($user['address']['geo']['lat'])
        ? esc_html($user['address']['geo']['lng'])
        : ''; ?><br>
      </td>
    </tr>
  </tbody>
</table>
