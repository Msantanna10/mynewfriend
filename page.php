<?php get_header(); ?>
	
	<div class="header">
	    <div class="container small-space">
	          <h1 class="title"><?php the_title(); ?></h1>
	    </div>
	</div>
	<div class="post-page">
		<div class="body">
			<div class="container space">
				<div class="post-content">
				<?php 
					$id=get_the_ID(); 
					$post = get_post($id); 
					$content = apply_filters('the_content', $post->post_content); 
					echo $content;  
				?>	
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>