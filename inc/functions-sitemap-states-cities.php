<?php
##################### SITEMAP FOR STATES AND CITIES ##################### 
add_action("admin_init", "wp_custom_sitemap_state_cities");
function wp_custom_sitemap_state_cities() {

// SEO: Creates a custom sitemap with EVERY combination between states and cities from Brazil

global $pageSearchPage;
$string = json_get_content(get_bloginfo('template_url') . "/states_cities.json");

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= '<?xml-stylesheet type="text/xsl" href="'.get_site_url().'wp-content/plugins/google-sitemap-generator/sitemap.xsl"?>';
$sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($string as $key => $value) { 

$state = $value['name'];

// Generates links for states
$sitemap .= '<url>
        <loc>'.get_the_permalink($pageSearchPage).sanitize_title($state).'/</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>';

    // Generates links for cities
    foreach($value['cities'] as $city) {
        $sitemap .= '<url>
            <loc>'.get_the_permalink($pageSearchPage).sanitize_title($state).'/'.sanitize_title($city).'/</loc>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>';
    }

}
    
$sitemap .= '</urlset>';

// Edits file in the root folder
$fp = fopen(ABSPATH . "sitemap-state-cities.xml", 'w');
fwrite($fp, $sitemap);
fclose($fp);

}
?>