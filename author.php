<?php get_header();

$author = get_queried_object();
$author_id = $author->ID;

$nome = get_the_author_meta('first_name', $author_id);
$sobrenome = get_the_author_meta('last_name', $author_id);

$cidade = get_user_meta( $author_id, 'doador_cidade', true);
$estado = get_user_meta( $author_id, 'doador_estado', true);

$telefone = get_user_meta( $author_id, 'doador_telefone', true );
$whats = get_user_meta( $author_id, 'doador_whats', true );

$privado = get_user_meta( $author_id, 'doador_privado', true );

global $pageSearchPage;

?>

    <div class="post-page">
      <div class="header">
        <div class="container">
          <h1><?php echo $nome; if(!empty($sobrenome)) { echo ' ' . $sobrenome; } ?></h1>
          <br>
          <h2><?php echo $cidade . ' / ' . $estado; ?></h2>

          <?php if(empty($privado)) { ?>
          <div class="block-phone">
              <div class="buttons <?php if($whats == 'sim') { echo 'two'; } else { echo 'one'; } ?>">
                <div class="single" id="fixo">
                  <a href="tel:<?php echo $telefone; ?>"><i class="fas fa-phone fa-flip-horizontal"></i> Call <span><?php echo $telefone; ?></span></a>
                </div>
                <div class="single" id="whats">
                  <a target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo $telefone; ?>&text=Hello, I found your contact on the site *<?php bloginfo('name'); ?>* and I want to adopt one of your pets"><i class="fab fa-whatsapp"></i> <?php echo $telefone; ?></a>
                </div>
              </div>
          </div>
	      <?php } ?>

        <div class="copy-link">
          <p>Profile link to share on social media!</p>
          <div id="textToCopy">
            <div id="PerfilUrl"><?php echo get_author_posts_url( $author_id ); ?></div>
            <input type="text" value="<?php echo mb_strimwidth(get_author_posts_url( $author_id ), 0, 60, "..."); ?>">
            <button id="copyButton">Copy link</button>
          </div>
          <span id="copyResult"></span>
        </div>

        </div>
      </div>
      <div class="body small-space">
      	<div class="container">

          <div class="pets-total">
            <div class="row">
              <div class="col-md-6">
                <h2 class="center" id="cadastrados">Registered pets <b><?php echo count_user_posts( $author_id, 'pet', true ); ?></b></h2>
              </div>
              <div class="col-md-6" id="doados">
                <h2 class="center">Adopted pets <b>
                <?php

                $args = array(
                    'author' => $author_id,
                    "post_type" => 'pet',
                    "posts_per_page" => -1,
                    'meta_query' => array(
                      array(
                        'key' => 'animais_adocao_check',
                        'value' => 'on', // on = checkbox is active
                        'compare' => '=',
                      )
                    ),
                );
                 
                $custom_query = new WP_Query( $args );

                if($custom_query->have_posts()) {

                $counter = 0;
                 
                while($custom_query->have_posts()) : 
                   $custom_query->the_post();

                   $counter = $counter + 1;             

                ?>                
                <?php endwhile; echo $counter; wp_reset_postdata(); } else { echo '0'; } ?></b></h2>
              </div>
            </div>
          </div>         

      		<div class="all-pets">
      		<?php

                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args = array(
                	  'author' => $author_id,
                    "post_type" => 'pet',
                    "posts_per_page" => 25,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    "paged" => $paged,
                );
                 
                $custom_query = new WP_Query( $args );

                if($custom_query->have_posts()) {
                 
                while($custom_query->have_posts()) : 
                   $custom_query->the_post(); 
                
                // template

                get_template_part('template-part/loop-pets');

                ?>
                
                <?php endwhile; wp_reset_postdata(); } else { echo '<p id="none">No pet at the moment! <a href="'.get_the_permalink($pageSearchPage).'" id="botao">View all pets</a></p>'; } ?>	 
            </div>

            <?php if (function_exists("pagination")) { pagination($custom_query->max_num_pages); } ?>
      	</div>
      </div>
    </div>
    
<?php get_footer(); ?>