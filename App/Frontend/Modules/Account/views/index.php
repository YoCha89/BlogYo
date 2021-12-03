<div id="principal">

	<div class="acceuilHead">
		<h1>Bienvenu sur BlogYo ! </h1><br/>
		<img src="images/IconeOriginal.png" alt="logo" id="logoHeadAcc"/><br/>
		<h2><span id="txtBandeauAccueil">Vous venez d'arriver sur Le blog de <a href="../..\..\..\..\web\CV_YChardel_2021.pdf">Yoann Chardel</a>, développeur passioné à l'écoute de vos besoins !</h2><br/>
	</div>

	<hr>

	<div class="form">
		<div id="option1">
			<form method="post" action="bootstrap.php?action=index">
				<div class="champ">
					<label for="pseudo">Pseudo :</label>
					<input type="text" name="pseudo"><br/>
				</div>
				<div class="champ">
					<label for="pass">Mot de passe :</label>
					<input type="password" name="pass">
				</div>
					<br/><button type="submit" class="btn btn-secondary">Connexion</button>
			</form>

			<div id="separeVert"></div>
			<hr id="separeHori">

			<form method="post" action="bootstrap.php?action=blogList"><!--Bloc de connexion-->
				<button type="submit" class="btn btn-secondary">Continuer hors connexion</button>
			</form>
		</div>
	</div>


	<div class="blocForm">
		<div id="option2">
			<div id="blocOubli">
				<p>En cas d'oublie, entrez votre pseudo avant de valider</p><br/>
				<form method="post" action="bootstrap.php?action=askPass">
					<div class="champ">
						<label for="pseudo">Pseudo :</label><br/>
						<input type="text" name="pseudo">
					</div>
					<br/><button type="submit" class="btn btn-dark">Mot de passe oublié</button>
				</form>
			</div>

			<div id="separeVert"></div>
			<hr id="separeHori">


			<div id="blocCrea"><!--Bloc de création de compte-->
				<p>Vous n'avez pas encore de compte ?</p><br/>
				<form method="post" action="bootstrap.php?action=createAccount ">
					<br/><button type="submit" class="btn btn-secondary">Créer mon compte</button>
				</form>
			</div>
		</div>
	</div>

	<hr>

	<form method="post" action="bootstrap.php?action=contactAdmin">
		
		<?php
		if ($_SESSION['auth'] != true) {
		  ?>
		  	<label for="content">Votre email :</label>
			<input type="text" name="email"><br/>
		 <?php
		} ?>
		
	<label for="title">Titre :</label>
	<input type="text" name="title"><br/>


	<label for="content">Votre message :</label>
	<textarea name="body" class="form-control"></textarea><br/>

	<button type="submit" class="btn btn-secondary">Contacter l'administrateur</button>
</form>
</div>


