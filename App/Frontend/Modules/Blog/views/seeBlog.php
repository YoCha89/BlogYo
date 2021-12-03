

<div class="articleOne">
	<div class="txtActeur">
		<h1><?=nl2br(htmlspecialchars($blogPost['title']))?></h1>
		<p><?=nl2br(htmlspecialchars($blogPost['created_at']))?></p>
		<h4><?=nl2br(htmlspecialchars($leadParagraphe))?></h4><br/>
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
				<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog&id=<?=nl2br(htmlspecialchars($blogPost['id']))?>">
					<button type="submit" class="btn btn-primary">Éditer</button>
				</form>
				<form method="post" action="bootstrap.php?app=backend&action=backDeleteBlog&id=<?=nl2br(htmlspecialchars($blogPost['id']))?>">
					<button type="submit" class="btn btn-dark">Supprimer</button>
				</form>
			</div>				
	<?php } ?>

	<div class='commentBoard'>
		<div class="comBut">
		<form method="post" action="bootstrap.php?action=postComment&id=<?= nl2br(htmlspecialchars($blogPost['id'])) ?>">
			<button type="submit" class="bouton">Ajouter un commentaire</button>
		</form>
		</div>
		<div class="commentsNumber">
			<p><?=$commentsNumber?> commentaires publié(s).</p>
		</div> 
	</div>
	<div class="commentDisplay">
		<?php
	if($comments != null){
		foreach ($comments as $comment) {
			?>
		<div class="card border-secondary mb-3">
		  <div class="card-header"><?=nl2br(htmlspecialchars($comment['date_p']))?></div>
		  <div class="card-body">
		    <h4 class="card-title"><?=nl2br(htmlspecialchars($comment['author']))?></h4>
		    <p class="card-text"><?=nl2br(htmlspecialchars($comment['content']))?></p>



				<?php
		if ($comment['account_id'] == $this->app->user()->getAttribute('id') && $this->app->user()->getAttribute('id') != null) {?>
						<form method="post" action="bootstrap.php?action=modifyComment&id=<?=nl2br(htmlspecialchars($comment['id']))?>">
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