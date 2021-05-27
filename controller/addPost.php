<?php

/**
 *
 */
class addPost
{
	private $categoryId;
	private $imagePath;
	private $question;
	private $answer1;
	private $answer2;
	private $hashtag_ids;


	function __construct(){
		//var_dump($_POST);
		//var_dump($_FILES);
		if(isset($_POST["submit"])) {
			//get the data and protects
			$hashtag_ids = $this->getData();
			// if no json error occured -> we add the post in database
			$postId = $this->addInDb();
			// then we link post hashtags in post_hashtags table
			$this->linkPostHashtags($postId, $hashtag_ids);
			// If no error occured, return success
			new JsonResponse(200, "Post saved");
		}
		else {
			new JsonResponse(400, "Aucunes données envoyées");
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
		$this->categoryId = $_POST['category'];
		// Protect question and answers
		$this->question = htmlspecialchars($_POST['question']);
		$this->answer1 = htmlspecialchars($_POST['firstAnswer']);
		$this->answer2 = htmlspecialchars($_POST['secondAnswer']);
		// Link this post to hashtags (creates hashtag if not already in db)
		$hashtag_ids = $this->addHashtags($_POST["hashtags"]);
		return $hashtag_ids;
	}

	private function checkSource(){
		// if there is an image saved temporary on the server
		if (isset($_FILES["imageToUpload"]["tmp_name"]) && $_FILES["imageToUpload"]["tmp_name"] != '') {
			$uploaddir = UPLOADS . '/';
			// each user should have a folder (based on the id) in the uploads directory => to prevent same names
			$uploadfile = $uploaddir . basename($_FILES['imageToUpload']['name']);
			$this->imagePath = $uploadfile;
			// Saving the picture in uploads
			if (!move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $uploadfile)) {
				new JsonResponse(400, "Erreur image");
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
		if (($key = array_search('', $hashtags)) !== false) {
			unset($hashtags[$key]);
		}
		$model = new Hashtag();
		$ids = $model->addPostHashtags($hashtags);
		return $ids;
	}

	private function addInDb(){
		$date = new DateTime();
		$date = $date->format('Y-m-d h:i:s');

		$model = new Post();
		$model->setUserId(36);
		$model->setCategoryId(intval($this->categoryId));
		$model->setPath($this->imagePath);
		$model->setDate($date);
		$model->setQuestion($this->question);
		$model->setChoice1($this->answer1);
		$model->setChoice2($this->answer2);

		$id = $model->addPostInDb();
		return ($id);
		//var_dump($model->getPostsFromUserId(2));
	}

	public function linkPostHashtags($postId, $hashtag_ids){
		$model = new Hashtag();
		foreach ($hashtag_ids as $hash_id) {
			$model->linkHashtagToPost($postId, $hash_id);
		}
	}
}
