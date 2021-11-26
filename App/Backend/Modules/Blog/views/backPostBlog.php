<form method="post" action="bootstrap.php?app=backend&action=backPostBlog">
	<div class="champ">
		<label for="title">Titre :</label>
		<input type="text" name="title" class="form-control-plaintext"><br/>
	</div>

	<div class="champ">
	<label for="content" class="form-label mt-4">Contenu</label>
    <textarea class="form-control" id="content" name="content" rows="8"></textarea><br/>

	<button type="submit" class="btn btn-secondary">Publier</button>
</form>