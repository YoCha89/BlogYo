
<?php

if (isset($myComments)) {
	foreach ($myComments as $comment) {?>
        <p><?php $comment['author']?></p><br/>
        <p><?php $comment['date']?></p><br/>
        <p><?php $comment['content']?></p>

        <form method="post" action="bootstrap.php?action=modifyComment&id=<?=$comment['id']?>" target="blank">
            <button type="submit" class="bouton">Modifier</button>
        </form>

        <form method="post" action="bootstrap.php?action=deleteComment&id=<?=$comment['id']?>">
            <button type="submit" class="bouton">Supprimer</button>
        </form>
<?php }

} else {?>
    <p>Vous n'avez aucun commentaire publié</p>
<?php
}
?>
