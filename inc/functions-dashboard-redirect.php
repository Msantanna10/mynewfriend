<?php
##################### Dashboard redirect if not admin
function dashboard_block_redirect(){
if( is_admin() && !defined('DOING_AJAX') && ( !current_user_can('administrator') ) ){
    wp_redirect(home_url());
    exit;
}
}
add_action('init','dashboard_block_redirect');
?>