<?php


/**
 * Comme un gabarit de page, grâce à cette class mère, on va pouvoir générer le head, header & footer sur n'importe quel controlleur enfant
 */
class View
{
	protected $pageTitle;
	public $cssList = [];
	public $jsList = [];

	function __construct()
	{

	}

	public function getHTMLHead()
	{
		ob_start();
		include(VIEW.'elements/head.php');
		$this->head = ob_get_clean();
	}

	public function getHTMLHeader()
	{
		ob_start();
		include(VIEW.'elements/header.php');
		$this->header = ob_get_clean();
	}

	public function getHTMLFooter()
	{
		ob_start();
		include(VIEW.'elements/footer.php');
		$this->footer = ob_get_clean();
	}

	public function getSession()
	{
		ob_start();
		require VIEW . 'elements/session.php';
	}



	public function render()
	{
		// var_dump($this->jsList);
		$this->jsList = array_unique ( $this->jsList , SORT_STRING );
		$this->cssList = array_unique ( $this->cssList , SORT_STRING );
		$this->getHTMLHeader();

		// $this->getSession();
		// Generate the head and footer after everything (to link each css / js module)
		$this->getHTMLHead();
		$this->getHTMLFooter();
		echo $this->head;
		echo $this->header;
		foreach ($this->main as $content){
			echo $content;
		}
		echo $this->footer;
	}


}
