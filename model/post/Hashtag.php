<?php

/**
 *
 */
class Hashtag extends Request
{
	private $id;
	private $name;

	public function setId($id){$this->id = intval($id);}
	public function setName($name){$this->name = htmlspecialchars($name);}

	public function getId($id){return $this->id;}
	public function getName($name){return $this->name;}

	public function addPostHashtags($post_id){
		// check if it exists
		$id = $this->exist($this->name);
		if (!$id) {
			$id = $this->addInDb($this->name);
		}
		// then we link the hashtag to the post in post_hastags db
		$this->linkHashtagToPost($post_id, $id);

		// $ids = [];
		// // For every hashtag
		// foreach ($hashtags as $name) {
		// 	// check if hashtag already exists
		// 	if ($id = $this->exist($name)) {
		// 		$ids[] = $id;
		// 	}
		// 	// Doesn't exists so we add it in database
		// 	else {
		// 		$ids[] = $this->addInDb($name);
		// 	}
		// }
		// return $ids;
	}

	private function exist($name){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from hashtags WHERE name=:name");
		$query->execute(["name"=>$name]);
		$this->allresult=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($this->allresult)) {
			return $this->allresult[0]['id'];
		}else {
			return false;
		}
	}

	private function addInDb($name){
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO hashtags (name) VALUES (:name)");
		$query->execute(['name'=>$name]);
		$this->dbclose();
		return $this->exist($name);
	}

	private function linkHashtagToPost($postId, $hashtag_id){
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO post_hashtags (id_post, id_hashtag) VALUES (:postId, :hashtagId)");
		$query->execute(['postId'=>$postId, 'hashtagId'=>$hashtag_id]);
		$this->dbclose();
	}

	public function removePostHashtags($post_id){
		$this->connectdb();
		$query = $this->pdo->prepare("DELETE FROM post_hashtags WHERE id_post = :post_id");
		$query->execute(["post_id"=> $post_id]);
		$this->dbclose();
	}
}
