<?php

/* Template Name: Sign Up */

$success = false;
$user_login_warning = false;

// Redirects if logged in
if(is_user_logged_in()) {

  $url = get_author_posts_url( get_current_user_id() );
  wp_safe_redirect($url);

}

// Not logged in
else {
  
  // Form validation
  if (isset( $_POST["user_login"] ) && wp_verify_nonce($_POST['register_nonce'], 'pippin-register-nonce')) {

    $user_login   = $_POST["user_login"];  
    $user_email   = $_POST["user_email"];
    $user_email_confirm   = $_POST["user_email_confirm"];
    $user_first   = $_POST["user_first"];
    $user_last    = $_POST["user_last"];
    $user_phone    = $_POST["user_phone"];
    $user_whats    = $_POST["user_whats"];
    $user_private   = (!empty($_POST["user_private"])) ? $_POST["user_private"] : NULL;
    $state    = $_POST["state"];
    $city    = (!empty($_POST["city"])) ? $_POST["city"] : NULL;
    $user_pass    = $_POST["user_pass"];
    $pass_confirm   = $_POST["user_pass_confirm"];
  
    $errors = false;

        if(username_exists($user_login)) {
          // Username already registered
          $user_login_warning = array();
          $user_login_warning[] = 'This username is taken!';
          $errors = true;
          $validate_user_login = true;
        }
        if(!empty($user_login)) {
          if(strlen($user_login) <= 3) {
              // invalid username
              $user_login_warning[] = 'Type a larger username';
              $errors = true;
              $validate_user_login = true;
          }
          if(!validate_username($user_login)) {
            // invalid username
            $user_login_warning[] = 'Use a nickname without spaces or accents';
            $errors = true;
            $validate_user_login = true;
          }
        }
        else {
            $user_login_warning[] =  'Type a nickname';
            $errors = true;
            $validate_user_login = true;
        }            
        if($user_first == '') {
          // empty name
          $user_first_warning = array();
          $user_first_warning[] = 'Type your first name';
          $errors = true;
          $validate_user_first = true;
        }
        /* if($user_last == '') {
          // empty lastname
          echo '<div class="error"><p>Digite seu sobrenome</p></div>';
          $errors = true;
          $validate_user_last = true;
        } */
        if(!is_email($user_email)) {
          //invalid email
          $user_email_warning = array();
          $user_email_warning[] = 'Invalid email';
          $errors = true;
          $validate_user_email = true;
        }
        if(email_exists($user_email)) {
          //Email address already registered
          $user_email_warning = array();
          $user_email_warning[] = 'Email already exists!';
          $errors = true;
          $validate_user_email = true;
        }
        if($user_email_confirm == '') {
          // empty name
          $user_email_confirm_warning = array();
          $user_email_confirm_warning[] = 'Type your email again';
          $errors = true;
          $validate_user_email_confirm = true;
        }
        if($user_email != $user_email_confirm) {
          // empty name
          $user_email_confirm_warning = array();
          $user_email_confirm_warning[] = 'Emails don\'t match';
          $errors = true;
          // $validate_user_email = true;
          $validate_user_email_confirm = true;
        }
        if($user_phone == '') {
          // passwords do not match
          $user_phone_warning = array();
          $user_phone_warning[] = 'Type a phone';
          $errors = true;
          $validate_user_phone = true;
        }
        if($user_whats == '') {
          // is it Whatsapp?
          $user_whats_warning = array();
          $user_whats_warning[] = 'Select if it is WhatsApp or not';
          $errors = true;
          $validate_user_whats = true;
        }
        if(empty($state)) {
          $state_warning = array();
          $state_warning[] = 'Select a state';
          $errors = true;
          $validate_estado = true;
        }
        if(empty($city)) {
          $city_warning = array();
          $city_warning[] = 'Select a city';
          $errors = true;
          $validate_cidade = true;
        }
        if($user_pass == '') {
          // passwords do not match
          $user_pass_warning = array();
          $user_pass_warning[] = 'Type a password';
          $errors = true;
          $validate_user_pass = true;
        }                                
        if($user_pass != $pass_confirm) {
          // passwords do not match
          $pass_confirm_warning = array();
          $pass_confirm_warning[] = 'Passwords don\'t match';
          $errors = true;
          $validate_user_pass = true;
          $validate_pass_confirm = true;
        } 
      
    // only create the user in if there are no errors
    if(!$errors) {
  
      $new_user_id = wp_insert_user(array(
          'user_login'    => $user_login,
          'user_pass'     => $user_pass,
          'user_email'    => $user_email,
          'first_name'    => $user_first,
          'last_name'     => $user_last,
          'user_registered' => date('Y-m-d H:i:s'),
          'role'        => 'doador'
        )
      );
      if($new_user_id) {
        // send an email to the admin alerting them of the registration
        wp_new_user_notification($new_user_id);
  
        // log the new user in
        wp_setcookie($user_login, $user_pass, true);
        wp_set_current_user($new_user_id, $user_login); 
        do_action('wp_login', $user_login);

        $success = true;

        add_user_meta($new_user_id, 'doador_telefone', $user_phone);
        add_user_meta($new_user_id, 'doador_whats', $user_whats);
        add_user_meta($new_user_id, 'doador_private', $user_private);
        add_user_meta($new_user_id, 'doador_estado', $state);
        add_user_meta($new_user_id, 'doador_cidade', $city);
  
        // send the newly created user to the home page after logging them in
        // wp_redirect(home_url());
        // exit;

        // Sends email
        $headers = array(
          'Content-Type: text/html; charset=UTF-8',
          // 'My new friend <contato@meunovoamigo.com.br>'
        );
        $html = 'It\'s a pleasure to have you with us! We are willing to help you adopt your animals, together we will make a difference!
        <br><br>
        You can log in using your <b>email</b> or your username <b>'.$user_login.'</b> through this link: '.get_the_permalink($pageLogIn).'
        <br><br>
        Use the password chosen by you and start promoting your pets <3
        <br><br>
        Remember to share your link on your social media so people can see all your registered pets and get in touch with you!
        <br><br>
        <b>Your profile link:</b> '.get_author_posts_url($new_user_id).'
        <br><br>
        Count on us!
        <br><br>
        <b>'.get_bloginfo('name').'</b>';

        wp_mail($user_email, "Successfully registered! ❤️", $html, $headers);

      }
  
    }
  
} // End sends form $_POST

get_header();

global $pageNewPet, $pageLogIn;

?>

<div class="header">
    <div class="container small-space">
          <h1 class="title"><?php the_title(); ?></h1>
    </div>
</div>
<div class="post-page">
  <div class="cadastro body">
    <div class="container space">
          
        <?php if($success == true) { ?>
        <div id="success"><p>User created successfully! <a href="<?php the_permalink($pageNewPet); ?>" target="_blank">Click</a> to add your first pet.</p></div>
        <?php } else { ?>

        <p class="center" style="max-width: 810px;margin: 0 auto;">Create your account to register, remove, edit and manage your pets! After creating your personal account, you will have access to your dashboard to add your pets for adoption. Each registered pet will have a link with all the necessary information to share it on your social networks, where there will be photos of the animal, description, your contact number, etc.
        <br><br>
        <b>First step: </b>Fill out the form below and create your account, shortly after that, you will be redirected to register your first pet for adoption so that we can help you publicize it in your region. 🥰
        </p>
        <br><br>

        <form class="form" action="" method="POST">
          <fieldset>
            <div class="row">
                <div class="col-md-3" id="left">
                  <label for="user_Login">Username</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php echo $user_login; ?>" name="user_login" id="user_login" class="nospace first-letter-lowercase required <?php if($validate_user_login) { echo 'invalid'; } ?>" type="text"/>
                  <span id="desc">Your nickname will become the address of your page here on <?php bloginfo('name'); ?>.
                  <br>
                  Example: <?php echo get_site_url(); ?>/profile/username
                  </span>
                  <?php if($user_login_warning) { ?>
                  <p id="all">
                    <?php
                    foreach($user_login_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>                          
                  <?php } ?>
                </div>
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                  <label for="user_email">Email</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php if(!empty($user_email)) { echo $user_email; } ?>" name="user_email" id="user_email" class="nospace required <?php if($validate_user_email) { echo 'invalid'; } ?>" type="email"/>
                  <span id="desc">Interested adopters can contact you by this email.</span>
                  <?php if(!empty($user_email_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($user_email_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>                          
                  <?php } ?>
                </div>                    
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                  <label for="user_email_confirm">Confirm your email</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php if(!empty($user_email_confirm)) { echo $user_email_confirm; } ?>" name="user_email_confirm" id="user_email_confirm" class="nospace required <?php if($validate_user_email_confirm) { echo 'invalid'; } ?>" type="email"/>
                  <span id="desc">We ask twice to make sure you don't make a mistake!</span>
                  <?php if(!empty($user_email_confirm_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($user_email_confirm_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>                          
                  <?php } ?>
                </div>                    
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                    <label for="user_first">Name</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php if(!empty($user_first)) { echo $user_first; } ?>" name="user_first" class="first-letter-capital nospace <?php if($validate_user_first) { echo 'invalid'; } ?>" id="user_first" maxlength="15" type="text"/>
                  <?php if(!empty($user_first_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($user_first_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>                          
                  <?php } ?>
                </div>                    
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                    <label for="user_last">Last name</label>
                </div>
                <div class="col-md-9">
                    <input value="<?php if(!empty($user_last)) { echo $user_last; } ?>" name="user_last" class="first-letter-capital" id="user_last" maxlength="15" type="text"/>
                </div>                    
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                    <label for="user_phone">WhatsApp or phone</label>
                </div>
                <div class="col-md-9">
                  <input placeholder="( &nbsp; ) ____-____" value="<?php if(!empty($user_phone)) { echo $user_phone; } ?>" name="user_phone" class="telefone <?php if($validate_user_phone) { echo 'invalid'; } ?>" id="user_phone" type="tel"/>
                  <span id="desc">Interested adopters can contact you on this number.</span>
                  <?php if(!empty($user_phone_warning)) { ?>
                    <p id="all">
                      <?php
                      foreach($user_phone_warning as $message) {
                        echo '<span>'.$message.'</span>';
                      }
                      ?>
                    </p>                              
                  <?php } ?>
                </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="user_whats">Is it WhatsApp?</label>
              </div>
              <div class="col-md-9">
                <select id="user_whats" name="user_whats" class="<?php if($validate_user_whats) { echo 'invalid'; } ?>">
                  <option value="">--- Select an option ---</option>
                  <option value="sim" <?php if(!empty($user_whats) && $user_whats == 'sim') { echo 'selected'; } ?>>Yes, it's WhatsApp</option>
                  <option value="nao" <?php if(!empty($user_whats) && $user_whats == 'nao') { echo 'selected'; } ?>>No, it's not WhatsApp</option>
                </select>
                <?php if(!empty($user_whats_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($user_whats_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>                          
                <?php } ?>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="user_private">Private phone</label>
              </div>
              <div class="col-md-9">
                <label>
                  <input value="on" name="user_private" class="privado" id="user_private" type="checkbox" <?php if(!empty($user_private)) { echo 'checked'; } ?>/>
                  Hide phone?
                  <span id="desc">By checking this option, only our team will be able to see your phone. But this option greatly reduces the chances of an adopter contacting you.</span>
                </label>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="state">State</label>
              </div>
              <div class="col-md-9">
                <select id="state" name="state" class="<?php if(!empty($validate_estado)) { echo 'invalid'; } ?>">
                  <option value="">--- Select an option ---</option>
                </select>   
                <?php if(!empty($state_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($state_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                  ?>
                  </p>                              
                <?php } ?>     
              </div>                    
            </div>          
            <div class="row">                   
              <div class="col-md-3" id="left">
                <label for="city">City</label>
              </div>
              <div class="col-md-9">
                <select id="city" name="city" class="<?php if(!empty($validate_cidade)) { echo 'invalid'; } ?>">
                  <option value="">--- Select a city ---</option>
                </select>  
                <?php if(!empty($city_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($city_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>                
            <div class="row">                   
              <div class="col-md-3" id="left">
                <label for="password">Password</label>
              </div>
              <div class="col-md-9">
                <input name="user_pass" id="password" class="required <?php if(!empty($validate_user_pass)) { echo 'invalid'; } ?>" type="password"/>
                <?php if(!empty($user_pass_warning)) { ?>
                  <p id="all">
                    <?php
                    foreach($user_pass_warning as $message) {
                      echo '<span>'.$message.'</span>';
                    }
                    ?>
                  </p>
                <?php } ?>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                <label for="password_again">Confirm your password</label>
              </div>
              <div class="col-md-9">
                <input name="user_pass_confirm" id="password_again" class="required <?php if($validate_user_pass || $validate_pass_confirm) { echo 'invalid'; } ?>" type="password"/>
                <?php if(!empty($pass_confirm_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($pass_confirm_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                            
                <?php } ?>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                <input type="hidden" name="register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
              </div>
              <div class="col-md-9">
                <input type="submit" value="Create account"/>
              </div>                    
            </div>
          </fieldset>
        </form>

        <?php } ?>

    </div>
  </div>
</div>

<script>
/* Loading on form submit */
$("form").submit(function(){ $('.loadingPage').fadeIn(3000); });
</script>
    
<?php get_footer(); } // Fim usuário não logado ?>