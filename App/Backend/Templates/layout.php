<!DOCTYPE html>
<html>
  <head>
    <title>
      <?=isset($title) ? $title : 'BlogYo'?>
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sandstone.css" type="text/css" />
    <link rel="icon" href="images/Favico.ico" />
  </head>

 <body>
      <header>

           
             <div class="logo">
              <a href="bootstrap.php?action=index"><img src="images/Icone.png" alt="LogoGBAF" id="LogoHeader"/></a>
              <div class='logoTitle'>BlogYo !</div>
            </div>
            <?php
//affichage dynamique du bloc compte utilisateur en cas de connexion
if ($_SESSION['auth'] == true) {
  ?>
            <div class="userBloc">
              <div class="user">
                  <a href="bootstrap.php?action=seeAccount"><img src="images/logoUser.png" alt="logoUser" id="logoUser"/></a>
                  <p> <a href="bootstrap.php?action=seeAccount"><span id="userSelf"><?=$_SESSION['pseudo']?></span></a></p>
              </div>
              <div class="userbutton">
              <div id="decButton">
                  <form method="post" action="bootstrap.php?action=disconnect">
                  <button type="submit" class="btn btn-secondary">Déconnexion</button>
                  </form>
              </div>
            <?php
}

if ($_SESSION['admin'] == 'isCo') {
  ?>
  <div id="ModButton">
    <form method="post" action="bootstrap.php?app=Backend&action=backModerateComment">
    <button type="submit" id="btn btn-secondary">Modération</button>
    </form>
  </div>
</div>
  <?php
} ?>
        </div>
      </header>
<!-- FIN DU HEADER LAYOUT -->
     <div class="backMain"> 
      <section id="main" class="container">
        
      
            <?php if ($user->hasFlashInfo()) {
              echo '<p><div class="alert alert-dismissible alert-primary">', $user->getFlashInfo(), '</div></p>';
            }elseif($user->hasFlashSuccess()){
              echo '<p><div class="alert alert-dismissible alert-success">', $user->getFlashSuccess(), '</div></p>';
            }elseif($user->hasFlashError()){
              echo '<p><div class="alert alert-dismissible alert-danger">', $user->getFlashError(), '</div></p>';
  } ?>

            <?= $content ?>
      </section>
    </div>    
    

<!-- DEBUT DU FOOTER LAYOUT -->
<div class="backFoot">
      <footer>

      </footer>
</div>
  </body>
</html>