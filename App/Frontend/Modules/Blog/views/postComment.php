<form method="post" action="bootstrap.php?action=postComment&id=<?= $blogPost['id'] ?>">
	<?php
	if ($this->app->user()->isAuthenticated() == false) { ?>
		<div class="champ">
			<label for="author">Auteur :</label>
			<input type="text" name="author"><br/>
		</div>
	<?php } ?>


	<div class="champ">
		<label for="content">Contenu :</label>
		<input type="textarea" name="content"><br/>
	</div>

	<button type="submit" class="bouton">Publier</button>
</form>