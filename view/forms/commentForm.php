<h2>Gérer les Commentaire (Ajout/suppression/modif)</h2>

<form action="comments" method="post">
	<label for="action">Action</label>
	<select name="action">
		<option value="new">Nouveau commentaire</option>
		<option value="delete">Supprimer commentaire</option>
		<option value="modify">Modifier un commentaire</option>
		<option value="respond">Répondre à un commentaire</option>
	</select>
	<br>
	<label for="comment_id">Comment Id (pour "delete ou modif")</label>
	<input type="number" name="comment_id">
	<br>
	<label for="user_id">User Id (pour nouveau)</label>
	<input type="number" name="user_id">
	<br>
	<label for="post_id">Post Id (pour nouveau)</label>
	<input type="number" name="post_id">
	<br>
	<label for="mother_id">id commentaire mère (pour réponse à un comment)</label>
	<input type="number" name="mother_id">
	<br>
	<label for="content">Commentaire (pour nouveau ou modif)</label>
	<input type="text" name="content">
	<input type="submit" name="submit" value="Valider">
</form>
