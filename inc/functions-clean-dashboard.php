<?php
################### REMOVE DASHBOARD WIDGETS
add_action('wp_dashboard_setup', 'script_remove_dashboard_widgets', 9999 );
function script_remove_dashboard_widgets() {  
     
    // Remove All
    //global $wp_meta_boxes;
    //$wp_meta_boxes['dashboard']['normal']['core'] = array();
    //$wp_meta_boxes['dashboard']['side']['core'] = array();

    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');// Remove WordPress Events and News
    remove_meta_box('dashboard_primary', 'dashboard', 'side');// Remove WordPress Events and News
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
    remove_meta_box('siteground_wizard_dashboard', 'dashboard', 'side'); //Simplified Dashboard

}
?>