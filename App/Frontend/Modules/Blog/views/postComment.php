<form method="post" action="bootstrap.php?action=postComment&id=<?= $blogPost['id'] ?>">
	<?php
	if ($this->app->user()->isAuthenticated() == false) { ?>
		<div class="champ">
			<label for="author">Auteur :</label>
			<input type="text" name="author" class="form-control-plaintext"><br/>
		</div>
	<?php } ?>

	<label for="content" class="form-label mt-4">Message</label>
    <textarea class="form-control" id="content" name="content" rows="12"></textarea><br/>

	<button type="submit" class="btn btn-secondary">Publier</button>
</form>