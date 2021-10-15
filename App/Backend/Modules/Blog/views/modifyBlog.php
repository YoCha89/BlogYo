<form method="post" action="bootstrap.php?action=postBlog">
	<div class="champ">
		<label for="title">Titre :</label>
		<input type="text" name="title" value="<?php echo $blogPost['title'] ?>"><br/>
	</div>

	<div class="champ">
		<label for="content">Contenu :</label>
		<input type="textarea" name="content" value="<?php echo $blogPost['content'] ?>"><br/>
	</div>

	<button type="submit" class="bouton">Mettre à jour</button>
</form>