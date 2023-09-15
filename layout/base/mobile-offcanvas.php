<div id="htmx-offcanvas" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar uk-flex uk-flex-column">

    <button class="uk-offcanvas-close" type="button" uk-close></button>

    <div class="uk-margin-auto-vertical">
      <?php
      tpf_render('layout/menu/mobile-menu-wp', ['menu' => 'navbar']);
      ?>
    </div>

  </div>
</div>