<?php
##################### SCRIPTS
function custom_scripts() {
  global $pageEditProfile, $pageSignUp, $pageContact, $pageSearchPage;

  // De-register the built in jQuery
  wp_deregister_script('jquery');
  // Register the CDN version
  wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, false); 
  // Register Slick
  wp_register_script('slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, false); 
  // Register Bootstrap
  wp_register_script('bootstrap', get_template_directory_uri() .'/js/bootstrap.min.js', array('jquery'), null, false);   
  // Load new jquery
  wp_enqueue_script( 'jquery' );  
  // Extra scripts
  wp_enqueue_script('extra-scripts', get_template_directory_uri() .'/js/extra.js', array('jquery','bootstrap'), null, true);
  // Cookie
  wp_register_script('cookie-custom', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', array('jquery'), null, false); 
  // Load Cookie JS
  wp_enqueue_script( 'cookie-custom' );  
  // Cookie help modal
  wp_enqueue_script('cookie-help-modal', get_template_directory_uri() .'/js/cookie-modal-help.js', array('jquery','cookie-custom'), null, true);
  // Phone mask
  if(is_page(array($pageEditProfile, $pageSignUp, $pageContact)) || is_singular('pet')) {
    wp_enqueue_script('mask-scripts', get_template_directory_uri() .'/js/jquery.mask.js', array('jquery'), null, true); 
    wp_enqueue_script('mask-phone', get_template_directory_uri() .'/js/phone-field.js', array('jquery','mask-scripts'), null, true); 
  }
  // Pet posts
  if(is_singular('pet')) {
    wp_enqueue_script( 'slick-slider' ); 
    wp_enqueue_script('single-pet', get_template_directory_uri() .'/js/single-pet.js', array('jquery','slick-slider'), null, true); 
  }
  // Author
  if(is_author()) {
    wp_enqueue_script('author-js', get_template_directory_uri() .'/js/author.js', array('jquery'), null, true); 
  }
  // Search page or Home
  if(is_page($pageSearchPage)) {
    wp_enqueue_script('author-js', get_template_directory_uri() .'/js/search-page.js', array('jquery'), null, true); 
  }
  // Sign Up page or Edit Profile
  if(is_page(array($pageSignUp, $pageEditProfile))) {
    wp_enqueue_script('signup-js', get_template_directory_uri() .'/js/signup.js', array('jquery'), null, true); 
  }
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

##################### CUSTOM CSS
function custom_css_enqueue() {
  // Pet posts
  if(is_singular('pet')) {
    wp_enqueue_style( 'slick-slider-external', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', false, '1.0', 'all' );
    wp_enqueue_style( 'slick-slider-external-theme', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', false, '1.0', 'all' );
  }
}
add_action( 'wp_enqueue_scripts', 'custom_css_enqueue' );
// wp_enqueue_style( 'slick-slider-external', get_template_directory_uri() . '/css/my-style.css', false, '1.0', 'all' ); // Inside a parent theme


?>