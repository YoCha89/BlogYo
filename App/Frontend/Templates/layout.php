<!DOCTYPE html>
<html>
  <head>
    <title>
      <?=isset($title) ? $title : 'BlogYo'?>
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!--  <link rel="stylesheet" href="css/mode.css" type="text/css" />
    <link rel="icon" href="images/FaviconGBAF.ico" /> -->
  </head>

  <body>

      <header>
         <div id="tete">
          <!-- AFFICHAGE thumb Account -->
<!--             <div id="logo">?> -->
              <a href="bootstrap.php?action=index"><img src="images/LogoGBAF.png" alt="LogoGBAF" id="LogoHeader"/></a>
            </div>
            <?php
//affichage dynamique du bloc compte utilisateur en cas de connexion
if ($_SESSION['auth'] == true) {
	?>
            <div id="userBloc">
              <div id="user">
                  <a href="bootstrap.php?action=seeAccount"><img src="images/logoUser.png" alt="logoUser" id="logoUser"/></a>
                  <p> <a href="bootstrap.php?action=seeAccount"><span id="userSelf"><?=$_SESSION['pseudo']?></span></a></p>
              </div>
              <div id="decButton">
                  <form method="post" action="bootstrap.php?action=disconnect">
                  <button type="submit" id="boutonDeco">Déconnexion</button>
                  </form>
              </div>
            <?php
}?>

      </header>
<!-- FIN DU HEADER LAYOUT -->
      <section id="main">
          <?php if ($user->hasFlash()) {
	echo '<p><div class="flash">', $user->getFlash(), '</div></p>';
}
//Affichage des feedbacks utilisateurs pour confirmer la réussite d'une requête ou lui permettre de corriger ses erreurs ?>

          <?=$content?>
        </section>

<!-- DEBUT DU FOOTER LAYOUT -->
      <footer>

      </footer>

  </body>
</html>


<!-- © 2021 GitHub, Inc.
Terms
Privacy
Security
Status
Docs
Contact GitHub
Pricing
API
Training
Blog
About -->
