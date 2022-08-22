<?php

$descricao = get_post_meta( get_the_ID(), 'product_descricao', true);
$thumbnail = wp_get_attachment_url( get_post_thumbnail_id($custom_query->ID) );
$product_url = get_post_meta( get_the_ID(), 'product_url', true);

?>

<div class="single">
  <div class="head" style="background-image: url(<?php echo $thumbnail; ?>);">
    <a href="<?php the_permalink(); ?>" target="_blank"></a>
  </div>
  <div class="content">
    <h2><a href="<?php the_permalink(); ?>" target="_blank"><?php echo mb_strimwidth(get_the_title(), 0, 150, "..."); ?></a></h2>
    <p><a href="<?php the_permalink(); ?>" target="_blank"><?php echo mb_strimwidth($descricao, 0, 350, "..."); ?></a></p>
  </div>
</div>