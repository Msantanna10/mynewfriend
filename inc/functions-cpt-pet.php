<?php
################### Register Custom Post Type
function custom_post_type_amigo() {

$labels = array(
    'name'                  => _x( 'Pets', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Pets', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Pets', 'text_domain' ),
    'name_admin_bar'        => __( 'Pets', 'text_domain' ),
    'attributes'            => __( 'Atributos', 'text_domain' ),
    'all_items'             => __( 'All pets', 'text_domain' ),
    'add_new_item'          => __( 'Add new pet', 'text_domain' ),
    'add_new'               => __( 'Add pet', 'text_domain' ),
    'new_item'              => __( 'New pet', 'text_domain' ),
    'edit_item'             => __( 'Edit pet', 'text_domain' ),
    'update_item'           => __( 'Update pet', 'text_domain' ),
    'view_item'             => __( 'View pet', 'text_domain' ),
    'view_items'            => __( 'View pet', 'text_domain' ),
    'search_items'          => __( 'View pets', 'text_domain' ),
    'not_found'             => __( 'Nothing found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Nothing found in the trash', 'text_domain' ),
    'featured_image'        => __( 'Featured image', 'text_domain' ),
    'set_featured_image'    => __( 'Set main image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove main image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as main image', 'text_domain' ),
);
$args = array(
    'label'                 => 'Pets',
    'labels'                => $labels,
    'supports'              => array( 'title' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_in_rest' => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    'rewrite' => array('with_front' => false),
    'menu_icon'       => 'dashicons-pets',
);
register_post_type( 'pet', $args );

}
add_action( 'init', 'custom_post_type_amigo', 0 );

################### Custom pet fields
add_action( 'cmb2_admin_init', 'custom_pet_fields' );
function custom_pet_fields() {
  $cmb_demo = new_cmb2_box( array(
    'id'            => 'animais_infos',
    'title'         => 'Important information',
    'object_types'  => array( 'pet' ), // Post type
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Story',
    'desc'       => 'Write all the details of the pet\'s story.',
    'id'         => 'animais_descricao',
    'type'       => 'textarea',
    'attributes' => array(
      'style' => 'width: 100%;max-width: 700px;height: 175px;'
    ),
  ) );

  $cmb_demo->add_field( array(
    'name' => 'Gallery',
    'desc' => 'Select the pet photos! The first photo will be the main one. <br>You can drag to reorder them.',
    'id'   => 'animais_galeria',
    'type' => 'file_list',
    'preview_size' => array( 150, 150 ), // Default: array( 50, 50 )
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    // Optional, override default text strings
    'text' => array(
        'add_upload_files_text' => 'Add images', // default: "Add or Upload Files"
        'remove_image_text' => 'Remove image', // default: "Remove Image"
        'file_text' => 'Imagem', // default: "File:"
        'file_download_text' => 'Download image', // default: "Download"
        'remove_text' => 'Remove image', // default: "Remove"
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Adopted?',
    'desc'       => 'Check this option when the pet is adopted.',
    'id'         => 'animais_adocao_check',
    'type'       => 'checkbox',
  ) );

}

################### CTA fields
add_action( 'cmb2_admin_init', 'custom_cta_fields' );

function custom_cta_fields() {

    $cmb_demo = new_cmb2_box( array(
        'id'            => 'all_infos',
        'title'         => 'General information',
        'object_types'  => array( 'pet' ), // Post type
    ) );

    $attributes = array();
    if ( ! current_user_can( 'manage_options' ) ) {
        $attributes['readonly'] = '1';
        $attributes['disabled'] = '1';
    }

    $attributes['type'] = 'number';

    $cmb_demo->add_field( array(
        'name'       => 'Views count',
        'id'         => 'all_visit_counter',
        'type'       => 'text',
        'column' => array(
            'position' => 2,
            'name'     => 'Views count',
        ),
        'attributes'  => $attributes,
    ) );
	
	$cmb_demo->add_field( array(
        'name'       => 'Phone clicks',
        'id'         => 'phone_cliques',
        'type'       => 'text',
        //'column'          => true, // Display field value in the admin post-listing columns
        'column' => array( 
         'name' => 'Phone clicks', // Set the admin column title 
         'position' => 2 // Set as the second column. 
        )
    ) );

}
?>