<form method="post" action="bootstrap.php?action=contactAdmin">
	
<?php
if ($this->app->user()->isAuthenticated() != true) {
  ?>
  	<label for="content">Votre email :</label>
	<input type="text" name="email"><br/>
 <?php
}else{ ?>

	<label for="title">Titre :</label>
	<input type="text" name="title"><br/>


	<input id="email" name="email" type="hidden" value="<?=nl2br(htmlspecialchars($userMail)) ?>">

<?php } ?>
	<label for="content" class="form-label mt-4">Votre message :</label>
  <textarea class="form-control" id="body" name="body" rows="12"></textarea>

	<button type="submit" class="btn btn-secondary">Envoyer le message</button>
</form>