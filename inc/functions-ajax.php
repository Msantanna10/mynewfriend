<?php
################### CLICKS ON THE PHONE - Pet page
add_action('wp_ajax_phone_cliques_call', 'wpb_set_post_cliques');
add_action( 'wp_ajax_nopriv_phone_cliques_call', 'wpb_set_post_cliques' );
function wpb_set_post_cliques() {

    $postID = $_POST['postID'];
    $count_key = 'phone_cliques';

    $count = get_post_meta($postID, $count_key, true);
    if ($count==''){
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
    } else {
    $count++;
    update_post_meta($postID, $count_key, $count);
    }

    wp_die();
    
}
?>