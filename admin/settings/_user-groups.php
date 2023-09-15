<?php

$ug_url = "./options-general.php?page=project-settings&tab=users";

$protected = [
  "administrator",
  "editor",
  "author",
  "contributor",
  "subscriber",
  "customer",
  "shop_manager",
];

//-------------------------------------------------------- 
//  Logic
//-------------------------------------------------------- 

if(isset($_GET['create_user_group']) && $_GET['create_user_group'] != "") {

  $create_user_group = $_GET['create_user_group'];
  $name = sanitize_title_with_dashes($create_user_group);
  $name = str_replace("-", "_", $name);
  $title = sanitize_text_field($create_user_group);

  add_role($name, $title, $capabilities = ['read']);

  add_action('tpf_redierect', function() {
    wp_redirect($ug_url);
  });

}

if(isset($_GET['delete_user_group']) && $_GET['delete_user_group'] != "") {

  $delete_user_group = $_GET['delete_user_group'];

  if(!in_array($delete_user_group, $protected)) remove_role($delete_user_group);

  add_action('tpf_redierect', function() {
    wp_redirect($ug_url);
  });

}


//-------------------------------------------------------- 
//  UI
//-------------------------------------------------------- 

global $wp_roles;
$all_roles = $wp_roles->roles;
$custom_roles = $all_roles;

foreach($protected as $key) {
  unset($custom_roles[$key]);
}

?>

<div class="p-card p-padding">

  <h2>
    User Groups
  </h2>

  <table class="p-table p-table-striped p-margin-remove">
    <?php if(count($custom_roles) > 0) : ?>
    <thead>
      <tr>
        <th>Title</th>
        <th>Name</th>
      </tr>
    </thead>
    <?php endif; ?>
    <tbody>
      <?php foreach($custom_roles as $key => $value) : ?>
      <tr>
        <td>
          <?= $value['name'] ?>
        </td>
        <td><?= $key ?></td>
        <td class="p-text-right">
          <a class="p-text-danger" href="#" onclick="deleteUserGroup('<?= $key ?>')">
            <i class="dashicons-before dashicons-trash"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(count($custom_roles) < 1) : ?>
      <tr>
        <td>No custom roles and user groups found</td>
      </tr>
      <?php endif;?>
    </tbody>
  </table>

  <div class="p-margin-top">
    <a href="#" class="p-btn p-btn-sm" onclick="createUserGroup()">
      Create New
    </a>
  </div>

</div>

<script>
function createUserGroup() {
  event.preventDefault();
  Swal.fire({
    title: 'New User Group',
    input: 'text',
    inputLabel: 'Type in user group name',
    inputPlaceholder: 'Type in user group name',
    showCancelButton: true,
    confirmButtonText: 'Create',
    inputValidator: (value) => {
    if (!value) {
      return 'You need to write something!'
      }
    },
  }).then((result) => {
    if (result.isConfirmed) {
      //console.log(result);
      window.location.href = `<?= $ug_url ?>&create_user_group=${result.value}`;
    }
  })
}

function deleteUserGroup(role) {
  event.preventDefault();
  Swal.fire({
    icon: 'question',
    title: 'Are you sure?',
    html: `Are you sure you want to delete <code class='text-danger'>${role}</code> role`,
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    //denyButtonText: `Don't save`,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `<?= $ug_url ?>&delete_user_group=${role}`;
    } else if (result.isDenied) {
      console.log('denid')
    }
  })
}

</script>