<div class="form">
	<div class="blocForm">
		<form method="post" action="bootstrap.php?action=askPass">
			<p>Pour mettre à jour votre mot de passe, répondez à votre question secrète.</p>

			<div class="champ">
			<label for="newPass">Nouveau mot de passe : </label>
			<input type="password" name="newPass">
			</div>

			<div class="champ">
			<label for="confNewPass">Confirmer le nouveau mot de passe : </label>
			<input type="password" name="confNewPass">
			</div>

			<p>Question secrète : <?=nl2br(htmlspecialchars($secretQ))?></p>
			<div class="champ">
			<label for="secretA">Entrez votre réponse secrète : </label>
			<input type="text" name="secretA">
			</div>
			<input id="hiddenPseudo" name="hiddenPseudo" type="hidden" value="<?= $pseudo ?>">
			<button type="submit" class="bouton">Mettre à jour</button>
		</form>
	</div>
</div>