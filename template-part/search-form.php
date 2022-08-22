<?php
// Global vars
global $global_user_state, $global_user_city, $pageSearchPage;

// If city is a valid brazilian city, display custom CTA for SEO: cats and dogs for adoption in + city
if(slugToString(sanitize_title($global_user_city))) {
$city_state_URL = get_the_permalink($pageSearchPage) . slugToString(sanitize_title($global_user_city))['state-slug'] . '/' . sanitize_title($global_user_city);    
?>

<p id="city">Use the filter below or visit all the <a href="<?php echo $city_state_URL; ?>">cats and dogs for adoption in <?php echo $global_user_city; ?></a></p>

<?php } ?>

<form action="<?php the_permalink($pageSearchPage); ?>" method="GET">
  <div class="fields flow-root">
    <div class="division" id="left">
      <select name="species">
        <option value="">--- Any species ---</option>
        <?php
        ###### If page has custom query vars
        $species = (get_query_var('species_query') != 'any-species') ? get_query_var('species_query') : NULL;
        $size = (get_query_var('size_query') != 'any-size') ? get_query_var('size_query') : NULL;
        $species_tax = get_terms(
            array(
            'taxonomy'   => 'especie',
            'hide_empty' => false,
          )
        );
        if($species_tax) {
        foreach( $species_tax as $item ) { ?>
        <option value="<?php echo $item->slug; ?>" <?php if($item->slug == $species) { echo 'selected'; } ?>><?php echo $item->name; ?></option>
        <?php } } ?>
      </select>
      <select name="size">
        <option value="">--- Any size ---</option>
          <?php
            $size_tax = get_terms(
            array(
            'taxonomy'   => 'tamanho', // Size
            'hide_empty' => false,
          )
        );
        if($size_tax) {
        foreach( $size_tax as $item ) { ?>
        <option value="<?php echo $item->slug; ?>" <?php if($item->slug == $size) { echo 'selected'; } ?>><?php echo $item->name; ?></option>
        <?php } } ?>
      </select>
    </div>
    <div class="division" id="right">
      <select name="state" id="estado">
        <option value="">--- Any state ---</option>
      </select>
      <select name="city" id="cidade">
        <option value="">--- Any city ---</option>
      </select>
    </div>
  </div>
  <input type="submit" id="submit" value="Search">
</form>