<?php

/* Template Name: Log In */

// If logged in, redirect to author page
if(is_user_logged_in()) {
  $url = get_author_posts_url( get_current_user_id() );
  wp_redirect($url);
  exit();
}

// If login attempt
if($_POST) {
  
  global $wpdb;  
  
  //We shall SQL escape all inputs  
  $username = esc_sql($_REQUEST['username']);  
  $password = esc_sql($_REQUEST['password']);  
  $remember = esc_sql($_REQUEST['rememberme']);  

  if ( ! empty( $username ) && is_email( $username ) ) {
    if ( $user = get_user_by_email( $username ) ) {
      $username = $user->user_login;
    }
  }
  
  if($remember) $remember = "true";  
  else $remember = "false";  
  
  $login_data = array();  
  $login_data['user_login'] = $username;  
  $login_data['user_password'] = $password;  
  $login_data['remember'] = $remember;  
  
  $user_verify = wp_signon( $login_data, false );   

  $error = false;
  
  if ( is_wp_error($user_verify) ) {  
      $error = true;  
  }
  else { 

    wp_setcookie($username, $password, true);
    wp_set_current_user($user_verify->ID); 
    do_action('wp_login', $username);

    $url = get_author_posts_url( get_current_user_id() );
    wp_redirect($url);
    exit();
    
  }  
             
}

get_header(); ?>

<div class="header">
    <div class="container small-space">
          <h1 class="title"><?php the_title(); ?></h1>
    </div>
</div>
<div class="post-page">
  <div class="entrar body">
      <div class="container space">
          <?php if($error == true) { echo '<p id="invalid">Invalid, please try again.</p>'; } ?>
          <form id="login" name="form" action="" method="post">  
                  <input id="username" type="text" placeholder="Username or email" name="username"><br>  
                  <input id="password" type="password" placeholder="Password" name="password">  
                  <label><input id="rememberme" type="checkbox" name="rememberme" checked>Remember me</label>
                  <input id="submit" type="submit" name="submit" value="Sign In">  
          </form>  

          <ul>
            <li><a href="<?php the_permalink($pageSignUp); ?>">I don't have an account, create an account.</a></li>
            <li><a href="<?php echo wp_lostpassword_url(); ?>">I forgot my password.</a></li>
          </ul>

      </div>
  </div>
</div>

<script>
/* Loading on form submit */
$("form").submit(function(){ $('.loadingPage').fadeIn(3000); });
</script>

<?php get_footer(); ?>