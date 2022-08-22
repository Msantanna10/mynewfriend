<?php
################### QUERY VARS
// This is used to create custom URL for SEO when filtering pets
// Example: mywebsite.com/state/city/specie/size
add_filter('query_vars', 'add_state_var', 0, 1);
function add_state_var($vars){
    $vars[] = 'state_query';
    $vars[] = 'city_query';
    $vars[] = 'species_query';
    $vars[] = 'size_query';
    return $vars;
}


################### REWRITE RULES TO CREATE THE URLs
global $pageSearchPage;

if($pageSearchPage) {

$post_id = $pageSearchPage; // Search page slug by ID
$slug = get_post($post_id)->post_name; 

// ([^/]*) = accepts accents and spaces
// ([a-z0-9-]+) = accepts only without accents or spaces

// Normal listing + pagination
add_rewrite_rule('^'.$slug.'/page/([0-9]{1,})/?$','index.php?page_id='.$pageSearchPage.'&paged=$matches[1]','top');

// State
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]','top');
// State + pagination
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/page/([0-9]{1,})/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&paged=$matches[2]','top');

// State and City
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]','top');
// State and City + pagination
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/page/([0-9]{1,})/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]&paged=$matches[3]','top');

// State and City and Species
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]&species_query=$matches[3]','top');
// State and City and Species + pagination
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/page/([0-9]{1,})/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]&species_query=$matches[3]&paged=$matches[4]','top');

// State and City and Species e Size
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]&species_query=$matches[3]&size_query=$matches[4]','top');
// State and City and Species e Size + pagination
add_rewrite_rule('^'.$slug.'/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/page/([0-9]{1,})/?$','index.php?page_id='.$pageSearchPage.'&state_query=$matches[1]&city_query=$matches[2]&species_query=$matches[3]&size_query=$matches[4]&paged=$matches[5]','top');

}
?>