<?php
// next - prev page
// previous_posts_link();
// next_posts_link();

$query = !empty($args['query']) ? $args['query'] : false;

if ($query) {

  global $query;
  $big = 999999999;
  echo paginate_links([
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link($big) )),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $query->max_num_pages,
    'type' => 'list',
  ]);

}