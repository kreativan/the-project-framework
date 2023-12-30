<?php
$id = get_sub_field('content_block');
$content_block = get_post($id);
render("layout/blocks/{$content_block->post_name}.php");
