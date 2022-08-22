<?php

// Updates count
if(!current_user_can('administrator')) { wpb_set_post_views(get_the_ID()); }

// Redirects to external URL (Affiliate Link)
$product_url = get_post_meta( get_the_ID(), 'product_url', true);
wp_redirect($product_url);

?>