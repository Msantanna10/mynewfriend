<?php

$author_id = $post->post_author;

$gallery = get_post_meta( get_the_ID(), 'animais_galeria', 1);
$gallery = str_replace('-150x150','',$gallery);

$city = get_user_meta( $author_id, 'doador_cidade', true);
$state = get_user_meta( $author_id, 'doador_estado', true);

$taxonomy_sex = get_the_terms( get_the_ID(), 'sexo');
$sexo = $taxonomy_sex[0]->name;

$taxonomy_size = get_the_terms( get_the_ID(), 'tamanho');
$tamanho = $taxonomy_size[0]->name;

$taxonomy_species = get_the_terms( get_the_ID(), 'especie');
$especie = $taxonomy_species[0]->name;

$temperament = get_the_terms( get_the_ID(), 'temperamento');
$sociability = get_the_terms( get_the_ID(), 'sociabilidade');
$lives_well_in = get_the_terms( get_the_ID(), 'ambiente');
$special_care = get_the_terms( get_the_ID(), 'cuidados');

$description = get_post_meta( get_the_ID(), 'animais_descricao', true );

$phone = get_user_meta( $author_id, 'doador_telefone', true );
$whats = get_user_meta( $author_id, 'doador_whats', true );

$adopted = get_post_meta( get_the_ID(), 'animais_adocao_check', true);

global $pageNewPet, $pageLogIn, $cf7AdoptionFormID;

get_header(); ?>

