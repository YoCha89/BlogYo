<!-- le titre ;
la date de dernière modification ;
le châpo ;
et un lien vers le blog post. -->

<?php
if ($this->app->user()->isAdmin() == true) {?>
	<div class="Add">
		<form method="post" action="bootstrap.php?action=executePostBlog?>">
			<button type="submit" class="bouton">Éditer</button>
		</form>
	</div>	
<?php}?>



<div id="listeArticles">
	<?php
foreach ($listBlogPost as $blogPost) {
	?>
	<div class="acteur">
		<div class="image">
			<img src="<?=$blogPost['media']?>" alt="media" id="media"/>
		</div>

		<div class="partenaireTextuelle">
			<div class="txtActeur">
				<h3><?=$blogPost['title']?></h3>
				<h4><?=nl2br($blogPost['dateP'])?></h4>
				<h4><?=nl2br($blogPost['leadParagraphe'])?></h4><br/>
				<a href="">Découvrez le site du partenaire</a>
			</div>

			<div class="lire">
				<form method="post" action="bootstrap.php?action=executeSeeBlog&id=<?=$blogPost['id']?>">
					<button type="submit" class="bouton">Lire la suite</button>
				</form>
			</div>
			<?php
			if ($this->app->user()->isAdmin() == true) {?>
				<div class="edition">
					<form method="post" action="bootstrap.php?action=executeModifyBlog&id=<?=$blogPost['id']?>">
						<button type="submit" class="bouton">Éditer</button>
					</form>
					<form method="post" action="bootstrap.php?action=executeDeleteBlog&id=<?=$blogPost['id']?>">
						<button type="submit" class="bouton">Éditer</button>
					</form>
				</div>				
			<?php}?>

		</div>
	</div>
	<?php
}?>
</div>