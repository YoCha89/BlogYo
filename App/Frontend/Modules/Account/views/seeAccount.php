<h2>Paramètre du compte</h2>

<p>
<div id='champSeeA'>Nom : <?=$account['name']?></div><br/>
<div id='champSeeA'>Pseudo : <?=$account['pseudo']?></div><br/>
<div id='champSeeA'>Email : <?=$account['email']?></div><br/>
</p>

<form method="post" action="bootstrap.php?action=modifyAccount&id=<?=$account['id']?>">
	<button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

<div class="AccChoice">  
<form method="post" action="bootstrap.php?action=deleteAccount">
	<button type="submit" class="btn btn-danger">Supprimer votre compte</button>
</form>
</div>

<hr>

<div class="AccOtherChoice">
	<form method="post" action="bootstrap.php?action=seeMyComments">
		<button type="submit" class="btn btn-dark">Voir mes commentaires</button>
	</form>

	<form method="post" action="bootstrap.php?action=contactAdmin">
		<button type="submit" class="btn btn-dark">Contacter le bloggeur</button>
	</form>
</div>

<form method="post" action="bootstrap.php?action=blogList">
	<button type="submit" class="btn btn-link">Les articles</button>
</form>
