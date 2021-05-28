<h2>Répondre à un post</h2>

<form action="reaction" method="post">
	<label for="post_id">Post Id</label>
	<input type="number" name="post_id">
	<br>
	<label for="user_id">User Id</label>
	<input type="number" name="user_id">
	<br>
	<label for="choice">Choix</label>
	<select name="choice">
		<option value="0">0</option>
		<option value="1">1</option>
	</select>
	<br>
	<input type="submit" name="submit" value="Valider">
</form>
