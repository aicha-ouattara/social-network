<?php

/**
 *
 */
class addPost
{


	function __construct()
	{
		// var_dump($_POST);
		// var_dump($_FILES);

		// $target_dir = UPLOADS;
		$target_file = UPLOADS . basename($_FILES["imageToUpload"]["name"]);

		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["submit"])) {
			// Check if image file is a actual image or fake image
			if (!$this->checkSource()) {
				new JsonResponse(406, "La source n'est pas du bon format");
				die;
			}
			// Check if question and answers are not empty
			elseif (!$this->checkChoice($_POST["question"]) || !$this->checkChoice($_POST["firstAnswer"]) || !$this->checkChoice($_POST["secondAnswer"])) {
				new JsonResponse(406, "Un champs est vide");
				die;
			}
			$this->addHashtags($_POST["hashtags"]);
		}
		else {
			echo new JsonResponse(400, "Aucunes données envoyées");
			die;
		}
	}

	private function checkSource()
	{
		if (isset($_FILES["imageToUpload"]["tmp_name"]) && $_FILES["imageToUpload"]["tmp_name"] != '') {
			$check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
			if($check !== false) {
				// echo "File is an image - " . $check["mime"] . ".";
				return true;
			} else {
				// echo "File is not an image.";
				return false;
			}
		}
		else {
			return false;
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

	private function addHashtags($data)
	{
		$hashtags = explode(' ', $data);
		$model = new Hashtag();
		var_dump($hashtags);
		echo "<br>";
		$model->addHashtags($hashtags);
	}


}
