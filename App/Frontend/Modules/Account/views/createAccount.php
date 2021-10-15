<p>Créez votre compte !</p>

<div class="form">
	<div class="blocForm">
		<form method="post" action="bootstrap.php?action=executeCreateAccount">
			<?=isset($erreurs) && in_array(\Entity\Account::NOM_INVALIDE, $erreurs) ? 'Veuillez saisir un nom.<br />' : ''?>
			<div class="champ">
				<label for="name">Nom :</label>
				<input type="text" name="name"><br/>
			</div>
			<?=isset($erreurs) && in_array(\Entity\Account::PRENOM_INVALIDE, $erreurs) ? 'Veuillez saisir un prénom.<br />' : ''?>
			<div class="champ">
				<label for="pseudo">Pseudo :</label>
				<input type="text" name="pseudo"><br/>
			</div>

			<?=isset($erreurs) && in_array(\Entity\Account::ALIAS_INVALIDE, $erreurs) ? 'Veuillez saisir un nom d\'utilisateur.<br />' : ''?>
			<div class="champ">
				<label for="mail">Email :</label>
				<input type="text" name="mail"><br/>
			</div>

			<hr>

			<p>Votre mot de passe doit contenir au moins 8 caractères dont : une minuscule, une majuscule, un chiffe et un caractère spécial.</p><br/>

			<?=isset($erreurs) && in_array(\Entity\Account::MOT_DE_PASSE_INVALIDE, $erreurs) ? 'Veuillez saisir un autre mot de passe.<br />' : ''?>
			<div class="champ">
				<label for="pass">Mot de passe :</label>
				<input type="password" name="pass"><br/>
			</div>
			<?=isset($erreurs) && in_array(\Entity\Account::MOT_DE_PASSE_INVALIDE, $erreurs) ? 'Veuillez saisir un autre mot de passe.<br />' : ''?>
			<div class="champ">
				<label for="confPass">Confirmer le mot de passe :</label>
				<input type="password" name="confPass"><br/>
			</div>

			<hr>

			<p>Si vous perdez votre mot de passe, vous aurez besoin de votre nom d'utilisateur et de votre réponse secrète pour le récupérer. Assurez-vous de les conserver. La réponse prend en compte les espaces en fin de chaine.</p><br/>

			<?=isset($erreurs) && in_array(\Entity\Account::QUESTION_INVALIDE, $erreurs) ? 'Veuillez saisir votre question secrète à nouveau (et si besoin, la réponse qui concorde).<br />' : ''?>
			<div class="champ">
				<label for="secretQ">Saisissez votre question secrète :</label>
				<input type="text" name="secretQ"><br/>
			</div>
			<?=isset($erreurs) && in_array(\Entity\Account::REPONSE_INVALIDE, $erreurs) ? 'Veuillez saisir votre réponse secrète à nouveau.<br />' : ''?>
			<div class="champ">
				<label for="secretA">Saisissez votre réponse secrète :</label>
				<input type="text" name="secretA"><br/>
			</div>

			<button type="submit" class="bouton">Créer</button>
		</form>
</div>