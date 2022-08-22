</div>

<footer>

    <?php
    wp_footer();
    global $pageSearchPage, $pageProducts, $global_user_state, $global_user_city, $pageResponsibleAdoption, $pageAbout, $pageContact;
    ?>

    <div class="footer space">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h3>Adopt a new friend</h3>
            <br>
            <ul>
              <?php
              // If city is a valid brazilian city, display custom link for SEO CTA: Adoption in + City
              if(slugToString(sanitize_title($global_user_city))) {

              // Builds friendly SEO URL for the city: website.com/state/city
              $city_state_URL = get_the_permalink($pageSearchPage) . $global_user_state . '/' . sanitize_title($global_user_city);    
              ?>
              <li><a href="<?php echo $city_state_URL; ?>">Adoption in <?php echo $global_user_city; ?></a></li>
              <?php } ?>              
              <li><a href="<?php the_permalink($pageSearchPage); ?>any-state/any-city/cachorro/any-size/">Adoption of dogs</a></li>
              <li><a href="<?php the_permalink($pageSearchPage); ?>any-state/any-city/gato/any-size/">Adoption of cats</a></li>
              <li><a href="<?php the_permalink($pageResponsibleAdoption); ?>">Responsible adoption</a></li>
              <li><a href="<?php the_permalink($pageProducts); ?>">Special cares</a></li>
            </ul>
          </div>
          <div class="col-md-4" id="contato">
            <h3><?php bloginfo('name'); ?></h3>
            <br>
            <ul>
              <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
              <li><a href="<?php the_permalink($pageAbout); ?>">About</a></li>
              <li><a href="<?php the_permalink($pageContact); ?>">Contact us</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h3>Get in touch</h3>
            <br>
            <a id="email" href="<?php the_permalink($pageContact); ?>">contato@meunovoamigo.com</a>
            <a id="letter" href="<?php the_permalink($pageContact); ?>"><i class="far fa-envelope"></i></a>
          </div>
        </div>        
      </div>
    </div>
    <div class="copy">
      <div class="container center">
        <p>© <?php echo date('Y') . ' '; echo bloginfo('name'); ?>. All rights reserved</p>
      </div>
    </div>

    <?php if(is_page($pageSearchPage) || is_home()) { ?>
    <script>
    /* On search form submit */
    $(".busca form").submit(function(){

      /* Custom slugify function for JS */
      var slug = function(str) {
        str = str.replace(/^\s+|\s+$/g, ''); /* trim */
        str = str.toLowerCase();

        /* Remove accents, swap ñ for n, etc */
        var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
          str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') /* remove invalid chars */
        .replace(/\s+/g, '-') /* collapse whitespace and replace by */
        .replace(/-+/g, '-'); /* collapse dashes */

        return str;
      };

      var species = $('.busca form select[name="species"]').val();
      var size = $('.busca form select[name="size"]').val();
      var state = slug($('.busca form select[name="state"]').val());
      var city = slug($('.busca form select[name="city"]').val());

      /* Creates custom URL for SEO */
      if(species === 'undefined' || species == '') {
        species = 'any-species';
      }
      if(size === 'undefined' || size == '') {
        size = 'any-size';
      }
      if(state === 'undefined' || state == '') {
        state = 'any-state';
      }
      if(city === 'undefined' || city == '') {
        city = 'any-city';
      }

      var url = '<?php echo get_the_permalink($pageSearchPage); ?>' + state + '/' + city + '/' + species + '/' + size;

      $('.loadingPage').fadeIn(2000);
      window.location.href = url; /* Redirects */

      return false; /* Prevents default submit */

    });
    </script>
    <?php } ?>

    <?php
    $estado_query = (!empty(get_query_var('state_query')) && get_query_var('state_query') != 'any-state') ? slugToString(get_query_var('state_query'))['state-with-accents'] : NULL;
    $cidade_query = (!empty(get_query_var('city_query')) && get_query_var('city_query') != 'any-city') ? slugToString(get_query_var('city_query'))['city-with-accents'] : NULL;
    ?>
    <script type="text/javascript"> 
    $(document).ready(function () {    
      $.getJSON('<?php bloginfo('template_url'); ?>/states_cities.json', function(data) {

        var items = [];
        var options = ''; /* Starts as empty */

        /* Populates states inside the selector */
        $.each(data, function (key, val) {
          options += '<option value="' + val.name + '">' + val.name + '</option>';
        });         
        $('select[name="state"]').append(options);
        
        /* On state change, get its cities */
        $('select[name="state"]').change(function () {        
        
          var cities_list = ''; /* Starts as empty */
          var selected_state = ''; /* Starts as empty */
          
          /* Get selected state */
          $('select[name="state"] option:selected').each(function () {
            selected_state += $(this).text(); /* Grab its name */
          });
          
          /* Find its cities in the JSON file */
          $.each(data, function (key, val) {              
            if(val.name == selected_state) {             
              $.each(val.cities, function (key_city, val_city) {
                cities_list += '<option value="' + val_city + '">' + val_city + '</option>';
              });             
            }
          });

          /* Populates cities */
          $('select[name="city"]').find('option:not(:first)').remove(); /* Removes all (but the first one) */
          $('select[name="city"]').append(cities_list); /* Adds new cities based on the new selected state */

        }).change();            
      
      });
    });      
    </script>

    <?php if(is_page($pageSearchPage)) { ?>
    <script>
    // Sets values for states and cities
    setTimeout(() => {
      $('select[name="state"]').val('<?php echo $estado_query; ?>').change();
      $('select[name="city"]').val('<?php echo $cidade_query; ?>');
    }, 500); 
    </script>
    <?php } ?>

  </footer>
  </body>
</html>