<?php

/**
 *
 */
class Like extends Request
{
	private $id;
	private $user_id;
	private $post_id;


	function __construct($tab = null)
	{
		parent::__construct();
		if(isset($tab)){
			$this->id		= $tab['id'];
			$this->user_id	= $tab['user_id'];
			$this->post_id	= $tab['post_id'];
		}
	}

	public function getId(){return $this->id;}
	public function getUserId(){return $this->user_id;}
	public function getPostId(){return $this->post_id;}

	public function setUserId($id){$this->user_id = $id;}
	public function setPostId($id){$this->post_id = $id;}

	public function changeLike($user_id, $post_id){
		// if this like exists we drop it
		if ($id = $this->likeExists($user_id, $post_id)) {
			$this->connectdb();
			$query = $this->pdo->prepare("DELETE from post_likes WHERE id = :id");
			$query->execute(["id" => $id]);
			$this->dbclose();
		}
		// Or We create a new like
		else {
			$this->connectdb();
			$query = $this->pdo->prepare("INSERT INTO post_likes (id_user, id_post) VALUES (:user_id , :post_id)");
			$query->execute(["user_id" => $user_id, "post_id" => $post_id]);
			$this->dbclose();
		}
	}
	public function likeExists($user_id, $post_id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from post_likes WHERE id_user = :user_id AND id_post = :post_id");
		$query->execute(["user_id" => $user_id, "post_id" => $post_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			return $res[0]['id'];
		}else {
			return false;
		}
	}

	public function getAllUserLikes($user_id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from post_likes WHERE id_user = :user_id");
		$query->execute(["user_id" => $user_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			$ret = [];
			// Change results to like objects
			foreach ($res as $line) {
				$ret[] = new Like($line);
			}
			return $ret;
		}else {
			return false;
		}
	}

	public function getAllPostLikes($post_id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from post_likes WHERE id_post = :post_id");
		$query->execute(["post_id" => $post_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			$ret = [];
			// Change results to like objects
			foreach ($res as $line) {
				$ret[] = new Like($line);
			}
			return $ret;
		}else {
			return false;
		}
	}
}
