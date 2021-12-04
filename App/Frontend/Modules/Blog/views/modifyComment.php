<h1><?=nl2br(htmlspecialchars($blogPost['title']))?></h1>
<p><?=nl2br(htmlspecialchars($blogPost['created_at']))?></p>
<h4><?=nl2br(htmlspecialchars($leadParagraphe))?></h4><br/>
<div class="artCont"><?=nl2br(htmlspecialchars($content))?></div><br/>

<hr>

<form method="post" action="bootstrap.php?action=modifyComment">
	<input type="hidden" id="modKey" name="modKey" value="modKey">
	<input id="idC" name="idC" type="hidden" value="<?=nl2br(htmlspecialchars($comment['id'])) ?>">
	<input id="idB" name="idB" type="hidden" value="<?=nl2br(htmlspecialchars($blogPost['id']))?>">
	
	<label for="content" class="form-label mt-4">Contenu :</label>
    <textarea class="form-control" id="content" name="content" rows="12"><?=nl2br(htmlspecialchars($comment['content'])) ?></textarea>

	<button type="submit" class="btn btn-secondary">Mettre à jour</button>
</form>