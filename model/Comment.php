<?php

class Comment extends Request
{
	private $id;
	private $id_post;
	private $id_user;
	private $content;


	function __construct($tab = null)
	{
		parent::__construct();
		if(isset($tab)){
			$this->id		= $tab['id'];
			$this->id_post	= $tab['id_post'];
			$this->id_user	= $tab['id_user'];
			$this->content	= $tab['content'];
		}
	}

	public function getId(){return $this->id;}
	public function getUserId(){return $this->id_user;}
	public function getPostId(){return $this->id_post;}
	public function getContent(){return $this->content;}


	public function setUserId($id){$this->id_user = $id;}
	public function setPostId($id){$this->id_post = $id;}

	public function addComment($user_id, $post_id, $content){
		if ($content != '') {
			$content = htmlspecialchars($content);
			try {
				$this->connectdb();
				$query = $this->pdo->prepare("INSERT INTO comments (id_post, id_user, content) VALUES (:id_post, :id_user , :content)");
				$query->execute(["id_post" => $post_id, "id_user" => $user_id, "content" => $content]);
				$this->dbclose();
			} catch (Exception $e) {
				echo 'Exception reçue : ',  $e->getMessage(), "\n";
			}


		}
	}

	// if ($id = $this->likeExists($user_id, $post_id)) {
	// 	$this->connectdb();
	// 	$query = $this->pdo->prepare("DELETE from post_likes WHERE id = :id");
	// 	$query->execute(["id" => $id]);
	// 	$this->dbclose();
	// }


	public function getAllUserComments($user_id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from comments WHERE id_user = :user_id");
		$query->execute(["id_user" => $user_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			$ret = [];
			// Change results to like objects
			foreach ($res as $line) {
				$ret[] = new Comment($line);
			}
			return $ret;
		}else {
			return false;
		}
	}

	public function getAllPostComments($post_id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from comments WHERE id_post = :post_id");
		$query->execute(["id_post" => $post_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			$ret = [];
			// Change results to like objects
			foreach ($res as $line) {
				$ret[] = new Comment($line);
			}
			return $ret;
		}else {
			return false;
		}
	}
}
