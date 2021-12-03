

<form method="post" action="bootstrap.php?app=backend&action=backModerateComment">
<?php

if(isset($comments)){
    $i=0;
    foreach ($comments as $comment) {
        
        $account = 'account_'.$i;
        $blogPost = 'blogPost_'.$i;
        $com = 'com_'.$i;
        $verdict = 'verdict_'.$i;
        ?>
        <p><?php echo nl2br(htmlspecialchars($comment['author']))?></p><br/>
        <p><?php echo nl2br(htmlspecialchars($comment['created_at']))?></p><br/>
        <p><?php echo nl2br(htmlspecialchars($comment['content']))?></p>
            <input id="proof" name="proof" type="hidden" value="proof">
            <input id="<?php echo nl2br(htmlspecialchars($account)) ?>" name="<?php echo nl2br(htmlspecialchars($account)) ?>" type="hidden" value="<?php echo nl2br(htmlspecialchars($comment['account_id']))?>">
            <input id="<?php echo nl2br(htmlspecialchars($blogPost)) ?>" name="<?php echo nl2br(htmlspecialchars($blogPost)) ?>" type="hidden" value="<?php echo nl2br(htmlspecialchars($comment['blog_post_id']))?>">
            <input id="<?php echo nl2br(htmlspecialchars($com)) ?>" name="<?php echo nl2br(htmlspecialchars($com)) ?>" type="hidden" value="<?php echo nl2br(htmlspecialchars($comment['id']))?>">

            <input type="radio" id="<?php echo nl2br(htmlspecialchars($verdict)) ?>"
             name="<?php echo nl2br(htmlspecialchars($verdict)) ?>" value="true" class="form-check-input">
            <label for="contactChoice1">Valider</label>

            <input type="radio" id="<?php echo nl2br(htmlspecialchars($verdict)) ?>"
             name="<?php  echo nl2br(htmlspecialchars($verdict)) ?>" value="false" class="form-check-input">
            <label for="contactChoice2">Rejeter</label>

            <hr>
<?php $i++;
}
                      
}else{?>
    <p>Aucun nouveau commentaire à modérer...</p>
<?php } ?>

    <br/><button type="submit" class="btn btn-secondary">Appliquer les choix</button>
</form>