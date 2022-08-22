<?php

/* Template Name: Edit Pet */

$success = false;
$user_login_warning = false;

// Redirects to home if user is not logged in
if(!is_user_logged_in()) { wp_safe_redirect(home_url()); }

// Check if current user is the pet author, if not, redirect to the author page
$pet_author = get_post_field('post_author', $_GET['id']);
$logged_in_user = get_current_user_id();
if($pet_author != $logged_in_user) { wp_safe_redirect(get_author_posts_url( get_current_user_id() )); }

// Default values for the current pet
$pet_name = get_the_title( $_GET['id'] );
$pet_description = get_post_meta( $_GET['id'], 'animais_descricao', true );
$species = get_the_terms( $_GET['id'], 'especie' )[0]->term_id;
$sex = get_the_terms( $_GET['id'], 'sexo' )[0]->term_id;
$size = get_the_terms( $_GET['id'], 'tamanho' )[0]->term_id;
$special_care = get_the_terms( $_GET['id'], 'cuidados' );
$lives_well_in = get_the_terms( $_GET['id'], 'ambiente' );
$temperament = get_the_terms( $_GET['id'], 'temperamento' );
$sociability = get_the_terms( $_GET['id'], 'sociabilidade' );

// Custom function to check if object array contains term
function termsContainsSlug($slug, $terms) {
  $terms = array_map(function($term) { return $term->to_array(); }, $terms);
  return array_search($slug, array_column($terms, 'term_id')) > 0;
}

