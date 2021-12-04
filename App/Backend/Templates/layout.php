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
if ($this->app->user()->isAuthenticated() == true) {
  ?>
            <div class="userBloc">
              <div class="user">
                  <a href="bootstrap.php?action=seeAccount"><img src="images/logoUser.png" alt="logoUser" id="logoUser"/></a>
                  <p> <a href="bootstrap.php?action=seeAccount"><span id="userSelf"><?=$this->app->user()->getAttribute('pseudo')?></span></a></p>
              </div>
              <div class="userbutton">
              <div id="decButton">
                  <form method="post" action="bootstrap.php?action=disconnect">
                  <div class  = "but"><button type="submit" class="btn btn-secondary">Déconnexion</button></div>
                  <div class  = "butSmart"><button type="submit" class="btn btn-secondary">Déco</button></div>
                  </form>
              </div>
            <?php
}

if ($this->app->user()->isAuthenticated() == true && $this->app->user()->isAdmin() != 'isCo') {
  ?>
  <div id="ModButton">
    <form method="post" action="bootstrap.php?action=seeMyComments">
    <div class  = "but"><button type="submit" class="btn btn-secondary">Mes commentaires</button></div>
    <div class  = "butSmart"><button type="submit" class="btn btn-secondary">Mes Coms</button></div>
    </form>
  </div>
</div>
  <?php
}elseif ($this->app->user()->isAdmin() == 'isCo') {
  ?>
  <div id="ModButton">
    <form method="post" action="bootstrap.php?app=Backend&action=backModerateComment">
    <div class  = "but"><button type="submit" class="btn btn-secondary">Modération</button></div>
    <div class  = "butSmart"><button type="submit" class="btn btn-secondary">Mod</button></div>
    </form>
  </div>
</div>
  <?php
} ?>
        </div>
      </header>
<div class="dropSmart">  
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="bootstrap.php?action=index">BlogYo</a>
      </div>

      <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" style="">
        <ul class="nav navbar-nav">
          <li class="active"><a href="bootstrap.php?action=blogList">Articles <span class="sr-only">(current)</span></a></li>
          <li><a href="bootstrap.php?action=seeAccount">Mon compte</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="navPc">  
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="bootstrap.php?action=index">BlogYo</a>
      </div>

      <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" style="">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="bootstrap.php?action=blogList">Articles</a></li>
              <li><a href="bootstrap.php?action=seeAccount">Mon compte</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
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

<div class="backFoot">
      <footer>
        <p>BlogYo : le bloge de Yoann Chardel</p>
      </footer>
</div>
  </body>
</html>