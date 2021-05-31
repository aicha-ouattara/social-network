<?php

/**
 *
 */
class Reaction extends Request
{
	private $id;
	private $user_id;
	private $post_id;
	private $choice;

	function __construct($tab = null)
	{
		parent::__construct();
		if (isset($tab['id'])) {$this->id = $tab['id'];}
		if (isset($tab['id_user'])) {$this->user_id = $tab['id_user'];}
		if (isset($tab['id_post'])) {$this->post_id = $tab['id_post'];}
		if (isset($tab['choice'])) {$this->choice = $tab['choice'];}
	}

	public function setId($id){$this->id = $id;}
	public function setUserId($id){$this->user_id = $id;}
	public function setPostId($id){$this->post_id = $id;}
	public function setChoice($choice){$this->choice = $choice;}

	public function getId(){return $this->id;}
	public function getUserId(){return $this->user_id;}
	public function getPostId(){return $this->post_id;}
	public function getChoice(){return $this->choice;}

	public function addInDb(){
		$this->connectdb();
		$query = $this->pdo->prepare("INSERT INTO post_reactions (id_post, id_user, choice) VALUES (:id_post, :id_user , :choice)");
		$query->execute(["id_post" => $this->post_id, "id_user" => $this->user_id, "choice" => $this->choice]);
		$this->dbclose();
	}

	public function alreadyExist(){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from post_reactions WHERE id_user = :user_id AND id_post = :post_id");
		$query->execute(["user_id" => $this->user_id, "post_id" => $this->post_id]);
		$res=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		if (!empty($res)) {
			return $res[0]['id'];
		}else {
			return false;
		}
	}
}
