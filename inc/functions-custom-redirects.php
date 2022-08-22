<?php
################### If 404, tag or category terms
add_action('template_redirect','redirect_404_tag_cat');
function redirect_404_tag_cat() {
  if(is_404() || is_tax() || is_category()) {
    wp_redirect(home_url());
  }
}
?>