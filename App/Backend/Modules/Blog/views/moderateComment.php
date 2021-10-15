

<form method="post" action="bootstrap.php?action=executePostBlog">
<?php

if(isset($comments)){
    foreach ($comments as $comment) {?>
        <p><?php $comment['author']?></p><br/>
        <p><?php $comment['date']?></p><br/>
        <p><?php $comment['content']?></p>

        <form>
            <input id="account" name="<?php 'account' . $comment['id']?>" type="hidden" value="<?php $comment['accountId']?>">
            <input id="blogPost" name="<?php 'blogPost' . $comment['id']?>" type="hidden" value="<?php $comment['blogPostId']?>">

            <input type="radio" id="verdict1"
             name="<?php $comment['id']?>" value="true">
            <label for="contactChoice1">Valider</label>

            <input type="radio" id="verdict2"
             name="<?php $comment['id']?>" value="false">
            <label for="contactChoice2">Rejeter</label>
        </form>
<?php }
                      
}else{?>
    <p>Aucun nouveau commentaire à modérer...</p>
<?php}?>

    <button type="submit" class="bouton">Appliquer les choix</button>
</form>