<?php

$i = 0;
$action_url = "/wp-admin/edit.php";

foreach ($_GET as $key => $val) {
  $action_url .= ($i++ > 0) ? "&{$key}={$val}" : "?{$key}={$val}";
}

?>

<div class="p-flex p-flex-middle p-flex-center" style="height: 100vh;">

  <div class="p-card p-padding p-border">

    <h2>This Page is Password Protected</h2>

    <form class="p-form" action="<?= $action_url ?>" method="POST">

      <div class="p-margin">
        <input type="password" name="tpf_password_protect" placeholder="Type in password" />
      </div>

      <div class="p-margin">
        <input class="p-btn" type="submit" name="tpf_password_protect_submit" value="Submit" />
      </div>

    </form>

  </div>

</div>