<?php

/**
 * html/foot.php
 */

// WordPress Footer
wp_footer();

/**
 * Scripts in footer
 */
$scripts_in_footer = get_field('scripts_in_footer', 'options');
if (!empty($scripts_in_footer) && $scripts_in_footer != "") echo $scripts_in_footer;

?>


<?php if (the_project('htmx')) : ?>
  <div id="htmx-page-indicator"></div>
<?php endif; ?>