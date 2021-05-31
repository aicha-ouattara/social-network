<?php

/**
 *
 */
class PostManager
{
	// private $categoryId;
	// private $imagePath;
	// private $question;
	// private $answer1;
	// private $answer2;
	// private $hashtag_ids;

	// A post instance to play with
	private $post;
	private $hashtags;


	function __construct(){
		//var_dump($_POST);
		//var_dump($_FILES);

		// First we need to check if the user is connected
		// And get his/her id

		// Get the post data and create a Post instance
		$this->post = $this->getPostData();
		$this->hashtags = $this->getPostHashtags();

		if(isset($_POST["action"])) {
			switch ($_POST['action']) {

				case "new":
					if ($this->post->checkDataForNew() == true) {
						$date = new DateTime();
						$date = $date->format('Y-m-d h:i:s');
						$this->post->setDate($date);
						// We add the post in db
						$post_id = $this->post->addPost();
						foreach ($this->hashtags as $hashtag) {
							$hashtag->addPostHashtags($post_id);
						}
					}
					new JsonResponse(200, "new post created");
					die;

				case "delete":
					if ($id = $this->post->getId()) {
						$this->post->removePost();
						// deletion of every hashtag only relative to this post
						$model = new hashtag();
						$model->removePostHashtags($id);
					}
					new JsonResponse(200, "post deleted");
					die;

				case "modify":
					// We modify the post
					if ($id = $this->post->getId()) {
						// deletion of every hashtag only relative to this post
						$model = new hashtag();
						$model->removePostHashtags($id);
						$this->post->modifyPost();
						foreach ($this->hashtags as $hashtag) {
							$hashtag->addPostHashtags($id);
						}
					}
					$this->post->modifyPost();
					// if needed we modify the hashtags
					new JsonResponse(200, "post modified");
					die;

				default:
					new JsonResponse(400, "Wrong action asked");
					die;
			}
		}
		else {
			new JsonResponse(400, "No action asked");
			die;
		}
	}

	public function getPostData(){
		$model = new Post();
		if (isset($_POST['post_id'])) {$model->setId($_POST['post_id']);}
		if (isset($_POST['user_id'])) {$model->setUserId($_POST['user_id']);}
		if (isset($_POST['category'])) {$model->setCategoryId($_POST['category']);}
		if (isset($_POST['question'])) {$model->setQuestion($_POST['question']);}
		if (isset($_POST['firstAnswer'])) {$model->setChoice1($_POST['firstAnswer']);}
		if (isset($_POST['secondAnswer'])) {$model->setChoice2($_POST['secondAnswer']);}
		if (isset($_FILES["imageToUpload"]["tmp_name"])) {
			// Checking the source, moving it in the right folder and returns the path to the post instance
			$model->setPath($this->checkSource());
		}
		return $model;
	}

	public function getPostHashtags(){
		// get the raw text containing hashtags
		$ret = [];
		if (isset($_POST['hashtags'])) {
			// creating a list of hashtags
			$hashtags = explode(' ', $_POST['hashtags']);
			// deletion of duplicates
			if (($key = array_search('', $hashtags)) !== false) {
				unset($hashtags[$key]);
			}
			// creation of a list of hashtags instancies
			foreach ($hashtags as $hashtag) {
				$model = new Hashtag();
				$model->setName($hashtag);
				$ret[] = $model;
			}
			// echo "<pre>";
			// var_dump($ret);
			return $ret;
			//$ids = $model->addPostHashtags($hashtags);
		}
	}


	private function checkSource(){
		// if there is an image saved temporary on the server
		// This method returns the path of the image
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
			return $uploadfile;
		}
		// there is no image...
		else {
			new JsonResponse(406, "La source n'est pas du bon format");
			die;
		}
	}

	// private function checkChoice($choice){
	// 	if (trim($choice) == '') {
	// 		return false;
	// 	}
	// 	else {
	// 		return true;
	// 	}
	// }
	//
	//
	// private function addHashtags($data){
	// 	$hashtags = explode(' ', $data);
	// 	if (($key = array_search('', $hashtags)) !== false) {
	// 		unset($hashtags[$key]);
	// 	}
	// 	$model = new Hashtag();
	// 	$ids = $model->addPostHashtags($hashtags);
	// 	return $ids;
	// }
	//
	// private function addInDb(){
	// 	$date = new DateTime();
	// 	$date = $date->format('Y-m-d h:i:s');
	//
	// 	$model = new Post();
	// 	$model->setUserId(36);
	// 	$model->setCategoryId(intval($this->categoryId));
	// 	$model->setPath($this->imagePath);
	// 	$model->setDate($date);
	// 	$model->setQuestion($this->question);
	// 	$model->setChoice1($this->answer1);
	// 	$model->setChoice2($this->answer2);
	//
	// 	$id = $model->addPostInDb();
	// 	return ($id);
	// 	//var_dump($model->getPostsFromUserId(2));
	// }
	//
	// public function linkPostHashtags($postId, $hashtag_ids){
	// 	$model = new Hashtag();
	// 	foreach ($hashtag_ids as $hash_id) {
	// 		$model->linkHashtagToPost($postId, $hash_id);
	// 	}
	// }
	//
	// private function getData(){
	// 	// Check if image file is a actual image or fake image
	// 	$this->checkSource();
	// 	// Check if question and answers are not empty
	// 	if (!$this->checkChoice($_POST["question"]) || !$this->checkChoice($_POST["firstAnswer"]) || !$this->checkChoice($_POST["secondAnswer"])) {
	// 		new JsonResponse(406, "Un champs est vide");
	// 		die;
	// 	}
	// 	if (!isset($_POST['category'])) {
	// 		new JsonResponse(406, "Sélectionner une catégorie");
	// 		die;
	// 	}
	// 	// Save category id
	// 	$this->categoryId = $_POST['category'];
	// 	// Protect question and answers
	// 	$this->question = htmlspecialchars($_POST['question']);
	// 	$this->answer1 = htmlspecialchars($_POST['firstAnswer']);
	// 	$this->answer2 = htmlspecialchars($_POST['secondAnswer']);
	// 	// Link this post to hashtags (creates hashtag if not already in db)
	// 	$hashtag_ids = $this->addHashtags($_POST["hashtags"]);
	// 	return $hashtag_ids;
	// }

}
