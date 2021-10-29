<h2>Paramètre du compte</h2>

<p>
<div id='champSeeA'>Nom : <?=$account['name']?></div><br/>
<div id='champSeeA'>Pseudo : <?=$account['pseudo']?></div><br/>
<div id='champSeeA'>Email : <?=$account['email']?></div><br/>
</p>

<form method="post" action="bootstrap.php?action=modifyAccount&id=<?=$account['id']?>">
	<button type="submit" class="bouton">Mettre à jour</button>
</form>

<a href="bootstrap.php?action=seeBlog"><div id="lienArticles">Les articles</div></a>