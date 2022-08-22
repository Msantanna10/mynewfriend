<!DOCTYPE html>
<html lang="pt-br">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
    global $pageAbout, $pageProducts, $pageSearchPage, $pageHelp, $pageContact, $pageNewPet, $pageEditPet, $pageEditProfile, $pageSignUp, $pageLogIn;

    ################ Default meta description (it'll change based on conditions)
    $seo_description = 'Animals for responsible adoption in all cities in Brazil! Cats and dogs looking for a new home ❤️ Share your animals for adoption or adopt a pet today 😍';
    $seo_image = get_bloginfo('template_url') . '/img/ogimage.png';            

    ################ Single pet page
    if(is_singular('pet')) {
      $seo_description = mb_strimwidth(get_post_meta( get_the_ID(), 'animais_descricao', true ), 0, 200, "..."); // Trims their description
      $thumb = get_post_meta( get_the_ID(), 'animais_galeria', 1); // Find the image gallery
      $seo_image = reset($thumb); // Gets first image from gallery as og:image (WhatsApp, Facebook)
    }
    ################ It's an affiliate product
    else if(is_singular('product')) {
      $seo_image = wp_get_attachment_url( get_post_thumbnail_id($custom_query->ID) ); // Gets its thumbnail
      $seo_description = get_post_meta( get_the_ID(), 'product_descricao', true); // Gets its description
    }
    ################ Search/adoption page    
    else if(is_page($pageSearchPage)) {
      // Custom query vars for SEO / Friendly URLs
      $state_query_very = get_query_var('estado_query'); // website.com/brazilian-state/
      $city_query_var = get_query_var('cidade_query'); // website.com/brazilian-state/brazilian-city

        // Change page title if state or city are valid
        $city = (slugToString($city_query_var) && get_query_var('cidade_query') != 'any-city') ? slugToString($city_query_var)['city-with-accents'] : NULL;
        $state = (slugToString($state_query_very) && get_query_var('estado_query') != 'any-state') ? slugToString($state_query_very)['state-with-accents'] : NULL;          
        $seo_image = get_bloginfo('template_url') . '/img/ogimage.png';

        // City is valid and not NULL, so add both city and its state to the title
        if(!empty($city)) {
          $seo_description = 'Cats and dogs for adoption in ' . $city . ', ' . $state . '. Animals of all sizes: puppies, medium and large. Adopt a friend today!';
        }
        // City is not valid, keep only state in the title
        else {
          $seo_description = 'Cats and dogs for adoption in ' . $state . '. Animals of all sizes: puppies, medium and large. Adopt a friend today!';
        }
    }
    //// FIM É PRODUTO
    
    ///////////////// FIM É PET

    ///////////////// TÍTULO
    if(is_home()) {
        $seo_title = get_bloginfo('name');
    }
    else {
        if(is_author()) {
            $author = get_queried_object();
            $author_id = $author->ID;
            $name = get_the_author_meta('first_name', $author_id);
            $last_name = get_the_author_meta('last_name', $author_id);
            $seo_title = $name . ' ' . $last_name;
        }
        elseif(is_page($pageSearchPage)) {
            // Search/Adoption page
            $city = (slugToString($city_query_var) && get_query_var('cidade_query') != 'any-city') ? slugToString($city_query_var)['city-with-accents'] : NULL;
            $state = (slugToString($state_query_very) && get_query_var('estado_query') != 'any-state') ? slugToString($state_query_very)['state-with-accents'] : NULL;          
            $specie = get_query_var('especie_query');
            $size = get_query_var('tamanho_query');

            if(!empty($state_query_very) || !empty($city_query_var) || !empty($specie) || !empty($size)) {

              if(empty($specie) || $specie == 'any-species') {
                $specie = 'Gatos e cachorros';
              }
              else {
                $specie = ucfirst($specie) . 's';
              }

              if(!empty($city)){
                $city = ' em ' .$city . ' | ';
              }
              else {
                if(empty($state)) {
                  $city = '| ';
                }
                else {
                  $city = NULL;
                }
              }

              if(!empty($state)){
                if(!empty($city)) {
                  $state = $state . ' | ';
                }
                else {
                  $state = ' | ' . $state . ' | ';
                }
              }
              else {
                $state = NULL;
              }

              ############# CREATES TITLE
              $seo_title = $specie . ' for adoption '.$city . $state. get_bloginfo('name');
              ############# END CREATES TITLE

            }
            else {
              $seo_title = 'Animals for adoption in Brazil | ' . get_bloginfo('name') . ' | ' . get_bloginfo('description');
            }
        }
        else {
            $seo_title = get_the_title();
        }
    }
    ///////////////// FIM TÍTULO
    ?>

    <meta name="description" content="<?php echo $seo_description; ?>">
    <meta name="keywords" content="my new friend, adoption, adopt, pet, dog, cat">
    <meta name="author" content="Moacir Sant'anna">
	 
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:title" content="<?php echo $seo_title; ?>">
    <meta property="og:description" content="<?php echo $seo_description; ?>">

    <meta property="og:image" content="<?php echo $seo_image; ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">

    <title><?php if(is_home()) { echo bloginfo('name') . ' | '; echo bloginfo('description'); } else if(is_singular('pet')) { $author_id = $post->post_author; $city = get_user_meta( $author_id, 'doador_cidade', true); $state = get_user_meta( $author_id, 'doador_estado', true); $taxonomy_especie = get_the_terms( get_the_ID(), 'especie'); $specie = $taxonomy_especie[0]->name; echo 'Adoção de ' . $specie . ' | ' . $city . /*' - ' . $state .*/ ' | ' ; echo get_the_title() . ' | ' ; echo bloginfo('name'); } elseif (is_author()) {

     $author = get_queried_object();
     $author_id = $author->ID;
     echo get_the_author_meta('first_name', $author_id);
     $last_name = get_the_author_meta('last_name', $author_id);
     if(!empty($last_name)) { echo ' ' . $last_name; }
     $city = get_user_meta( $author_id, 'doador_cidade', true);

     echo ' | Pets em ' . $city . ' | ' . get_bloginfo('name');

    } elseif(is_page($pageSearchPage)) { echo $seo_title; } else { echo get_the_title() . ' | '; echo bloginfo('name') . ' | '; echo bloginfo('description'); } ?></title>
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon.png">

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;500;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">

    <?php wp_head(); ?>

    <?php if(!current_user_can('administrator')) { wpb_set_post_views(get_the_ID()); } ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4JJ3WZV37"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-D4JJ3WZV37');
    </script>

  </head>

  <body <?php $new_classes = array(); if(is_singular('pet')) { $adopted = get_post_meta( get_the_ID(), 'animais_adocao_check', true); if(!empty($adopted)) { $new_classes[] = 'pet-adotado'; } } body_class($new_classes); ?>>

    <!-- Navigation -->
    <nav class="navbar navbar-default fixed-top">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="logo"><a href="<?php echo get_site_url(); ?>"><img class="nolazy" alt="My New Friend - Cats and dogs" src="<?php bloginfo('template_url'); ?>/img/logo.png"></a></div>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
            <li><a href="<?php the_permalink($pageAbout); ?>">About</a></li>
            <li><a href="<?php the_permalink($pageProducts); ?>">Products</a></li>
            <li><a href="<?php the_permalink($pageSearchPage); ?>">Search</a></li>
            <li><a href="<?php if(!is_home()) { echo get_site_url() . '/'; } ?>#mural">Help</a></li>
            <li><a href="<?php the_permalink($pageContact); ?>">Contact us</a></li>
            <?php if(!is_user_logged_in()) { ?><li class="special cadastro"><a href="<?php the_permalink($pageSignUp); ?>">Sign Up</a></li>
            <li class="special login"><a href="<?php the_permalink($pageLogIn); ?>">Sign In</a></li><?php } else { ?>
            <li class="dropdown orange">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#"style="background-color: #ff9800">My pets / My account <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <?php if(current_user_can('administrator')) { ?><li><a href="<?php echo admin_url(); ?>">Administrator (WP)</a></li><?php } ?>
                  <li><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>">My pets / My account</a></li>
                  <li><a href="<?php the_permalink($pageNewPet); ?>">Add new pet</a></li>
                  <li><a href="<?php the_permalink($pageEditProfile); ?>">Edit profile</a></li>
                  <li id="sair"><a href="<?php echo wp_logout_url( get_the_permalink($pageLogIn) ); ?>">Logout</a></li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="conteudo">

      <div id="ModalAjuda" class="modal fade in" role="dialog" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-body">
              <h2>Collaborate with our project! Help the pets and appear on our Superheroes wall! 😍</h2>
              <img alt="Curso adestramento descomplicado - Capa do curso - Logo" src="<?php bloginfo('template_url'); ?>/img/planos/plano2.png">
              <a id="action" href="<?php if(!is_home()) { echo get_site_url() . '/'; } ?>#mural" data-dismiss="modal">How does it work?? 😍</a>
            </div>
          </div>
        </div>
      </div>

      <div class="loadingPage">
        <div class="container">
          <div class="content">
            <div class="loading">
              <div class="load-wrapp">
                <div class="load-3">
                  <div class="line"></div>
                  <div class="line"></div>
                  <div class="line"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>