<?php
################### Global vars for current user location
function globalVars() {
    global $global_user_city, $global_user_state;

    // User IP
    $ip = $_SERVER['REMOTE_ADDR'];
    if(isLocalhost()){ $ip = '187.2.54.193'; /* Fake IP when using localhost to avoid conflicts */ }
    $json = json_get_content("http://ip-api.com/json/" . $ip);
    $global_user_city = $json['city'];
    $global_user_state = slugToString(sanitize_title($global_user_city))['state-slug'];

}
add_action( 'init', 'globalVars' );
?>