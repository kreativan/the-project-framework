<?php

wp_destroy_current_session();
wp_clear_auth_cookie();
wp_set_current_user( 0 );

wp_redirect(tpf_user_page('url'));