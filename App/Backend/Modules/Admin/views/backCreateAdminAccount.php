<p>Créez votre compte !</p>

<div class="form">
	<div class="blocForm">
		

<?php if ($this->app->user()->isAdmin() == 'isCo') { ?>
	<P>Veuillez renseigner le pseudo et l'adresse email du nouvel administrateur</P><br/>
		<?=isset($erreurs) && in_array(\Entity\Account::PRENOM_INVALIDE, $erreurs) ? 'Veuillez saisir un prénom.<br />' : ''?>
	<form method="post" action="bootstrap.php?app=backend&action=backCreateAdminAccount">
		<div class="champ">
			<label for="pseudo">Pseudo :</label>
			<input type="text" name="pseudo"><br/>
		</div>

		<?=isset($erreurs) && in_array(\Entity\Account::ALIAS_INVALIDE, $erreurs) ? 'Veuillez saisir un nom d\'utilisateur.<br />' : ''?>
		<div class="champ">
			<label for="mail">Email :</label>
			<input type="text" name="email"><br/>
		</div>

			<input type="hidden" name="step" value="step1">
		<button type="submit" class="btn btn-secondary">Créer</button>
	</form>
<?php } ?>

<?php if ($this->app->user()->isAdmin() == 'toConf') { ?>
	<p>Votre mot de passe doit contenir au moins 8 caractères dont : une minuscule, une majuscule, un chiffe et un caractère spécial.</p><br/>
	<form method="post" action="bootstrap.php?app=backend&action=backCreateAdminAccount">
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

		<input type="hidden" name="step" value="step2">
		<button type="submit" class="btn btn-secondary">Finaliser mon compte</button>
	</form>
<?php } ?>

</div>