<?php

$author_id = $post->post_author;

$thumb = get_post_meta( get_the_ID(), 'animais_galeria', 1);
if($thumb) {
  $first_image_small = reset($thumb); // First image from the gallery
  $first_image_small = str_replace('-150x150','',$first_image_small);

  $thumb_id = attachment_url_to_postid( $first_image_small ); // Image ID
  $first_image_url = wp_get_attachment_image_src($thumb_id, 'pet_loop'); // Gets a custom size
  $first_image = $first_image_url[0];
}
else {
  $first_image = get_bloginfo('template_url') . '/img/default-181.png';
}

$city = get_user_meta( $author_id, 'doador_cidade', true);
$state = get_user_meta( $author_id, 'doador_estado', true);

$taxonomy_size = get_the_terms( get_the_ID(), 'tamanho');
$size = $taxonomy_size[0]->slug;

$taxonomy_species = get_the_terms( get_the_ID(), 'especie');
$species = $taxonomy_species[0]->name;

$taxonomy_sex = get_the_terms( get_the_ID(), 'sexo');
$sex = $taxonomy_sex[0]->slug;

global $pageEditPet;

// Set as adopted (Author page)
if(is_user_logged_in() && is_author()) {
  $pet_author = get_post_field('post_author', get_queried_object()->ID);
  $logged_in_user = get_current_user_id();
  if(!empty($_GET['id']) && !empty($_GET['adopted']) && $pet_author == $logged_in_user) {

    if($_GET['adopted'] == 'yes') { update_post_meta( $_GET['id'], 'animais_adocao_check', 'on' ); }
    else if($_GET['adopted'] == 'no') { delete_post_meta( $_GET['id'], 'animais_adocao_check', 'on' ); }

  }
}

$adopted = get_post_meta( get_the_ID(), 'animais_adocao_check', true);

?>

<div class="single">
  <?php if(is_user_logged_in() && is_author() && get_current_user_id() == get_the_author_meta( 'ID' ) ) { ?>
  <a id="edit" href="<?php echo get_author_posts_url( get_current_user_id() ); ?>?id=<?php echo get_the_ID(); ?>&adopted=<?php if(empty($adopted)) { echo 'yes'; } else { echo 'no'; } ?>"><?php if(!empty($adopted)) { echo 'Set for adoption'; } else { echo 'Set as adopted'; } ?></a>
  <a id="edit" href="<?php the_permalink($pageEditPet); ?>?id=<?php echo get_the_ID(); ?>">Edit</a>  
  <?php } ?>
    <div class="bg">
    <?php if(!empty($adopted)) { ?>
    <div class="adotado">
      <div class="ribbon"><span>Adopted</span></div>
    </div>
    <?php } ?>  
    <div class="head" id="imageid<?php // echo $thumb_id; ?>">
      <img title="<?php echo $species . ' porte ' . $size . ' para adoção em ' . $city . ' - ' . $state; ?>" alt="<?php echo $species . ' porte ' . $size . ' para adoção em ' . $city . ' - ' . $state; ?>" src="<?php echo $first_image; ?>">
      <a href="<?php the_permalink(); ?>"><i class="fas fa-search"></i></a>
    </div>
    <div class="info">
      <h2><a href="<?php the_permalink(); ?>"><?php $title = get_the_title(); echo mb_strimwidth($title, 0, 17, "..."); ?></a></h2>
      <p id="cidade"><a href="<?php the_permalink(); ?>"><?php echo $city . ' / ' . $state; ?></a></p>
        <div class="meta">
          <div class="size">
            <a id="tamanho" href="<?php the_permalink(); ?>"><?php echo $taxonomy_size[0]->name; ?></a>
            <!--
            <a href="<?php the_permalink(); ?>" <?php if($size == 'pequeno') { echo 'class="selected"'; } ?>>P</a>
            <a href="<?php the_permalink(); ?>" <?php if($size == 'medio') { echo 'class="selected"'; } ?>>M</a>
            <a href="<?php the_permalink(); ?>" <?php if($size == 'grande') { echo 'class="selected"'; } ?>>G</a>-->
          </div>
          <div class="gender">
            <a href="<?php the_permalink(); ?>">
              <?php
              if($sex == 'femea' && $species == 'Gato') { ?>
              <img id="sexo" src="<?php bloginfo('template_url'); ?>/img/sexo/cat_pink.png" alt="Sexo do pet">
              <?php } elseif ($sex == 'macho' && $species == 'Gato') { ?>
              <img id="sexo" src="<?php bloginfo('template_url'); ?>/img/sexo/cat_blue.png" alt="Sexo do pet">
              <?php } elseif ($sex == 'femea' && $species == 'Cachorro') { ?>
              <img id="sexo" src="<?php bloginfo('template_url'); ?>/img/sexo/dog_pink.png" alt="Sexo do pet">
              <?php } elseif ($sex == 'macho' && $species == 'Cachorro') { ?>
              <img id="sexo" src="<?php bloginfo('template_url'); ?>/img/sexo/dog_blue.png" alt="Sexo do pet">
              <?php } ?>
            </a>
          </div>
        </div>
    </div>
  </div>
</div>