

<div class="articleOne">
	<div class="txtActeur">
		<h1><?=nl2br($blogPost['title'])?></h1>
		<p><?=nl2br($blogPost['created_at'])?></p>
		<h4><?=nl2br($leadParagraphe)?></h4><br/>
		<div class="artCont"><?=$content?></div><br/><br/>

		<div class="articlesList">
		<form method="post" action="bootstrap.php?action=blogList">
			<button type="submit" class="btn btn-primary">Articles</button>
		</form>
	</div>
	</div>


	<?php
		if ($this->app->user()->isAdmin() == 'isCo') { ?>
			<div class="edition">
				<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="btn btn-primary">Éditer</button>
				</form>
				<form method="post" action="bootstrap.php?app=backend&action=backDeleteBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="btn btn-dark">Supprimer</button>
				</form>
			</div>				
	<?php } ?>

	<div class='commentBoard'>
		<div class="comBut">
		<form method="post" action="bootstrap.php?action=postComment&id=<?= $blogPost['id'] ?>">
			<button type="submit" class="bouton">Ajouter un commentaire</button>
		</form>
		</div>
		<div class="commentsNumber">
			<p><?=$commentsNumber?> commentaires publiés.</p>
		</div> 
	</div>
	<div class="commentDisplay">
		<?php
	if($comments != null){
		foreach ($comments as $comment) {
			?>
		<div class="card border-secondary mb-3">
		  <div class="card-header"><?=nl2br($comment['date_p'])?></div>
		  <div class="card-body">
		    <h4 class="card-title"><?=nl2br($comment['author'])?></h4>
		    <p class="card-text"><?=nl2br($comment['content'])?></p>



				<?php
		if ($comment['account_id'] == $this->app->user()->getAttribute('id')) {?>
						<form method="post" action="bootstrap.php?action=modifyComment&id=<?=$comment['id']?>">
							<button type="submit" class="bouton">Modifier</button>
						</form>
				<?php } ?>

			</div>
		</div>

		<hr>
		<?php }	
	} ?>
	</div>
</div>