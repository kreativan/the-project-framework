<?php

/**
 * Layout: home/demo
 */
?>

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true;">
  <div class="uk-container">

    <div class="uk-margin-medium uk-text-center uk-margin-auto">
      <h1 class="uk-heading-medium uk-margin uk-text-bold">The Project Framework</h1>
      <h3 class="uk-margin">Build custom websites with WordPress, ACF and UIkit</h3>
    </div>

    <div class="tm-bg-white tm-border uk-padding-small uk-margin-large-top uk-width-xlarge uk-margin-auto">
      <ul class="uk-list uk-list-divider uk-margin-remove">

        <li>
          <a href="https://www.advancedcustomfields.com/" target="_blank" rel="nofollow">Advanced Custom Fields</a>
          <p class="uk-text-small uk-text-small uk-margin-remove">
            ACF is the core of the framework.
          </p>
        </li>

        <li>
          <a href="https://getuikit.com/" target="_blank" rel="nofollow">
            UIkit Framework
          </a>
          <p class="uk-text-small uk-text-small uk-margin-remove">
            Front-end framework as default.
          </p>
        </li>

        <li>
          <a href="/ajax/response/">
            Ajax End-Point
          </a>
          <p class="uk-text-small uk-text-small uk-margin-remove">
            Use ajax end-point to handle business logic or create a json feed
          </p>
        </li>

        <li>
          <a href="#" hx-get="?htmx=layout/htmx/init/" hx-target="#main">
            HTMX
          </a>
          <p class="uk-text-small uk-text-small uk-margin-remove">
            Load and filter content dinamically, create SPA like nav, invoke modals and offcanvas componenets...
          </p>
        </li>

      </ul>
    </div>
  </div>
</div>