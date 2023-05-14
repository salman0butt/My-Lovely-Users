<?php

declare(strict_types=1);

// Check if $userDetails is set and initialize it to an empty array if it isn't.
$userDetails = $userDetails ?? [];

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
        <?php echo isset($userDetails['id']) ? esc_html($userDetails['id']) : ''; ?>
      </th>
      <td>
        <?php echo isset($userDetails['name']) ? esc_html($userDetails['name']) : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['username']) ? esc_html($userDetails['username']) : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['email']) ? esc_html($userDetails['email']) : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['phone']) ? esc_html($userDetails['phone']) : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['website']) ? esc_html($userDetails['website']) : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['company']['name'])
        ? esc_html($userDetails['company']['name'])
        : ''; ?><br>
        <?php echo isset($userDetails['company']['catchPhrase'])
        ? esc_html($userDetails['company']['catchPhrase'])
        : ''; ?><br>
        <?php echo isset($userDetails['company']['bs'])
        ? esc_html($userDetails['company']['bs'])
        : ''; ?>
      </td>
      <td>
        <?php echo isset($userDetails['address']['street'])
        ? esc_html($userDetails['address']['street'])
        : ''; ?><br>
        <?php echo isset($userDetails['address']['suite'])
        ? esc_html($userDetails['address']['suite'])
        : ''; ?><br>
        <?php echo isset($userDetails['address']['city']) ?
        esc_html($userDetails['address']['city'])
        : ''; ?><br>
        <?php echo isset($userDetails['address']['zipcode'])
        ? esc_html($userDetails['address']['zipcode'])
        : ''; ?><br>
        <?php echo isset($userDetails['address']['geo']['lat'])
        ? esc_html($userDetails['address']['geo']['lat'])
        : ''; ?><br>
        <?php echo isset($userDetails['address']['geo']['lat'])
        ? esc_html($userDetails['address']['geo']['lng'])
        : ''; ?><br>
      </td>
    </tr>
  </tbody>
</table>