<div class="post-page single-pet pet<?php echo get_the_ID(); ?>">
  <?php if(!empty($adopted)) { ?>
  <div class="more-pets small-space" id="adotado">
    <div class="container">
      <h1>Este animalzinho já foi adotado! Outros que estão esperando por você</h1>
      <br>
      <div class="all-pets">
        <?php
          $args = array(/*'role__in' => array('administrator','doador')*/);

            // Cidade
            if( !empty($city) )
              $args['meta_query'][] = array(
                'key' => 'doador_cidade',
                'value' => $city
            );

            $donors = get_users( $args );

            $donor_ids = array();
            foreach($donors as $donor) { $donor_ids[] = $donor->ID; }

            $authors = implode(',', $donor_ids);

            if(empty($authors)) { $authors = 9999999; }

            $args = array(
              'author' => $authors,
              "post_type" => 'pet',
              "posts_per_page" => 5,
              'orderby' => 'date',
              'order' => 'DESC',
              'post__not_in' => array(get_the_ID())
            );
              
            $custom_query = new WP_Query( $args );
              
            if($custom_query->have_posts()) {

            while($custom_query->have_posts()) : 
            $custom_query->the_post(); 
            
            // template
            get_template_part( 'template-part/loop-pets' );

            wp_reset_postdata();

            ?>
            
            <?php endwhile; } else { echo '<p id="none">Nenhum pet encontrado! Tente novamente outra busca. <a href="'.get_the_permalink($pageSearchPage).'" id="botao">Ver todos os pets</a></p>'; } ?>
      </div>

    </div>
  </div>
  <?php } ?>

  <div class="header">
    <div class="container">
      <h1><?php the_title(); ?><?php if(!empty($adopted)) { echo ' (adotado)'; } ?></h1>
      <br>
      <h2><?php echo $city . ' / ' . $state; ?></h2>
    </div>
  </div>

  <div class="body">
  <!-- Modal CTA WhatsApp after form submission -->
  <div id="ModalWhats" class="modal fade in whats" role="dialog" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-body">
          <h2>Seu e-mail foi enviado com sucesso! 😍</h2>
          <p style="padding-bottom: 10px;">Para obter sua resposta o quanto antes, entre em contato com a(o) responsável pelo WhatsApp clicando no botão abaixo!</p>
          <a id="action" target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo $phone; ?>&text=Olá, encontrei seu contato no site *<?php bloginfo('name'); ?>* e tenho interesse em adotar o pet *<?php the_title(); ?>*%0A%0A<?php the_permalink(); ?>">Chamar no WhatsApp <i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="main small-space">
    <div class="container">

    <a href="<?php if(is_user_logged_in()) { the_permalink($pageNewPet); } else { the_permalink($pageLogIn); } ?>" id="botao-transparente" style="margin-bottom: 35px;">Divulgue um pet para adoção!</a>

    <nav class="breadcrumbs">
      <ul>
        <li><a href="<?php echo get_site_url(); ?>">Início</a></li>
        <li><a href="<?php echo get_the_permalink($pageSearchPage); ?>"><?php echo get_the_title($pageSearchPage); ?></a></li>
        <li><a href="<?php echo get_the_permalink($pageSearchPage) . sanitize_title($state); ?>"><?php echo $state; ?></a></li>
        <li><a href="<?php echo get_the_permalink($pageSearchPage) . sanitize_title($state) . '/' . sanitize_title($city); ?>"><?php echo $city; ?></a></li>
        <li><?php the_title(); ?></li>
      </ul>
    </nav>

      <div class="row">
        <div class="col-md-8">
          <?php if($gallery) { ?>
          <div class="galeria">
            <div class="pet-galeria">
              <?php             
              foreach($gallery as $img) {

              $thumb_id = attachment_url_to_postid( $img );
              $first_image_url = wp_get_attachment_image_src($thumb_id, 'large');
              // Pega a primeira imagem e utiliza a versão pequena
              $first_image = $first_image_url[0];
                
              ?>

                <div class="single">
                  <div class="bg">
                    <img alt="<?php echo $especie . ' ' . $tamanho . ' para adoção em ' . $city . ' - ' . $state; ?>" src="<?php echo $first_image; ?>">
                  </div>
                </div>

              <?php } ?>
            </div>
            <div class="pet-nav">
              <?php

              foreach($gallery as $img) {

              $thumb_id = attachment_url_to_postid( $img );
              $first_image_url = wp_get_attachment_image_src($thumb_id, 'medium');
              // Pega a primeira imagem e utiliza a versão pequena
              $first_image = $first_image_url[0];
                
              ?>

                <div class="single">
                  <div class="bg" style="background-image: url(<?php echo $first_image; ?>);"></div>
                </div>

              <?php } ?>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="col-md-4" id="right">
          <div class="bloco">
            <h2>Informações importantes</h2>
            <br>
            <p id="main"><i class="fas fa-check"></i> <?php echo $especie; ?></p>
            <p id="main"><i class="fas fa-check"></i> Sexo: <?php echo $sexo; ?></p>
            <p id="main"><i class="fas fa-check"></i> Porte: <?php echo $tamanho; ?></p>

            <p id="author">
              Cadastrado por: <a href="<?php echo get_author_posts_url( $author_id ) ?>"><?php echo get_the_author_meta('nickname', $author_id); ?></a>
            </p>
          </div>
          <?php if(empty($adopted)) { ?>
          <div class="bloco" id="form">
            <?php echo do_shortcode('[contact-form-7 id="'.$cf7AdoptionFormID.'" title="Interesse em adoção"]'); ?>
          </div>
          <?php } ?>
        </div>
      </div>

      <?php if(empty($adopted)) { ?>
      <div class="block-phone">
        <div class="container">
          <p>Você pode entrar em contato através do formulário acima ou clicando no telefone:</p>
          <div class="buttons <?php if($whats == 'sim') { echo 'two'; } else { echo 'one'; } ?>">
            <div class="single" id="fixo">
              <a href="tel:<?php echo $phone; ?>"><i class="fas fa-phone fa-flip-horizontal"></i> Ligar <span><?php echo $phone; ?></span></a>
            </div>
            <div class="single" id="whats">
              <a target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo $phone; ?>&text=Olá, encontrei seu contato no site *<?php bloginfo('name'); ?>* e tenho interesse em adotar o pet *<?php the_title(); ?>*%0A%0A<?php the_permalink(); ?>"><i class="fab fa-whatsapp"></i> <?php echo $phone; ?></a>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      <div class="myads" style="margin-top: 30px">
        <!-- GOOGLE ADS - Single PET
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
              style="display:block"
              data-ad-client="ca-pub-8262297399771055"
              data-ad-slot="6090280331"
              data-ad-format="auto"
              data-full-width-responsive="true"></ins>
        <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
        </script> -->
        <a class="hide991" rel="nofollow" target="_blank" href="https://go.hotmart.com/J56703569S">
          <img src="https://formulanegocioonline.com/afiliados/banners/banner-formulanegocioonline-728x90-4.jpg" style="max-width: 728px;margin: 0 auto;display: block;">
        </a>

        <a class="show991" rel="nofollow" target="_blank" href="https://go.hotmart.com/J56703569S">
          <img src="https://formulanegocioonline.com/afiliados/banners/banner-formulanegocioonline-300-14.jpg" style="max-width: 300px;margin: 0 auto;display: block;">
        </a>
      </div>

    </div>
  </div>
  <div class="info small-space">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div id="desc">
            <h2>A história de <?php the_title(); ?></h2>
            <?php 
            if($description) {
              echo wpautop( $description );
            }
            else {
              echo 'Oiii estou precisando de um lar, adoraria que você fosse minha nova companhia ❤️ <br><br>É bem simples, basta entrar em contato com a pessoa responsável por mim através do formulário de contato nessa página ou pelo número de telefone abaixo. <br><br>Estou aguardando por você, não me deixe esperando mais 💕';
            }
            ?>
          </div>
        </div>
        <div class="col-md-3">
          <?php if($temperament) { ?>
          <div id="temp">
              <h2>Temperamento</h2>
              <?php foreach( $temperament as $item ) { ?>
                <p><i class="fas fa-check"></i> <?php echo $item->name; ?></p>
              <?php } ?>
          </div>
          <?php } ?>
          <?php if($sociability) { ?>
          <div id="sociavel">
              <h2>Sociável com</h2>
              <?php foreach( $sociability as $item ) { ?>
                <p><i class="fas fa-check"></i> <?php echo $item->name; ?></p>
              <?php } ?>
          </div>
          <?php } ?>
        </div>
        <div class="col-md-3">
          <?php if($lives_well_in) { ?>
          <div id="ambiente">
              <h2>Vive bem em</h2>
              <?php foreach( $lives_well_in as $item ) { ?>
                <p><i class="fas fa-check"></i> <?php echo $item->name; ?></p>
              <?php } ?>
          </div>
          <?php } ?>
          <?php if($special_care) { ?>
          <div id="cuidados">
              <h2>Cuidados</h2>
              <?php foreach( $special_care as $item ) { ?>
                <p><i class="fas fa-check"></i> <?php echo $item->name; ?></p>
              <?php } ?>
          </div>
          <?php } ?>
        </div>
      </div>

      <div class="share">
        <h3><i class="fas fa-paw"></i> Compartilhe este peludo com suas amizades <i class="fas fa-paw"></i></h3>
        <div class="botoes">
          <a target="_blank" id="whats" href="https://api.whatsapp.com/send?text=Vi este pet e lembrei de você 😍%0A%0A<?php the_permalink(); ?>"><i class="fab fa-whatsapp"></i></a>
          <a target="_blank" id="face" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fab fa-facebook-square"></i></a>
        </div>
      </div>

    </div>
  </div>
  <?php if(empty($adopted)) { ?>
  <div class="more-pets small-space">
    <div class="container">
      <h1>Mais animais para adoção em <?php echo $city; ?></h1>
      <br>
      <div class="all-pets">
        <?php
            $args = array(/*'role__in' => array('administrator','doador')*/);

            // Cidade
            if( !empty($city) )
              $args['meta_query'][] = array(
                'key' => 'doador_cidade',
                'value' => $city
            );

            $donors = get_users( $args );

            $donor_ids = array();
            foreach($donors as $donor) {
                $donor_ids[] = $donor->ID;
            }

            $authors = implode(',', $donor_ids);

            if(empty($authors)) { $authors = 9999999; }

            $args = array(
                'author' => $authors,
                "post_type" => 'pet',
                "posts_per_page" => 5,
                'orderby' => 'date',
                'order' => 'DESC',
                'post__not_in' => array(get_the_ID())
            );
              
            $custom_query = new WP_Query( $args );
              
            if($custom_query->have_posts()) {

            while($custom_query->have_posts()) : 
            $custom_query->the_post(); 
            
            // template
            get_template_part( 'template-part/loop-pets' );
      
            wp_reset_postdata();

            endwhile; } else { echo '<p id="none">Nenhum pet encontrado! Tente novamente outra busca. <a href="'.get_the_permalink($pageSearchPage).'" id="botao">Ver todos os pets</a></p>'; } ?>
      </div>

    </div>
  </div>
  <?php } ?>
</div>

<script>
$('form textarea[name="mensagem"]').val('Olá, tenho interesse em adotar o pet! <?php echo get_the_title(); ?>.');
$('input[name="current-pet"]').val('<?php echo get_the_ID(); ?>');
</script>

<script>
$('.block-phone a').on('click', function(){
  $.ajax({
    type: "POST",
    url: '<?php echo admin_url('admin-ajax.php'); ?>',
    data:{action:'phone_cliques_call', postID: <?php echo get_the_ID(); ?>},
    success:function(html) {
      // success
    }
  });
});
</script>

<?php get_footer(); ?>