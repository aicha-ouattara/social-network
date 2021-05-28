<?php

/**
 *
 */
class Post extends Request
{
	private $id;
	private $userId;
	private $categoryId;
	private $path;
	private $date;
	private $question;
	private $choice1;
	private $choice2;

	function __construct($tab = null)
	{
		parent::__construct();
		// Used to create a post instance from a database line
		if (isset($tab)) {
			$this->id 			= $tab['id'];
			$this->userId 		= $tab['id_user'];
			$this->categoryId 	= $tab['id_category'];
			$this->path 		= $tab['path'];
			$this->date 		= $tab['date'];
			$this->question 	= $tab['question'];
			$this->choice1 		= $tab['choice1'];
			$this->choice2 		= $tab['choice2'];
		}
	}

	///// GETTERS
	public function getId(){return $this->id;}
	public function getUserId(){return $this->userId;}
	public function getCategoryId(){return $this->categoryId;}
	public function getPath(){return $this->path;}
	public function getDate(){return $this->date;}
	public function getQuestion(){return $this->question;}
	public function getChoice1(){return $this->choice1;}
	public function getChoice2(){return $this->choice2;}

	///// SETTERS
	public function setId($id){$this->id = intval($id);}
	public function setUserId($id){$this->userId = intval($id);}
	public function setCategoryId($id){$this->categoryId = intval($id);}
	public function setPath($path){$this->path = $path;}
	public function setDate($date){$this->date = $date;}
	public function setQuestion($question){$this->question = htmlspecialchars($question);}
	public function setChoice1($choice1){$this->choice1 = htmlspecialchars($choice1);}
	public function setChoice2($choice2){$this->choice2 = htmlspecialchars($choice2);}

	public function checkDataForNew(){
		if (!empty($this->userId) && !empty($this->categoryId) && !empty($this->path)
				&& !empty($this->question) && !empty($this->choice1) && !empty($this->choice2)) {
			return true;
		}else {
			return false;
		}
	}

	public function addPost(){
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO posts (id_user, id_category, img_path, upload_date, choice1, choice2, question) VALUES (:userId, :categoryId, :img_path, :upload_date, :choice1, :choice2, :question )");
		$query->execute(["userId" => $this->userId, "categoryId" => $this->categoryId, "img_path" => $this->path, "upload_date" => $this->date, "choice1" => $this->choice1, "choice2" => $this->choice2, "question" => $this->question]);
		$id = $this->pdo->lastInsertId();
		$this->dbclose();
		return ($id);
	}

	public function modifyPost(){
		$this->connectdb();
		$query = $this->pdo->prepare("UPDATE posts SET id_category = :id_category, img_path = :img_path, question = :question, choice1 = :choice1, choice2 = :choice2 WHERE id = :id");
		$query->execute(["id_category"=> $this->categoryId, "img_path"=> $this->path, 'question' => $this->question, "choice1"=> $this->choice1, 'choice2'=>$this->choice2, 'id'=> $this->id]);
		$this->dbclose();
	}

	public function removePost()
	{
		$this->connectdb();
		$query = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");
		$query->execute(["id"=> $this->id]);
		$this->dbclose();
	}

	///// SEARCH IN DATABASE
	public function getPostsFromUserId($userId){
		$posts = [];
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from posts WHERE id_user = :userId");
		$query->execute(["userId"=>$userId]);
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		foreach ($res as $line) {
			$posts[] = new Post($line);
		}
		return $posts;
	}


}
