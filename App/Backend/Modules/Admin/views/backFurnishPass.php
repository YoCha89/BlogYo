<p>Renouvellez votre mot de passe</p>
	<p>Votre mot de passe doit contenir au moins 8 caractères dont : une minuscule, une majuscule, un chiffe et un caractère spécial.</p><br/>
	<form method="post" action="bootstrap.php?app=backend&action=backFurnishPass">
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

		<input type="hidden" name="id" value="<?=nl2br(htmlspecialchars($id))?>">
		<button type="submit" class="btn btn-secondary">Mettre à jour mon mot de passe</button>
	</form>