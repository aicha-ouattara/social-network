<?php


Class Request
{
	public $username;
	public $pass;
	public $hostname;
	public $dbname;
	public $pdo;

	public function __construct()
	{
		$this->username = "root";
		$this->hostname = "localhost";
		$this->dbname = 'socialnetwork';
	}

	public function connectdb()
	{
		try {
			$this->pdo = new pdo("mysql:dbname=".$this->dbname.";host=".$this->hostname, $this->username,"");
		}
		catch (Exception $e)
		{
			echo $e . "<br>";
		}
	}

	public function dbclose()
	{
		$this->pdo = null;
	}

	public function findById($tab,$id){
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from '$tab' WHERE id=:id");
		$query->execute(["id"=>$id]);
		$this->allresult=$query->fetchAll();
		$this->dbclose();
		return $this->allresult;
	}

	public function findWhere($tab,$cond,$cond_check)
	{
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from '$tab' WHERE '$cond'='$cond_check'");
		$query->execute([$cond=>$cond_check]);
		$this->allresult=$query->fetchAll();
		$this->dbclose();
		return $this->allresult;
	}

	public function selectAll($table)
	{
		$this->connectdb();
		$query = $this->pdo->prepare("SELECT * from `$table`");
		$query->execute();
		$ret=$query->fetchAll(PDO::FETCH_ASSOC);
		$this->dbclose();
		return $ret;
	}

}
