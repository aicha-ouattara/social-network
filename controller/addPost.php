<?php

/**
 *
 */
class addPost
{
	private $categorieId;
	private $imagePath;
	private $question;
	private $answer1;
	private $answer2;
	private $hashtag_ids;


	function __construct()
	{
		//var_dump($_POST);
		//var_dump($_FILES);

		// $target_dir = UPLOADS;
		//$target_file = UPLOADS. "/" . basename($_FILES["imageToUpload"]["name"]);
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		if(isset($_POST["submit"])) {
			//check the data and protections
			$this->getData();

			// if no json error occured -> we add the post in database
			$this->addInDb();

			echo "<pre>";
			echo "category id : ".$this->category."<br>";
			echo "question : ".$this->question."<br>";
			echo "answer1 : ".$this->answer1."<br>";
			echo "answer2 : ".$this->answer2."<br>";
			echo "hashtags : ". var_dump($this->hashtag_ids)."<br>";
			echo "</pre>";
		}
		else {
			echo new JsonResponse(400, "Aucunes données envoyées");
			die;
		}
	}

	private function getData(){
		// Check if image file is a actual image or fake image
		$this->checkSource();
		// Check if question and answers are not empty
		if (!$this->checkChoice($_POST["question"]) || !$this->checkChoice($_POST["firstAnswer"]) || !$this->checkChoice($_POST["secondAnswer"])) {
			new JsonResponse(406, "Un champs est vide");
			die;
		}
		if (!isset($_POST['category'])) {
			new JsonResponse(406, "Sélectionner une catégorie");
			die;
		}
		// Save category id
		$this->category = $_POST['category'];
		// Protect question and answers
		$this->question = htmlspecialchars($_POST['question']);
		$this->answer1 = htmlspecialchars($_POST['firstAnswer']);
		$this->answer2 = htmlspecialchars($_POST['secondAnswer']);
		// Link this post to hashtags (creates hashtag if not already in db)
		$this->hashtag_ids = $this->addHashtags($_POST["hashtags"]);

	}

	private function checkSource(){
		// if there is an image saved temporary on the server
		if (isset($_FILES["imageToUpload"]["tmp_name"]) && $_FILES["imageToUpload"]["tmp_name"] != '') {
			$uploaddir = UPLOADS . '/';

			// each user should have a folder (based on the id) in the uploads directory => to prevent same names
			$uploadfile = $uploaddir . basename($_FILES['imageToUpload']['name']);

			// Saving the picture in uploads
			if (!move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $uploadfile)) {
				echo new JsonResponse(400, "Erreur image");
				die;
			}
		}
		// there is no image...
		else {
			new JsonResponse(406, "La source n'est pas du bon format");
			die;
		}
	}

	private function checkChoice($choice){
		if (trim($choice) == '') {
			return false;
		}
		else {
			return true;
		}
	}

	private function addHashtags($data){
		$hashtags = explode(' ', $data);
		$model = new Hashtag();
		return $model->addPostHashtags($hashtags);
	}

	public function addInDb()
	{
		//
	}
}
