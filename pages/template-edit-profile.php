<?php

/* Template Name: Edit profile */

$success = false;

// Redirects to home if user is not logged in
if(!is_user_logged_in()) { wp_safe_redirect(home_url()); }

// Default values for the current pet
$id = get_current_user_id();
$user_first = get_user_meta($id, 'first_name', true);
$user_last = get_user_meta($id, 'last_name', true);
$user_phone = get_user_meta($id, 'doador_telefone', true);
$user_whats = get_user_meta($id, 'doador_whats', true);
$user_private = get_user_meta($id, 'doador_privado', true);
$state = get_user_meta($id, 'doador_estado', true);
$city = get_user_meta($id, 'doador_cidade', true);

// Custom function to check if object array contains term
function termsContainsSlug($slug, $terms) {
  $terms = array_map(function($term) { return $term->to_array(); }, $terms);
  return array_search($slug, array_column($terms, 'term_id')) > 0;
}

// If form submits...
if ($_POST) {

  $user_first   = $_POST["user_first"];
  $user_last    = $_POST["user_last"];
  $user_phone    = $_POST["user_phone"];
  $user_whats    = $_POST["user_whats"];
  $user_private   = (!empty($_POST["user_private"])) ? $_POST["user_private"] : NULL;
  $state    = $_POST["state"];
  $city    = (!empty($_POST["city"])) ? $_POST["city"] : NULL;
  // $gallery = $_FILES["gallery"];

  $errors = false;

  if($user_first == '') {
    // empty name
    $user_first_warning = array();
    $user_first_warning[] = 'Type your first name';
    $errors = true;
    $validate_user_first = true;
  }
  if($user_phone == '') {
    // passwords do not match
    $user_phone_warning = array();
    $user_phone_warning[] = 'Type a phone';
    $errors = true;
    $validate_user_phone = true;
  }
  if($user_whats == '') {
    // é whatsapp?
    $user_whats_warning = array();
    $user_whats_warning[] = 'Select if it\'s WhatsApp or not';
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

  // only updates user if there are no errors
  if(!$errors) {
    update_user_meta($id, 'first_name', $user_first); // First name
    update_user_meta($id, 'last_name', $user_last); // Last name
    update_user_meta($id, 'doador_telefone', $user_phone); // Phone
    update_user_meta($id, 'doador_whats', $user_whats); // Is it WhatsApp?
    update_user_meta($id, 'doador_privado', $user_private); // Private phone?
    update_user_meta($id, 'doador_estado', $state); // State
    update_user_meta($id, 'doador_cidade', $city); // City
    $success = true;
  }
  
}

get_header(); ?>

<div class="header">
    <div class="container small-space">
          <h1 class="title"><?php the_title(); ?></h1>
    </div>
</div>
<div class="post-page">
  <div class="cadastro body">
    <div class="container space">
          
        <?php if($success == true) { ?>
        <div id="success"><p>Account successfully updated! <a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>">Click here</a> to view all your pets.</p></div>
        <?php } else { ?>

        <form class="form" action="" method="POST" enctype="multipart/form-data">
          <fieldset>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="user_first">Name</label>
              </div>
              <div class="col-md-9">
                <input value="<?php if(!empty($user_first)) { echo $user_first; } ?>" name="user_first" class="first-letter-capital nospace <?php if($user_first_warning) { echo 'invalid'; } ?>" id="user_first" maxlength="15" type="text"/>
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
                  <option value="sim" <?php if($user_whats == 'sim') { echo 'selected'; } ?>>Yes, it's WhatsApp</option>
                  <option value="nao" <?php if($user_whats == 'nao') { echo 'selected'; } ?>>No, it's not WhatsApp</option>
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
                  <span id="desc">By checking this option, only our team will be able to see your phone. But this option greatly reduces the chances of an adopter contacting.</span>
                </label>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="state">State</label>
              </div>
              <div class="col-md-9">
                <select id="state" name="state" class="<?php if(!empty($validate_estado)) { echo 'invalid'; } ?>">
                  <option value="">--- Select a state ---</option>
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
                <input type="hidden" name="register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
              </div>
              <div class="col-md-9">
                <input type="submit" value="Update profile"/>
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

<script>
// Sets values for states and cities
setTimeout(() => {
  $('select[name="state"]').val('<?php echo $state; ?>').change();
  $('select[name="city"]').val('<?php echo $city; ?>');
}, 500); 
</script>
    
<?php get_footer(); ?>