<?php

/* Template Name: Products */

get_header(); ?>

<div class="header">
    <div class="container small-space">
          <h1 class="title"><?php the_title(); ?></h1>
    </div>
</div>
<div class="post-page">
  <div class="body">
      <div class="container space">
          <div class="produtos">
            <?php

                $args = array(
                    "post_type" => 'product',
                    "posts_per_page" => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                 
                $custom_query = new WP_Query( $args );
                
                if($custom_query->have_posts()) {
          
                    while($custom_query->have_posts()) : 
                    $custom_query->the_post(); 
                
                // template

                get_template_part( 'template-part/loop-products' );               

            endwhile; wp_reset_postdata(); } else { echo '<p id="none">No product was found!'; } ?>             
          </div>
      </div>
  </div>
</div>
    
<?php get_footer(); ?>