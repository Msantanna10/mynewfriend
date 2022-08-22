<?php
################### Remove admin bar
function remove_admin_login_header() { remove_action('wp_head', '_admin_bar_bump_cb'); }
add_action('get_header', 'remove_admin_login_header');
show_admin_bar(false);

################### Add thumbnail to posts
add_theme_support( 'post-thumbnails' );

################### FUNCTION: FILE GET CONTENTS
function json_get_content($url) {
if (!function_exists('curl_init')){ 
    die('CURL is not installed!');
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);
return json_decode($data,JSON_OBJECT_AS_ARRAY);
}
?>