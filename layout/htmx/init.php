<?php

namespace ProcessWire; ?>

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true;">
  <div class="uk-container">

    <div class="tm-bg-white tm-border uk-padding-small">
      <h1><b>The Project</b> HTMX</h1>

      <ul class="uk-list uk-list-striped">
        <li>Create SPA like navigation</li>
        <li>Init UIkit Modal & Offcanvas components</li>
        <li>Lazy load content</li>
        <li>Submit forms</li>
        <li>Search & filter content without browser reload</li>
      </ul>

      <button class="uk-button uk-button-primary" hx-get="?htmx=layout/htmx/content/" hx-target="#demo-container" hx-swap="outerrHTML">
        Load Demo
      </button>
    </div>


    <div id="demo-container"></div>

  </div>
</div>