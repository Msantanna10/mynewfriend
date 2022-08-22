<?php

/* Template Name: Search */

$state_query = (get_query_var('state_query') && get_query_var('state_query') != 'any-state') ? slugToString($state_query)['state-with-accents'] : '';
$city_query = (get_query_var('city_query') && get_query_var('city_query') != 'any-city') ? slugToString($city_query)['city-with-accents'] : '';
$species = get_query_var('species_query');
$sizes = get_query_var('size_query');

get_header();

?>

<div class="pet-search space-top">
    <div class="busca">
        <div class="container">
          <div class="content">
            <h1 class="center">Find a new friend</h1>

            <?php get_template_part('template-part/search-form') ?>

          </div>
        </div>
    </div>
</div>
<div class="corpo space" id="listagem">
  <div class="container">

    <div class="all-pets">
      <?php

          $args = array();

          // State
          if( !empty($state_query) && $state_query != 'any-state' )
            $args['meta_query'][] = array(
              'key' => 'doador_estado',
              'value' => $state_query
          );

          // City
          if( !empty($city_query) && $city_query != 'any-city' )
            $args['meta_query'][] = array(
              'key' => 'doador_cidade',
              'value' => $city_query
          );

          // Pet Donors
          $doadores = get_users( $args );

          $doador_ids = array();
          foreach($doadores as $doador) {
              $doador_ids[] = $doador->ID;
          }

          $authors = implode(',', $doador_ids);

          if(empty($authors)) { $authors = 9999999; }
          
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          $args = array(
              'author' => $authors,
              "post_type" => 'pet',
              "posts_per_page" => 45,
              'orderby' => 'date',
              'order' => 'DESC',
              "paged" => $paged,
          );

          // Specie
          if( !empty($species) && $species != 'any-species' )
            $args['tax_query'][] = array(
              'taxonomy' => 'especie',
              'field'     => 'slug',
              'terms' => $species
          );

          // Size
          if( !empty($sizes) && $sizes != 'any-size' )
            $args['tax_query'][] = array(
              'taxonomy' => 'tamanho',
              'field'     => 'slug',
              'terms' => $sizes
          );
            
          $custom_query = new WP_Query( $args );
            
          if($custom_query->have_posts()) {

          while($custom_query->have_posts()) : 
          $custom_query->the_post(); 
          
          // Template
          get_template_part('template-part/loop-pets');

          ?>
          
          <?php endwhile; wp_reset_postdata(); } else { echo '<p id="none">No pet was found! Try a different search. <a href="'.get_the_permalink($pageSearchPage).'" id="botao">View all pets</a></p>'; } ?>

      </div>

      <?php if (function_exists("pagination")) { pagination($custom_query->max_num_pages); } ?>
    </div>

  </div>
</div>
    
<?php get_footer(); ?>