<?php
$user_page = tpf_user_page();
$current_id = get_the_id();
$user_menu_obg = the_project('user_menu');
$user_menu = tpf_get_menu($user_menu_obg);
$class = !empty($args['class']) ? $args['class'] : "uk-nav-default";
$attr = !empty($args['attr']) && $args['attr'] == 1 ? 'uk-nav' : '';
?>



<ul class="uk-nav <?= $class ?>" <?= $attr ?>>
<?php if($user_menu && !empty($user_menu) && count($user_menu) > 0) : ?>

  <?php foreach($user_menu as $item) : ?>
  <li class="<?= $current_id == $item->object_id ? 'uk-active' : '' ?>">
    <a href="<?= $item->url ?>" title="<?= $item->title ?>">
      <?= $item->title ?>
    </a>
  </li>
  <?php endforeach; ?>

<?php else : ?>
  
  <li class="<?= $current_id == $user_page->ID ? 'uk-active' : '' ?>">
    <a href="<?= tpf_user_page('url') ?>">
      <?= tpf_svg('dashboard', ['type' => 'fill']); ?>
      <?= $user_page->post_title ?>
    </a>
  </li>

  <li>
    <a href="/ajax/user/logout/">
      <?= tpf_svg('logout', ['type' => 'fill']); ?>
      <?= __x('Logout') ?>
    </a>
  </li>

<?php endif; ?>
</ul>