

<div class="articleOne">
	<div class="txtActeur">
		<h1><?=$blogPost['title']?></h3>
		<h3><?=nl2br($blogPost['date_p'])?></h4>
		<h4><?=nl2br($leadParagraphe)?></h4><br/>
		<p><?=$blogPost['content']?></p>
	</div>

	<?php
		if ($this->app->user()->isAdmin() == 'isCo') { ?>
			<div class="edition">
				<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="bouton">Éditer</button>
				</form>
				<form method="post" action="bootstrap.php?action=app=backend&backDeleteBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="bouton">Supprimer</button>
				</form>
			</div>				
	<?php } ?>

	<div class='commentBoard'>
		<form method="post" action="bootstrap.php?action=postComment&id=<?= $blogPost['id'] ?>">
			<button type="submit" class="bouton">Ajouter un commentaire</button>
		</form>
		<div class="CommentsNumber">
			<p><?=$commentsNumber?></p>
		</div> 
	</div>

		<?php
	if($comments != null){
		foreach ($comments as $comment) {
			?>
					<div class="Comments">
					<h4><?=nl2br($comment['author'])?></h4><br/>
					<h4><?=nl2br($comment['dateP'])?></h4>
					<p><?=nl2br($comment['content'])?></p>
				</div>

				<?php
		if ($comment['accountId'] == $_SESSION['id']) {?>
						<form method="post" action="bootstrap.php?action=modifyComment&id=<?=$comment['id']?>">
							<button type="submit" class="bouton">Modifier</button>
						</form>
				<?php }
		}	
	} ?>



</div>