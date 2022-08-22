<?php get_header();

global $pageHelp, $pageSearchPage;

?>

<div class="cabecalho-home"></div>
<div class="busca">
  <div class="container">
    <div class="content">
      <h1 class="center">Find a new friend</h1>

      <?php get_template_part('template-part/search-form') ?>

    </div>
  </div>
</div>
<div class="first space">
  <div class="container">
    <h1><i class="fas fa-paw"></i> New pets <i class="fas fa-paw"></i></h1>
    <br>
    <p class="center">Here you will see the latest pets ready to be adopted ❤️</p>
    <br><br>
			
			<a href="<?php if(is_user_logged_in()) { the_permalink($pageNewPet); } else { the_permalink($pageLogIn); } ?>" id="botao-transparente" style="margin-bottom: 35px;">Share a pet for adoption!</a>
			
      <div class="all-pets">
        <?php
        $args = array(
            "post_type" => 'pet',
            "posts_per_page" => 20,
            'orderby' => 'date',
            'order' => 'DESC',
            "paged" => $paged,
        );
        $custom_query = new WP_Query( $args );

        if($custom_query->have_posts()) {
          
        while($custom_query->have_posts()) : 
        $custom_query->the_post(); 
        
        get_template_part( 'template-part/loop-pets' );
        
        endwhile; wp_reset_postdata(); } else { echo '<p id="none">No pet was found!'; } ?>
      </div>
			
      <?php if($custom_query->found_posts > 0) { ?>
			  <br><a href="<?php the_permalink($pageSearchPage); ?>" id="botao-transparente" style="max-width: 275px;">View all pets</a>
      <?php } ?>

  </div>
</div>

<div class="mural space" id="mural">     
  <div class="container">
    <h1><img src="<?php bloginfo('template_url'); ?>/img/superman.png" style="max-width: 45px;"> Mural of our Heroes and Heroines <img src="<?php bloginfo('template_url'); ?>/img/wonderwoman.png" style="max-width: 70px;"></h1>
    <br>
    <p id="main">Know the name of the people who help us by collaborating and saving our pets monthly! You too can be part of this special team ❤️</p>

    <div class="listagem">
      <div class="plano plano-a">
        <p>Jennifer Rodrigues - <span id="valor">R$ <span id="number">100</span></span></p>
        <p>Pedro Albuquerque - <span id="valor">R$ <span id="number">100</span></span></p>
        <p>Samantha Alves - <span id="valor">R$ <span id="number">100</span></span></p>
      </div>
      <div class="plano plano-b">
        <p>Jéssica Santana - <span id="valor">R$ <span id="number">50</span></span></p>
        <p>Ana Clara - <span id="valor">R$ <span id="number">50</span></span></p>
      </div>
      <div class="plano plano-c">
        <p>Lucas Costa - <span id="valor">R$ <span id="number">15</span></span></p>
      </div>
    </div>

    <a href="<?php the_permalink($pageHelp); ?>" id="botao-transparente">I want to take part! 😍</a>
  </div>
</div>

<div class="porque space">
  <div class="container">
    <h1><i class="fas fa-paw"></i> Adopt a pet <i class="fas fa-paw"></i></h1>
    <br>
    <div class="flow-root all">
      <div class="single">
        <p>
          <img src="<?php bloginfo('template_url'); ?>/img/bone-vector.png" id="float">
          nimals are loyal and faithful companions. Dogs already have this reputation for a long time, but felines are also great friends and, despite being suspicious, when their loyalty is conquered, it is eternal. Having a pet is having a great friend to accompany you on all your adventures - and in the sad moments too.
        </p>
      </div>
      <div class="single" id="right">
        <p>
          <img src="<?php bloginfo('template_url'); ?>/img/dog-vector.png" id="float">
          People who live with animals are less stressed and anxious than those who live alone. They also decrease the chances of a heart attack, heart attack and pressure fluctuation, as it makes tutors happier and less stressed - and consequently healthier.
        </p>
      </div>
      <div class="single">
        <p>
          <img src="<?php bloginfo('template_url'); ?>/img/pata-vector.png" id="float">
          Having a pet helps you be more responsible. As pets need constant care with water, food, exercise and hygiene, the caregiver creates notions of responsibility that he will take for the rest of his life, including the work environment and studies.
        </p>
      </div>
    </div>
  </div>
</div>
    
<?php get_footer(); ?>