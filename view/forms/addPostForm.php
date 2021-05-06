
<form action="addPost" method="post" enctype="multipart/form-data">
	<label for="category">Catégorie</label>
	<select name="category">
		<option value="">--Choisir une catégorie--</option>
		<?php foreach ($categories as $cat): ?>
			<option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
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

	<p>Durée du vote</p>


	<input type="radio" name="time" value="3" id="three">
	<label for="three">3h</label>

	<br>

	<input type="radio" name="time" value="6" id="six">
	<label for="six">6h</label>

	<br>

	<input type="radio" name="time" value="12" id="twelve">
	<label for="twelve">12h</label>

	<br>

	<input type="radio" name="time" value="24" id="day">
	<label for="day">24h</label>

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

	<input type="submit" name="submit" value="submit">Valider</button>



</form>
