
<div class="form">
	<p><div id='pMaj'>Mettez à jour les informations de votre compte.</div></p><br/>
	<div class="blocForm">
		<form method="post" action="bootstrap.php?action=updateAccount">
			<?=isset($erreurs) && in_array(\Entity\Account::NOM_INVALIDE, $erreurs) ? 'Veuillez saisir un nom.<br />' : ''?>
			<div class="champ">
			<label for="name">Nom : </label>
			<input type="text" name="name" value="<?php echo $account['name'] ?>">
			</div>
			<?=isset($erreurs) && in_array(\Entity\Account::PRENOM_INVALIDE, $erreurs) ? 'Veuillez saisir un prénom.<br />' : ''?>
			<div class="champ">
			<label for="pseudo">Pseudo : </label>
			<input type="text" name="pseudo" value="<?php echo $account['pseudo'] ?>">
			</div>

			<?=isset($erreurs) && in_array(\Entity\Account::ALIAS_INVALIDE, $erreurs) ? 'Veuillez saisir un nom d\'utilisateur.<br />' : ''?>
			<div class="champ">
			<label for="mail">Email : </label>
			<input type="text" name="mail" value="<?php echo $account['mail'] ?>">
			</div>

			<button type="submit" class="bouton">Mettre à jour</button>
		</form>
	</div>
</div>