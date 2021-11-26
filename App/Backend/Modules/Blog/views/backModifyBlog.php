<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog">
	<div class="champ">
		<label for="title">Titre :</label>
		<input type="text" name="title" class="form-control-plaintext" value="<?php echo $blogPost['title']?>"><br/>
	</div>

	<div class="champ">
		<label for="content" class="form-label mt-4">Contenu</label>
	    <textarea class="form-control" id="content" name="content" rows="8" value="<?php echo $blogPost['content']?>"></textarea><br/>
	</div>
	
		<input type="hidden" id="modKey" name="modKey" value="modKey"><br/>
		<input type="hidden" id="id" name="id" value="<?php echo $blogPost['id']?>"><br/>
	<button type="submit" class="btn btn-secondary">Mettre à jour</button>
</form>