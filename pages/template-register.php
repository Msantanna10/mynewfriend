<?php

/* Template Name: Sign Up */

// Está logado, exibe aviso

$success = false;
$user_login_warning = false;

if(is_user_logged_in()) {

  $url = get_author_posts_url( get_current_user_id() );
  wp_safe_redirect($url);

}

// Não está logado, exibe form
else {
  
  // Se formulário foi enviado - validação
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
  
    // this is required for username checks
    // https://pippinsplugins.com/creating-custom-front-end-registration-and-login-forms/
  
    $errors = false;

        if(username_exists($user_login)) {
          // Username already registered
          $user_login_warning = array();
          $user_login_warning[] = 'Este apelido já existe';
          $errors = true;
          $validate_user_login = true;
        }
        if(!empty($user_login)) {
          if(strlen($user_login) <= 3) {
              // invalid username
              $user_login_warning[] = 'Digite um apelido maior';
              $errors = true;
              $validate_user_login = true;
          }
          if(!validate_username($user_login)) {
            // invalid username
            $user_login_warning[] = 'Utilize um apelido sem espaços ou acentos';
            $errors = true;
            $validate_user_login = true;
          }
        }
        else {
            $user_login_warning[] =  'Digite um apelido';
            $errors = true;
            $validate_user_login = true;
        }            
        if($user_first == '') {
          // empty name
          $user_first_warning = array();
          $user_first_warning[] = 'Digite seu primeiro nome';
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
          $user_email_warning[] = 'E-mail inválido';
          $errors = true;
          $validate_user_email = true;
        }
        if(email_exists($user_email)) {
          //Email address already registered
          $user_email_warning = array();
          $user_email_warning[] = 'Este e-mail já existe';
          $errors = true;
          $validate_user_email = true;
        }
        if($user_email_confirm == '') {
          // empty name
          $user_email_confirm_warning = array();
          $user_email_confirm_warning[] = 'Digite a confirmação de e-mail';
          $errors = true;
          $validate_user_email_confirm = true;
        }
        if($user_email != $user_email_confirm) {
          // empty name
          $user_email_confirm_warning = array();
          $user_email_confirm_warning[] = 'Os e-mails não combinam';
          $errors = true;
          // $validate_user_email = true;
          $validate_user_email_confirm = true;
        }
        if($user_phone == '') {
          // passwords do not match
          $user_phone_warning = array();
          $user_phone_warning[] = 'Digite um telefone';
          $errors = true;
          $validate_user_phone = true;
        }
        if($user_whats == '') {
          // é whatsapp?
          $user_whats_warning = array();
          $user_whats_warning[] = 'Informe se é WhatsApp ou não';
          $errors = true;
          $validate_user_whats = true;
        }
        if(empty($state)) {
          $state_warning = array();
          $state_warning[] = 'Escolha um estado';
          $errors = true;
          $validate_estado = true;
        }
        if(empty($city)) {
          $city_warning = array();
          $city_warning[] = 'Escolha uma cidade';
          $errors = true;
          $validate_cidade = true;
        }
        if($user_pass == '') {
          // passwords do not match
          $user_pass_warning = array();
          $user_pass_warning[] = 'Digite uma senha';
          $errors = true;
          $validate_user_pass = true;
        }                                
        if($user_pass != $pass_confirm) {
          // passwords do not match
          $pass_confirm_warning = array();
          $pass_confirm_warning[] = 'As senhas não combinam';
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

        // Envia email
        $headers = array(
          'Content-Type: text/html; charset=UTF-8',
          'Meu Novo Amigo <contato@meunovoamigo.com.br>'
        );
        $html = 'É um prazer ter você conosco! Estamos dispostos a te ajudar a adotar seus animais, juntos faremos a diferença!
        <br><br>
        Você pode efetuar seu acesso utilizando seu <b>e-mail</b> ou seu usuário <b>'.$user_login.'</b> através deste link: '.get_site_url().'/entrar
        <br><br>
        Utilize a senha escolhida por você e comece a divulgar seus bichinhos <3
        <br><br>
        Lembre-se de compartilhar seu link em suas redes sociais para que as pessoas possam ver todos seus pets cadastrados e entrar em contato com você!
        <br><br>
        <b>Link do seu perfil:</b> '.get_author_posts_url($new_user_id).'
        <br><br>
        Conte com a gente!
        <br><br>
        <b>'.get_bloginfo('name').'</b>';

        wp_mail($user_email, "Cadastro realizado com sucesso! ❤️", $html, $headers);

      }
  
    }
  
} // Fim da validação do formulário

get_header();

