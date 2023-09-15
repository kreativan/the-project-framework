<div id="demo-container" class="uk-margin-medium-top uk-animation-slide-bottom-small">

  <h2 class="uk-margin-remove">Use htmx to laod content dynamically.</h2>
  <h4 class="uk-margin-small-top">You can also init modal and offcanvas with htmx requests.</h4>

  <a class="uk-button uk-button-primary" href="#" <?= htmx_modal("layout/htmx/modal.php"); ?>>
    htmx modal
  </a>

  <a class="uk-button uk-button-primary" href="#" <?= htmx_offcanvas("layout/htmx/offcanvas.php"); ?>>
    htmx offcanvas
  </a>

</div>