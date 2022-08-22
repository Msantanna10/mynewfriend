<?php
################### Member fields
add_action( 'cmb2_admin_init', 'custom_user_fields' );
function custom_user_fields() {

  $cmb_demo = new_cmb2_box( array(
    'id'            => 'doador_infos',
    'title'         => 'Important information',
    'object_types'  => array( 'user' ), // Post type
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Phone',
    // 'desc'       => '(Opcional)',
    'id'      => 'doador_telefone',
    'type' => 'text',
    'classes' => 'telefone',
    'attributes' => array(
      'type' => 'tel',
      'required' => 'required'
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Is it WhatsApp?',
    // 'desc'       => '(Opcional)',
    'id'      => 'doador_whats',
    'type' => 'select',
    'options' => array(
      'sim' => 'Yes, it\'s WhatsApp',
      'nao' => 'No, it\'s not WhatsApp'
    ),
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'Private phone?',
    'desc'       => 'Only we will see your phone. Remembering that checking this option greatly reduces the chances of people getting in touch for adoption since only contact by email through the form will be available.',
    'id'      => 'doador_privado',
    'type' => 'checkbox',
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'State',
    // 'desc'       => '(Opcional)',
    'id'      => 'doador_estado',
    'type' => 'select',
  ) );

  $cmb_demo->add_field( array(
    'name'       => 'City',
    // 'desc'       => '(Opcional)',
    'id'      => 'doador_cidade',
    'type' => 'select',
  ) );

}

################### REMOVE FIELDS
if(is_admin()){
  remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
}
// Remove fields from Admin profile page
if ( ! function_exists( 'cor_remove_personal_options' ) ) {
  function cor_remove_personal_options( $field ) {

      $field = preg_replace('#<tr class="user-display-name-wrap(.*?)</tr>#s', '', $field, 1);
      // $field = preg_replace('#<tr class="user-nickname-wrap(.*?)</tr>#s', '', $field, 1);
      $field = preg_replace('#<tr class="user-url-wrap(.*?)</tr>#s', '', $field, 1);
      // $field = preg_replace('#<tr class="user-description-wrap(.*?)</tr>#s', '', $field, 1);
      // $field = preg_replace('#<tr class="user-profile-picture(.*?)</tr>#s', '', $field, 1);
      $field = preg_replace('#<tr class="show-admin-bar(.*?)</tr>#s', '', $field, 1);
      $field = preg_replace('#<tr class="user-language-wrap(.*?)</tr>#s', '', $field, 1);
      $field = preg_replace( '#<h2>Opções pessoais</h2>.+?/table>#s', '', $field, 1 ); // Remove título
      $field = preg_replace( '#<h2>Sobre você</h2>.+?/table>#s', '', $field, 1 ); // Remove título
      return $field;

  }

  function cor_profile_subject_start() {
      if ( ! current_user_can('manage_options') ) {
          ob_start( 'cor_remove_personal_options' );
      }
  }

  function cor_profile_subject_end() {
      if ( ! current_user_can('manage_options') ) {
          ob_end_flush();
      }
  }
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );

##################### Mask for phone number
add_action('admin_footer', function() { ?>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.mask.js"></script>
<script>
  var SPMaskBehavior = function (val) {
  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
      },clearIfNotMatch: true
  };

  // Adiciona a máscara ao telefone do contato e formulário do checkout
  jQuery(document).ready(function(){
  jQuery('#doador_telefone').mask(SPMaskBehavior, spOptions);
});
</script>
  
<script>
// #################### Json for states and cities
jQuery(document).ready(function () {    
jQuery.getJSON('<?php bloginfo('template_url'); ?>/states_cities.json', function(data) {

  var items = [];
  var options = ''; // Starts as empty

  // Populates states inside the selector
  jQuery.each(data, function (key, val) {
    options += '<option value="' + val.name + '">' + val.name + '</option>';
  });         
  jQuery('select[name="doador_estado"]').append(options);
  
  // On state change, get its cities
  jQuery('select[name="doador_estado"]').change(function () {        
  
    var cities_list = ''; // Starts as empty
    var selected_state = ''; // Starts as empty
    
    // Get selected state
    jQuery('select[name="doador_estado"] option:selected').each(function () {
      selected_state += jQuery(this).text(); // Grab its name
    });
    
    // Find its cities in the JSON file
    jQuery.each(data, function (key, val) {              
      if(val.name == selected_state) {             
        jQuery.each(val.cities, function (key_city, val_city) {
          cities_list += '<option value="' + val_city + '">' + val_city + '</option>';
        });             
      }
    });

    // Populates cities
    jQuery('select[name="doador_cidade"]').find('option').remove(); // Removes all (but the first one)
    jQuery('select[name="doador_cidade"]').append(cities_list); // Adds new cities based on the new selected state

  }).change();    

  // KEEP SELECTED
  var user_state = '<?php
  if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
    $current_user_id = get_current_user_id();
  }
  elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) { 
    $current_user_id = $_GET['user_id'];
  }
  // Set user state
  echo get_user_meta( $current_user_id, 'doador_estado', true );
  ?>';

  var user_city = '<?php
  if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
    $current_user_id = get_current_user_id();
  }
  elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) { 
    $current_user_id = $_GET['user_id'];
  }
  // Set user state
  echo get_user_meta( $current_user_id, 'doador_cidade', true );
  ?>';

  jQuery('select[name="doador_estado"]').val(user_state).trigger('change'); // Set state
  jQuery('select[name="doador_cidade"]').val(user_city); // Set city 

});
}); 
</script>
<?php
});
?>