<h2>Paramètre du compte</h2>

<p>
<div id='champSeeA'>Nom : <?=$admin['name']?></div><br/>
<div id='champSeeA'>Pseudo : <?=$admin['pseudo']?></div><br/>
<div id='champSeeA'>Email : <?=$admin['email']?></div><br/>
</p>

<form method="post" action="bootstrap.php?action=modifyAccount&id=<?=$admin['id']?>">
	<button type="submit" class="bouton">Mettre à jour</button>
</form>


<a href="bootstrap.php?action=seeBlog"><div id="lienArticles">Les articles</div></a>
<a href="bootstrap.php?app=Backend&action=backCreateAdminAccount"><div id="lienArticles">Créer un compte Admin</div></a>