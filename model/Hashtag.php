<?php

/**
 *
 */
class Hashtag extends Request
{

	public function addHashtags($hashtags)
	{
		$ids = [];
		// For every hashtag
		foreach ($hashtags as $name) {
			// check if hashtag already exists
			echo ($name);
			echo "<br>";
			if ($id = $this->exist($name)) {
				$ids[] = $id;
			}
			// Doesn't exists so we add it in database
			else {
				$ids[] = $this->addInDb($name);
			}
		}
		var_dump($ids);
		return $ids;
	}

	public function exist($name)
	{
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
}
