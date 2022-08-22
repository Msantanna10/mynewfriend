<?php get_header();

$descricao = get_post_meta(get_the_ID(), 'video_descricao', true);
$video = get_post_meta(get_the_ID(), 'video_file', true);

// Next - Previous videos
if(get_previous_post()) {
$prev_post = get_previous_post(); 
$prev_id = $prev_post->ID;
$prev_permalink = get_permalink( $prev_id );
}

if(get_next_post()) {
$next_post = get_next_post();
$next_id = $next_post->ID;
$next_permalink = get_permalink( $next_id );
}

if(!current_user_can('administrator')) { wpb_set_post_views(get_the_ID()); }

?>
	
	<div class="header">
        <div class="container small-space">
          <h1 class="title"><?php the_title(); ?></h1>
        </div>
     </div>
	<div class="post-page video-single">
		<div class="body">
			<div class="container space">

				<?php if(!empty($descricao)) { ?>
					<div id="desc"><?php echo wpautop($descricao); ?></div>
				<?php } ?>

				<video controls>
				  <source src="<?php echo $video; ?>" type="video/mp4">
				</video>

				<?php if(!empty($prev_post) || !empty($next_post)) { ?>
				<div class="prev-next">
					<?php if(!empty($next_post)) { ?>
						<a href="<?php echo $next_permalink; ?>" id="next">
							<span>Próximo vídeo</span>
							<i class="fas fa-chevron-left"></i>&nbsp; <?php echo get_the_title($next_id); ?>
						</a>
					<?php } ?>

					<?php if(!empty($prev_post)) { ?>
						<a href="<?php echo $prev_permalink; ?>" id="prev">
							<span>Vídeo anterior</span>
							<?php echo get_the_title($prev_id); ?> &nbsp;<i class="fas fa-chevron-right"></i>
						</a>
					<?php } ?>					
				</div>
				<?php } ?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>