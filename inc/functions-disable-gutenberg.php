<?php
################### DISABLE GUTENBERG

// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

// Disable Gutenberg for widgets.
add_filter( 'use_widgets_blog_editor', '__return_false' );

add_action( 'wp_enqueue_scripts', function() {
    // Remove CSS on the front end.
    wp_dequeue_style( 'wp-block-library' );

    // Remove inline global CSS on the front end.
    wp_dequeue_style( 'global-styles' );
}, 20 );

// REMOVE FEATURED IMAGE
add_action('do_meta_boxes', 'remove_thumbnail_box');
function remove_thumbnail_box() {
    remove_meta_box( 'postimagediv','page','side' );
    // remove_meta_box( 'postimagediv','post','side' );
}

// REMOVE CLASSIC EDITOR
function remove_editor() {
    // remove_post_type_support('page', 'editor');
}
add_action('admin_init', 'remove_editor');
?>