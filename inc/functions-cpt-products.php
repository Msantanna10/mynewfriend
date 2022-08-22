<?php
################### Register Custom Post Type
function custom_post_type_product() {
$labels = array(
    'name'                  => _x( 'My products', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'My products', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'My products', 'text_domain' ),
    'name_admin_bar'        => __( 'My products', 'text_domain' ),
    'attributes'            => __( 'Attributes', 'text_domain' ),
    'all_items'             => __( 'All products', 'text_domain' ),
    'add_new_item'          => __( 'Add new product', 'text_domain' ),
    'add_new'               => __( 'Add new product', 'text_domain' ),
    'new_item'              => __( 'New product', 'text_domain' ),
    'edit_item'             => __( 'Edit product', 'text_domain' ),
    'update_item'           => __( 'Update product', 'text_domain' ),
    'view_item'             => __( 'View product', 'text_domain' ),
    'view_items'            => __( 'View products', 'text_domain' ),
    'search_items'          => __( 'Search products', 'text_domain' ),
    'not_found'             => __( 'Nothing found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Nothing found in the trash', 'text_domain' ),
    'featured_image'        => __( 'Main image', 'text_domain' ),
    'set_featured_image'    => __( 'Set main image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove main image', 'text_domain' ),
    'use_featured_image'    => __( 'Set as main image', 'text_domain' ),
);
$args = array(
    'label'                 => 'My products',
    'labels'                => $labels,
    'supports'              => array( 'title','thumbnail' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'menu_icon'       => 'dashicons-products',
    'rewrite' => array('slug' => 'especial','with_front' => false),
    'capability_type' => 'page',
);
register_post_type( 'product', $args );
}
add_action( 'init', 'custom_post_type_product', 0 );

################### Custom product fields
add_action( 'cmb2_admin_init', 'custom_product_fields' );
function custom_product_fields() {

  $cmb_demo = new_cmb2_box( array(
    'id'            => 'product_infos',
    'title'         => 'Product information',
    'object_types'  => array( 'product' ), // Post type
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Description',
    'desc'       => 'Product details',
    'id'         => 'product_descricao',
    'type'       => 'textarea',
    'attributes' => array(
      'style' => 'width: 100%;max-width: 700px;height: 175px;'
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Product link',
    'id'         => 'product_url',
    'type'       => 'text_url'
  ) );

}
?>