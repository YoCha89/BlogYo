

<form method="post" action="bootstrap.php?app=backend&action=backModerateComment">
<?php

if(isset($comments)){
    $i=0;
    foreach ($comments as $comment) {
        // var_dump($comment);die;
        $account = 'account_'.$i;
        $blogPost = 'blogPost_'.$i;
        $com = 'com_'.$i;
        $verdict = 'verdict_'.$i;
        ?>
        <p><?php echo $comment['author']?></p><br/>
        <p><?php echo $comment['created_at']?></p><br/>
        <p><?php echo $comment['content']?></p>
            <input id="proof" name="proof" type="hidden" value="proof">
            <input id="<?php echo $account ?>" name="<?php echo $account ?>" type="hidden" value="<?php echo $comment['account_id']?>">
            <input id="<?php echo $blogPost ?>" name="<?php echo $blogPost ?>" type="hidden" value="<?php echo $comment['blog_post_id']?>">
            <input id="<?php echo $com ?>" name="<?php echo $com ?>" type="hidden" value="<?php echo $comment['id']?>">

            <input type="radio" id="<?php echo $verdict ?>"
             name="<?php echo $verdict ?>" value="true" class="form-check-input">
            <label for="contactChoice1">Valider</label>

            <input type="radio" id="<?php echo $verdict ?>"
             name="<?php  echo $verdict ?>" value="false" class="form-check-input">
            <label for="contactChoice2">Rejeter</label>

            <hr>
<?php $i++;
}
                      
}else{?>
    <p>Aucun nouveau commentaire à modérer...</p>
<?php } ?>

    <br/><button type="submit" class="btn btn-secondary">Appliquer les choix</button>
</form>