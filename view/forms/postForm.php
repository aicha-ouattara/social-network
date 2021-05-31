<h2>Gérer un Post</h2>

<form action="post" method="post" enctype="multipart/form-data">

	<label for="action">Action</label>
	<select name="action">
		<option value="new">Nouveau post</option>
		<option value="delete">Supprimer un post</option>
		<option value="modify">Modifier un post</option>
	</select>
	<br>
	<label for="post_id">Id du post (pour modif ou suppression)</label>
	<input type="number" name="post_id">
	<br>

	<label for="user_id">User Id (pour nouveau)</label>
	<input type="number" name="user_id">
	<br>

	<label for="category">Catégorie</label>
	<select name="category">
		<?php foreach ($categories as $cat): ?>
			<option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
		<?php endforeach; ?>
	</select>

	<br>

	<label for="question">Votre question</label>
	<textarea name="question" rows="4" cols="50"></textarea>

	<br>

	<label for="firstAnswer">Réponse 1</label>
	<input type="text" name="firstAnswer" >

	<br>

	<label for="secondAnswer">Réponse 2</label>
	<input type="text" name="secondAnswer" >

	<br>

	<label for="hashtags">Hastags</label>
	<textarea name="hashtags" rows="4" cols="50"></textarea>

	<br>


	<input type="hidden"
		name="MAX_FILE_SIZE"
		value="300000" />

	<label for="imageToUpload">Ajouter une photo</label>
	<input type="file"
		name="imageToUpload"
		accept="image/*">

	<br>

	<!-- <label for="videoFile">Ajouter une video:</label>
	<input type="file" id="videoFile" name="fileToUpload" capture="environment" accept="video/*"> -->

	<br>

	<input type="submit" name="submit" value="Valider">



</form>