// If form submits...
if ($_POST) {

  $pet_name = $_POST["pet_name"];  
  $pet_description = $_POST["pet_description"];  
  $species = (!empty($_POST["species"])) ? $_POST["species"] : NULL;  
  $sex = (!empty($_POST["sex"])) ? $_POST["sex"] : NULL;  
  $size = (!empty($_POST["size"])) ? $_POST["size"] : NULL;  
  $special_care = (!empty($_POST["special_care"])) ? $_POST["special_care"] : NULL;  
  $lives_well_in = (!empty($_POST["lives_well_in"])) ? $_POST["lives_well_in"] : NULL;  
  $temperament = (!empty($_POST["temperament"])) ? $_POST["temperament"] : NULL; 
  $sociability = (!empty($_POST["sociability"])) ? $_POST["sociability"] : NULL; 
  // $gallery = $_FILES["gallery"];

  $errors = false;

  // If pet name is empty
  if(empty($pet_name)) {
    $pet_name_warning = array();
    $pet_name_warning[] = 'Type the pet name';
    $errors = true;
  }
  // If pet description is empty
  if(empty($pet_description)) {
    $pet_description_warning = array();
    $pet_description_warning[] = 'Talk about the pet';
    $errors = true;
  }
  // If "lives well in" is empty (environments)
  if(empty($lives_well_in)) {
    $lives_well_in_warning = array();
    $lives_well_in_warning[] = 'Select some environments';
    $errors = true;
  }
  // If "temperament" is empty
  if(empty($temperament)) {
    $temperament_warning = array();
    $temperament_warning[] = 'Select options for temperament';
    $errors = true;
  }
  // If "sociability" is empty
  if(empty($sociability)) {
    $sociability_warning = array();
    $sociability_warning[] = 'Select options for sociability';
    $errors = true;
  }
  // If "species" is empty
  if(empty($species)) {
    $species_warning = array();
    $species_warning[] = 'Select an option';
    $errors = true;
  }
  // If "sex" is empty
  if(empty($sex)) {
    $sex_warning = array();
    $sex_warning[] = 'Select an option';
    $errors = true;
  }
  // If "size" is empty
  if(empty($size)) {
    $size_warning = array();
    $size_warning[] = 'Select an option';
    $errors = true;
  }
  // If "gallery" is empty
  /* if($gallery['size'][0] == 0) {
    $gallery_warning = array();
    $gallery_warning[] = 'Selecione ao menos uma imagem';
    $errors = true;
  } 
  // Proceeds with gallery/upload only if all other fields are OK
  else {
    if($errors == true) {
      $gallery_warning = array();
      $gallery_warning[] = 'Finalize todos os campos acima antes de selecionar imagens';
    }
    else {
      $accepted_file_formats = array('png', 'jpg', 'jpeg');
      $gallery_warning = array();      

      // UPLOAD
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
      require_once( ABSPATH . 'wp-admin/includes/media.php' );

      $all_photos = array();    
      
      foreach ($gallery['name'] as $key => $value) {
        if ($gallery['name'][$key]) {
          $file = array(
              'name' => $gallery['name'][$key],
              'type' => $gallery['type'][$key],
              'tmp_name' => $gallery['tmp_name'][$key],
              'error' => $gallery['error'][$key],
              'size' => $gallery['size'][$key]
          );

          $filename = $gallery['name'][$key];
          $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

          if (!in_array($file_extension, $accepted_file_formats)) {
              $errors = true;
              $validate_user_foto_validacao = true;
              // Format invalid
              $gallery_warning[] = 'O arquivo "'.$gallery['name'][$key].'" possui um formato inválido. Aceitamos apenas imagens: <b>jpg, jpeg, png</b>.';
          }
          else {

            $_FILES = array("upload_file" => $file);
            $attachment_id = media_handle_upload("upload_file", 0);

            if (is_wp_error($attachment_id)) {
                // There was an error uploading the image.                        
                $errors = true;
                $gallery_warning[] = 'Houve um erro com o arquivo: "'.$gallery['name'][$key].'". Tente novamente selecionando múltiplas <b>imagens</b>.';                        

            } else {
                // The image was uploaded successfully!
                $all_photos[$attachment_id] = wp_get_attachment_image_url($attachment_id); // ($attachment_id, 'custom_size');
                wp_update_post( array('ID' => $attachment_id, 'post_author' => get_current_user_id()) ); // Updates author for image
            }
          }            
        }
      } // End upload
    } // End else (all other fields are ok)
  } // End else (gallery not empty) */

  // only updates the pet if there are no errors
  if(!$errors) {
    wp_update_post( array( 'ID' => $_GET['id'], 'post_title' => $pet_name ) );
    update_post_meta($_GET['id'], 'animais_descricao', $pet_description);
    // update_post_meta($_GET['id'], 'animais_galeria', $all_photos);
    wp_set_post_terms( $_GET['id'], $species, 'especie'); // Specie
    wp_set_post_terms( $_GET['id'], $sex, 'sexo'); // Sex
    wp_set_post_terms( $_GET['id'], $size, 'tamanho'); // Size
    foreach($special_care as $term) { wp_set_post_terms( $_GET['id'], $term, 'cuidados', true); } // Special care
    foreach($lives_well_in as $term) { wp_set_post_terms( $_GET['id'], $term, 'ambiente', true); } // Lives well in (environment)
    foreach($temperament as $term) { wp_set_post_terms( $_GET['id'], $term, 'temperamento', true); } // Temperament
    foreach($sociability as $term) { wp_set_post_terms( $_GET['id'], $term, 'sociabilidade', true); } // Sociability
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
        <div id="success"><p>Pet "<?php echo $pet_name; ?>" updated successfully! <a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>">Click here</a> to view all your pets.</p></div>
        <?php } else { ?>

        <form class="form" action="" method="POST" enctype="multipart/form-data">
          <fieldset>
            <div class="row">
              <div class="col-md-3" id="left">
                <label for="user_Login">Pet name</label>
              </div>
              <div class="col-md-9">
                <input value="<?php if(!empty($pet_name)) { echo $pet_name; } ?>" name="pet_name" class="first-letter-capital required <?php if(!empty($pet_name_warning)) { echo 'invalid'; } ?>" type="text"/>
                <?php if(!empty($pet_name_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($pet_name_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Description</label>
              </div>
              <div class="col-md-9">
                <textarea name="pet_description" class="first-letter-capital required <?php if(!empty($pet_description_warning)) { echo 'invalid'; } ?>"><?php if(!empty($pet_description)) { echo $pet_description; } ?></textarea>
                <span id="desc">Talk about the pet.</span>
                <?php if(!empty($pet_description_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($pet_description_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>  
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label>Species</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $species_list = get_terms(
                        array(
                        'taxonomy'   => 'especie',
                        'hide_empty' => false,
                      )
                    );
                    if($species_list) {
                    foreach( $species_list as $item ) { ?>
                    <label>
                      <input type="radio" name="species" value="<?php echo $item->term_id; ?>" <?php if(!empty($species) && $species == $item->term_id ) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($species_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($species_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>  
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label>Sex</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $sex_list = get_terms(
                        array(
                        'taxonomy'   => 'sexo',
                        'hide_empty' => false,
                      )
                    );
                    if($sex_list) {
                    foreach( $sex_list as $item ) { ?>
                    <label>
                      <input type="radio" name="sex" value="<?php echo $item->term_id; ?>" <?php if(!empty($sex) && $sex == $item->term_id ) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($sex_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($sex_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>   
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label>Size</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $size_list = get_terms(
                        array(
                        'taxonomy'   => 'tamanho',
                        'hide_empty' => false,
                      )
                    );
                    if($size_list) {
                    foreach( $size_list as $item ) { ?>
                    <label>
                      <input type="radio" name="size" value="<?php echo $item->term_id; ?>" <?php if(!empty($size) && $size == $item->term_id ) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($size_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($size_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Veterinary care</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $special_care_list = get_terms(
                        array(
                        'taxonomy'   => 'cuidados',
                        'hide_empty' => false,
                      )
                    );
                    if($special_care_list) {
                    foreach( $special_care_list as $item ) {
                      // Check if options available are check for the current pet
                      $hasSlug = false;
                      if($special_care && !$_POST) {
                        foreach($special_care as $slug) {
                          if($item->term_id == $slug->term_id) { $hasSlug = true; }                       
                        }
                      }
                    ?>
                    <label>
                      <input type="checkbox" name="special_care[]" value="<?php echo $item->term_id; ?>" <?php if(isset($special_care) && $hasSlug) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>               
              </div>                    
            </div>  
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Lives well in</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $lives_well_in_list = get_terms(
                        array(
                        'taxonomy'   => 'ambiente',
                        'hide_empty' => false,
                      )
                    );
                    if($lives_well_in_list) {
                    foreach( $lives_well_in_list as $item ) {
                      // Check if options available are check for the current pet
                      $hasSlug = false;
                      if($lives_well_in && !$_POST) {
                        foreach($lives_well_in as $slug) {
                          if($item->term_id == $slug->term_id) { $hasSlug = true; }                       
                        }
                      }
                    ?>
                    <label>
                      <input type="checkbox" name="lives_well_in[]" value="<?php echo $item->term_id; ?>" <?php if(isset($lives_well_in) && $hasSlug) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($lives_well_in_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($lives_well_in_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>     
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Temperament</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $temperament_list = get_terms(
                        array(
                        'taxonomy'   => 'temperamento',
                        'hide_empty' => false,
                      )
                    );
                    if($temperament_list) {
                    foreach( $temperament_list as $item ) {
                      // Check if options available are check for the current pet
                      $hasSlug = false;
                      if($temperament && !$_POST) {
                        foreach($temperament as $slug) {
                          if($item->term_id == $slug->term_id) { $hasSlug = true; }                       
                        }
                      }
                    ?>
                    <label>
                      <input type="checkbox" name="temperament[]" value="<?php echo $item->term_id; ?>" <?php if(isset($temperament) && $hasSlug) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($temperament_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($temperament_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>  
            <div class="row checks">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Sociable with</label>
              </div>
              <div class="col-md-9">
                <div class="checkboxes">
                  <div class="all">
                    <?php
                    $sociability_list = get_terms(
                        array(
                        'taxonomy'   => 'sociabilidade',
                        'hide_empty' => false,
                      )
                    );
                    if($sociability_list) {
                    foreach( $sociability_list as $item ) {
                      // Check if options available are check for the current pet
                      $hasSlug = false;
                      if($sociability && !$_POST) {
                        foreach($sociability as $slug) {
                          if($item->term_id == $slug->term_id) { $hasSlug = true; }                       
                        }
                      }
                    ?>
                    <label>
                      <input type="checkbox" name="sociability[]" value="<?php echo $item->term_id; ?>" <?php if(isset($sociability) && $hasSlug) { echo 'checked'; } ?>> <?php echo $item->name; ?> 
                    </label>                    
                    <?php } } ?>                      
                  </div>
                </div>                
                <?php if(!empty($sociability_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($sociability_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>          
            <!--<div class="row">                   
              <div class="col-md-3" id="left">
                <label for="user_email">Fotos</label>
              </div>
              <div class="col-md-9">
                <input type="file" name="gallery[]" multiple="multiple" accept="image/png, image/jpeg">   
                <span id="desc">Selecione mais de uma imagem ao mesmo tempo</span>             
                <?php if(!empty($gallery_warning)) { ?>
                <p id="all">
                  <?php
                  foreach($gallery_warning as $message) {
                    echo '<span>'.$message.'</span>';
                  }
                  ?>
                </p>                          
                <?php } ?>
              </div>                    
            </div>-->
            <div class="row">                   
              <div class="col-md-3" id="left">
                <input type="hidden" name="register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
              </div>
              <div class="col-md-9">
                <input type="submit" value="Update pet"/>
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
    
<?php get_footer(); ?>