<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog">
	<div class="champ">
		<label for="title">Titre :</label>
		<input type="text" name="title" value="<?php echo $blogPost['title']?>"><br/>
	</div>

	<div class="champ">
		<label for="content">Contenu :</label>
		<input type="textarea" name="content" value="<?php echo $blogPost['content']?>"><br/>
	</div>
		<input type="hidden" id="modKey" name="modKey" value="modKey"><br/>
		<input type="hidden" id="id" name="id" value="<?php echo $blogPost['id']?>"><br/>
	<button type="submit" class="bouton">Mettre à jour</button>
</form>