<?php

/* Template Name: Contact Us */

get_header(); ?>
	
<div class="header">
	<div class="container small-space">
		<h1 class="title"><?php the_title(); ?></h1>
	</div>
	</div>
<div class="post-page">
	<div class="body">
		<div class="container space">
		<p class="center">You can leave your contact message for suggestions, questions and partnerships through the form below. We will respond in less than 24 hours ❤️</p>
		<br>
		<?php 
		global $cf7ContactFormID;
		echo do_shortcode('[contact-form-7 id="'.$cf7ContactFormID.'" title="Contato"]')  ;
		?>	
		</div>
	</div>
</div>

<?php get_footer(); ?>