global $pageNewPet;

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
        <div id="success"><p>Usuário criado com sucesso! <a href="<?php the_permalink($pageNewPet); ?>" target="_blank">Clique aqui</a> para cadastrar seu primeiro bichinho</p></div>
        <?php } else { ?>

        <p class="center" style="max-width: 810px;margin: 0 auto;">Crie sua conta para cadastrar, remover, editar e gerenciar seus bichinhos! Após a criação de sua conta pessoal, você terá acesso ao seu painel para adicionar seus pets em adoção. Cada pet cadastrado terá um link com todas as informações necessárias para compartilhá-lo em suas redes sociais, onde haverá as fotos do animal, descrição, seu telefone de contato, etc.
        <br><br>
        <b>Primeiro passo: </b>Preencha o formulário abaixo e crie sua conta, logo após isso, será feito um redirecionamento para que cadastre seu primeiro animalzinho em adoção para te ajudarmos a divulgá-lo em sua região 🥰
        </p>
        <br><br>

        <form class="form" action="" method="POST">
          <fieldset>
            <div class="row">
                <div class="col-md-3" id="left">
                  <label for="user_Login">Apelido</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php echo $user_login; ?>" name="user_login" id="user_login" class="nospace first-letter-lowercase required <?php if($validate_user_login) { echo 'invalid'; } ?>" type="text"/>
                  <span id="desc">Seu apelido vai se transformar no endereço de sua página aqui no <?php bloginfo('name'); ?>.
                  <br>
                  Assim: <?php echo get_site_url(); ?>/perfil/apelido
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
                  <label for="user_email">E-mail</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php if(!empty($user_email)) { echo $user_email; } ?>" name="user_email" id="user_email" class="nospace required <?php if($validate_user_email) { echo 'invalid'; } ?>" type="email"/>
                  <span id="desc">Os adotantes interessados poderão te contactar por este e-mail.</span>
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
                  <label for="user_email_confirm">E-mail (de novo)</label>
                </div>
                <div class="col-md-9">
                  <input value="<?php if(!empty($user_email_confirm)) { echo $user_email_confirm; } ?>" name="user_email_confirm" id="user_email_confirm" class="nospace required <?php if($validate_user_email_confirm) { echo 'invalid'; } ?>" type="email"/>
                  <span id="desc">A gente pede duas vezes pra ter certeza de que você não vai errar!</span>
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
                    <label for="user_first">Nome</label>
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
                    <label for="user_last">Sobrenome</label>
                </div>
                <div class="col-md-9">
                    <input value="<?php if(!empty($user_last)) { echo $user_last; } ?>" name="user_last" class="first-letter-capital" id="user_last" maxlength="15" type="text"/>
                </div>                    
            </div>
            <div class="row">                   
                <div class="col-md-3" id="left">
                    <label for="user_phone">WhatsApp ou Telefone</label>
                </div>
                <div class="col-md-9">
                  <input placeholder="( &nbsp; ) ____-____" value="<?php if(!empty($user_phone)) { echo $user_phone; } ?>" name="user_phone" class="telefone <?php if($validate_user_phone) { echo 'invalid'; } ?>" id="user_phone" type="tel"/>
                  <span id="desc">Os adotantes interessados poderão te contactar por este número.</span>
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
                  <label for="user_whats">É WhatsApp?</label>
              </div>
              <div class="col-md-9">
                <select id="user_whats" name="user_whats" class="<?php if($validate_user_whats) { echo 'invalid'; } ?>">
                  <option value="">--- Selecione uma opção ---</option>
                  <option value="sim" <?php if($user_whats == 'sim') { echo 'selected'; } ?>>Sim, é WhatsApp</option>
                  <option value="nao" <?php if($user_whats == 'nao') { echo 'selected'; } ?>>Não, não é WhatsApp</option>
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
                  <label for="user_private">Telefone privado</label>
              </div>
              <div class="col-md-9">
                <label>
                  <input value="on" name="user_private" class="privado" id="user_private" type="checkbox" <?php if(!empty($user_private)) { echo 'checked'; } ?>/>
                  Ocultar telefone?
                  <span id="desc">Ao marcar essa opção, apenas a nossa equipe poderá ver seu telefone. Mas essa opção reduz bastante as chances de um adotante entrar em contato.</span>
                </label>
              </div>                    
            </div>
            <div class="row">                   
              <div class="col-md-3" id="left">
                  <label for="state">Estado</label>
              </div>
              <div class="col-md-9">
                <select id="state" name="state" class="<?php if(!empty($validate_estado)) { echo 'invalid'; } ?>">
                  <option value="">--- Selecione um estado ---</option>
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
                <label for="city">Cidade</label>
              </div>
              <div class="col-md-9">
                <select id="city" name="city" class="<?php if(!empty($validate_cidade)) { echo 'invalid'; } ?>">
                  <option value="">--- Selecione uma cidade ---</option>
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
                <label for="password">Senha</label>
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
                <label for="password_again">Confirmação da senha</label>
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
                <input type="submit" value="Criar conta"/>
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