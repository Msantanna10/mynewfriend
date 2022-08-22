<?php
################### Taxonomy - Species
add_action( 'init', 'custom_taxonomy_especie', 0 ); 
function custom_taxonomy_especie() {
 
$labels = array(
'name' => 'Species',
'singular_name' => 'Species',
'search_items' =>  'Search species',
'all_items' => __( 'All species' ),
'edit_item' => __( 'Edit species' ), 
'update_item' => __( 'Update species' ),
'add_new_item' => __( 'Add new species' ),
'new_item_name' => __( 'New species' ),
'menu_name' => __( 'Species' ),
);    
// Now register the taxonomy
register_taxonomy('especie',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'especie' ),
));
 
}

################### Taxonomy - Size
add_action( 'init', 'custom_taxonomy_tamanho', 0 );
function custom_taxonomy_tamanho() {
 
$labels = array(
'name' => 'Size',
'singular_name' => 'Size',
'search_items' =>  'Search sizes',
'all_items' => __( 'All sizes' ),
'edit_item' => __( 'Edit size' ), 
'update_item' => __( 'Update size' ),
'add_new_item' => __( 'Add new size' ),
'new_item_name' => __( 'New size' ),
'menu_name' => 'Size',
);    
// Now register the taxonomy
register_taxonomy('tamanho',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'tamanho' ),
));

}

################### Taxonomy - Special Cares
add_action( 'init', 'custom_taxonomy_cuidados', 0 );
function custom_taxonomy_cuidados() {
 
$labels = array(
'name' => 'Veterinary care',
'singular_name' => 'Veterinary care',
'search_items' =>  'Search veterinary care',
'all_items' => __( 'All veterinary cares' ),
'edit_item' => __( 'Edit veterinary cares' ), 
'update_item' => __( 'Update veterinary care' ),
'add_new_item' => __( 'Add veterinary care' ),
'new_item_name' => __( 'New veterinary care' ),
'menu_name' => __( 'Veterinary care' ),
);    
// Now register the taxonomy
register_taxonomy('cuidados',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => false,
'query_var' => true,
'rewrite' => array( 'slug' => 'cuidados-veterinarios' ),
));
 
}

################### Taxonomy - Sex
add_action( 'init', 'custom_taxonomy_sexo', 0 );
function custom_taxonomy_sexo() {

$labels = array(
'name' => 'Sex',
'singular_name' => 'Sex',
'search_items' =>  'Search sex',
'all_items' => __( 'All sexes' ),
'edit_item' => __( 'Edit sex' ), 
'update_item' => __( 'Update sex' ),
'add_new_item' => __( 'Add sex' ),
'new_item_name' => __( 'New sex' ),
'menu_name' => __( 'Sex' ),
);    
// Now register the taxonomy
register_taxonomy('sexo',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'sexo' ),
));

}

################### Taxonomy - Temperament
add_action( 'init', 'custom_taxonomy_temperamento', 0 );
function custom_taxonomy_temperamento() {

$labels = array(
'name' => 'Temperament',
'singular_name' => 'Temperament',
'search_items' =>  'Search temperament',
'all_items' => __( 'All temperaments' ),
'edit_item' => __( 'Edit temperament' ), 
'update_item' => __( 'Update temperament' ),
'add_new_item' => __( 'Add temperament' ),
'new_item_name' => __( 'New temperaments' ),
'menu_name' => __( 'Temperament' ),
);    
// Now register the taxonomy
register_taxonomy('temperamento',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => false,
'query_var' => true,
'rewrite' => array( 'slug' => 'temperamento' ),
));
 
}

################### Taxonomy - Lives well in (Environment)
add_action( 'init', 'custom_taxonomy_vive_bem_em', 0 ); 
function custom_taxonomy_vive_bem_em() {

$labels = array(
'name' => 'Lives well in',
'singular_name' => 'Environments',
'search_items' =>  'Search environment',
'all_items' => __( 'All environments' ),
'edit_item' => __( 'Edit environment' ), 
'update_item' => __( 'Update environment' ),
'add_new_item' => __( 'Add environment' ),
'new_item_name' => __( 'New environment' ),
'menu_name' => __( 'Environments' ),
);    
// Now register the taxonomy
register_taxonomy('ambiente',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => false,
'query_var' => true,
'rewrite' => array( 'slug' => 'ambiente' ),
));
 
}

################### Taxonomy - Sociability
add_action( 'init', 'custom_taxonomy_sociabilidade', 0 );
function custom_taxonomy_sociabilidade() {

$labels = array(
'name' => 'Sociable with',
'singular_name' => 'Sociable with',
'search_items' =>  'Search sociability',
'all_items' => __( 'All sociabilities' ),
'edit_item' => __( 'Edit sociability' ), 
'update_item' => __( 'Update sociability' ),
'add_new_item' => __( 'Add sociability' ),
'new_item_name' => __( 'New sociability' ),
'menu_name' => __( 'Sociable with' ),
);    
// Now register the taxonomy
register_taxonomy('sociabilidade',array('pet'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_in_rest' => true,
'show_admin_column' => false,
'query_var' => true,
'rewrite' => array( 'slug' => 'sociabilidade' ),
));
 
}

?>