<div class="form">
	<p><div id='pMaj'>Mettez à jour les informations de votre compte.</div></p><br/>
	<div class="blocForm">
		<form method="post" action="bootstrap.php?app=backend&action=backModifyAdminAccount">
			<?=isset($erreurs) && in_array(\Entity\Account::PRENOM_INVALIDE, $erreurs) ? 'Veuillez saisir un prénom.<br />' : ''?>
			<div class="champ">
			<label for="pseudo">Pseudo : </label>
			<input type="text" name="pseudo" value="<?= $admin['pseudo'] ?>">
			</div>

			<?=isset($erreurs) && in_array(\Entity\Account::ALIAS_INVALIDE, $erreurs) ? 'Veuillez saisir un nom d\'utilisateur.<br />' : ''?>
			<div class="champ">
			<label for="email">Email : </label>
			<input type="text" name="email" value="<?= $admin['email'] ?>">
			</div>

			<button type="submit" class="btn btn-secondary">Mettre à jour</button>
		</form>
	</div>
</div>