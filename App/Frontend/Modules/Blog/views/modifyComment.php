<h1><?=nl2br($blogPost['title'])?></h1>
<p><?=nl2br($blogPost['created_at'])?></p>
<h4><?=nl2br($leadParagraphe)?></h4><br/>
<div class="artCont"><?=nl2br($content)?></div><br/>

<hr>

<form method="post" action="bootstrap.php?action=modifyComment">
	<input type="hidden" id="modKey" name="modKey" value="modKey">
	<input id="idC" name="idC" type="hidden" value="<? echo $comment['id'] ?>">
	<input id="idB" name="idB" type="hidden" value="<? echo $blogPost['id'] ?>">

	<div class="champ">
		<label for="content">Contenu :</label>
		<input type="textarea" name="content" rows="8" value="<?php echo $comment['content'] ?>"><br/>
	</div>

	<button type="submit" class="btn btn-secondary">Mettre à jour</button>
</form>