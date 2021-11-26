<h1>Consulter nos articles !</h1><br/>

<?php
if ($this->app->user()->isAdmin() == 'isCo') { ?>
	<div class="Add">
		<form method="post" action="bootstrap.php?app=backend&action=backPostBlog">
			<button type="submit" class="btn btn-secondary">Ajouter un article</button>
		</form>
	</div>	
<?php } ?>



<div id="listeArticles">
	<?php
foreach ($listBlogPost as $blogPost) {
        $leadParagraphe = stristr($blogPost['content'], '.', true);
	?>

	<div class="card border-secondary mb-3">
	  <div class="card-header"><?=nl2br($blogPost['created_at']); nl2br($blogPost['created_at'])?></div>
	  <div class="card-body">
	    <h4 class="card-title"><?=nl2br($blogPost['title'])?></h4>
	    <p class="card-text"><?=nl2br($leadParagraphe)?></p>

	    <div class="lire">
		<form method="post" action="bootstrap.php?action=seeBlog&id=<?=$blogPost['id']?>">
			<button type="submit" class="btn btn-secondary">Lire</button>
		</form>
	    </div>
		<?php
		if ($this->app->user()->isAdmin() == 'isco') { ?>
			<div class="edition">
				<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="btn btn-primary">Éditer</button>
				</form>
				<form method="post" action="bootstrap.php?app=backend&action=backDeleteBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="btn btn-dark">Supprimer</button>
				</form>
			</div>				
		<?php } ?>
	  </div>
	</div>

	<hr>


	<?php
}?>
</div>