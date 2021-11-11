<!-- le titre ;
la date de dernière modification ;
le châpo ;
et un lien vers le blog post. -->

<?php
if ($this->app->user()->isAdmin() == 'isCo') { ?>
	<div class="Add">
		<form method="post" action="bootstrap.php?app=backend&action=backPostBlog">
			<button type="submit" class="bouton">Ajouter un article</button>
		</form>
	</div>	
<?php } ?>



<div id="listeArticles">
	<?php
foreach ($listBlogPost as $blogPost) {
	?>
	<div class="article">

		<div class="articleTxt">
			<div class="txtActeur">
				<h3><?=$blogPost['title']?></h3>
				<h4><?=nl2br($blogPost['dateP'])?></h4>
				<h4><?=nl2br($blogPost['leadParagraphe'])?></h4><br/>
			</div>

			<div class="lire">
				<form method="post" action="bootstrap.php?action=seeBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="bouton">Lire</button>
				</form>
			</div>
			<?php
			if ($this->app->user()->isAdmin() == 'isco') { ?>
				<div class="edition">
					<form method="post" action="bootstrap.php?app=backend&action=backModifyBlog&id=<?=$blogPost['id']?>">
						<button type="submit" class="bouton">Éditer</button>
					</form>
					<form method="post" action="bootstrap.php?app=backend&action=backDeleteBlog&id=<?=$blogPost['id']?>">
						<button type="submit" class="bouton">Supprimer</button>
					</form>
				</div>				
			<?php } ?>

		</div>
	</div>
	<?php
}?>
</div>