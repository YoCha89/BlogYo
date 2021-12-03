<h2>Paramètre du compte</h2>

<p>
<div id='champSeeA'>Pseudo : <?= nl2br(htmlspecialchars($admin['pseudo'])) ?></div><br/>
<div id='champSeeA'>Email : <?= nl2br(htmlspecialchars($admin['email'])) ?></div><br/>
</p>

<form method="post" action="bootstrap.php?action=modifyAccount&id=<?= nl2br(htmlspecialchars($admin['id'])) ?>">
	<button type="submit" class="bouton">Mettre à jour</button>
</form>

<form method="post" action="bootstrap.php?action=blogList">
	<button type="submit" class="btn btn-link">Les articles</button>
</form>

<form method="post" action="bootstrap.php?app=backend&action=backCreateAdminAccount">
	<button type="submit" class="btn btn-link">Créer un compte Admin</button>
</form>