<div id="principal">
	<div id="bandeauAccueil"><p><span id="txtBandeauAccueil">Bienvenu sur BlogYo !</span></p></div>

	<div class="form">
		<div id="option1">
			<form method="post" action="bootstrap.php?action=executeIndex">
				<div class="champ">
					<label for="pseudo">Pseudo :</label>
					<input type="text" name="pseudo"><br/>
				</div>
				<div class="champ">
					<label for="pass">Mot de passe :</label>
					<input type="password" name="pass">
				</div>
					<br/><button type="submit" class="bouton">Connexion</button>
			</form>

			<div id="separeVert"></div>
			<hr id="separeHori">

			<form method="post" action="bootstrap.php?action=seeBlog"><!--Bloc de connexion-->
				<button type="submit" class="bouton">Continuer hors connexion</button>
			</form>
		</div>
	</div>


	<div class="blocForm">
		<div id="option2">
			<div id="blocOubli">
				<p>En cas d'oublie, entrez votre pseudo avant de valider</p><br/>
				<form method="post" action="bootstrap.php?action=executeAskPass ">
					<div class="champ">
						<label for="pseudo">Pseudo :</label><br/>
						<input type="text" name="pseudo">
					</div>
					<br/><button type="submit" class="boutonOp2">Mot de passe oublié</button>
				</form>
			</div>

			<div id="separeVert"></div>
			<hr id="separeHori">


			<div id="blocCrea"><!--Bloc de création de compte-->
				<p>Vous n'avez pas encore de compte ?</p><br/>
				<p>Créez votre compte dès maintenant !</p><br/>
				<form method="post" action="bootstrap.php?action=executeCreateAccount ">
					<br/><button type="submit" class="boutonOp2">Créer mon compte</button>
				</form>
			</div>
		</div>
	</div>
</div>


