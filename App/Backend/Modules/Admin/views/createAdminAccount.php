<p>Créez votre compte !</p>

<div class="form">
	<div class="blocForm">
		<form method="post" action="bootstrap.php?action=createAdminAccount">

		<?php if (isset($key2)) {

	echo 'tocomplete';?>

<?php}?>
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

		<?php if (isset($key2)) {

	echo 'tocomplete';?>

<?php}?>

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

			<button type="submit" class="bouton">Créer</button>
		</form>
</div>