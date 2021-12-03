<h1>Vos Commentaires</h1><br/>
 

<?php
if ($myCommentsNumber != 0) { ?>

    <div class="commentsNumber">
        <p>Vous avez rédigé <?=nl2br(htmlspecialchars($myCommentsNumber))?> commentaires.</p>
    </div>

<?php
	foreach ($myComments as $comment) {?>
        <div class="card border-secondary mb-3">
            <div class="card-header"><?=nl2br(htmlspecialchars($comment['date_p']))?></div>
            <div class="card-body">
                <h4 class="card-title"><?=nl2br(htmlspecialchars($comment['author']))?></h4>
                <p class="card-text"><?=nl2br(htmlspecialchars($comment['content']))?></p>

                <div class="AccOtherChoice">
                    <form method="post" action="bootstrap.php?action=modifyComment&id=<?=$comment['id']?>" target="blank">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form method="post" action="bootstrap.php?action=deleteComment&id=<?=$comment['id']?>">
                        <button type="submit" class="btn btn-dark">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
        
        <hr>
<?php }

} else {?>
    <p>Vous n'avez aucun commentaire publié</p>
<?php
}

?>
