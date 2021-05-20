<?php

/**
 *
 */
class Hashtag extends Request
{

	public function addPostHashtags($hashtags){
		$ids = [];
		// For every hashtag
		foreach ($hashtags as $name) {
			// check if hashtag already exists
			if ($id = $this->exist($name)) {
				$ids[] = $id;
			}
			// Doesn't exists so we add it in database
			else {
				$ids[] = $this->addInDb($name);
			}
		}
		return $ids;
	}

	public function exist($name){
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

	public function addInDb($name)
	{
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO hashtags (name) VALUES (:name)");
		$query->execute(['name'=>$name]);
		$this->dbclose();
		return $this->exist($name);
	}

	public function linkHashtagToPost($postId, $hashtag_id)
	{
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO post_hashtags (id_post, id_hashtag) VALUES (:postId, :hashtagId)");
		$query->execute(['postId'=>$postId, 'hashtagId'=>$hashtag_id]);
		$this->dbclose();
	}
}
