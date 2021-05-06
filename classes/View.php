<?php


/**
 * Comme un gabarit de page, grâce à cette class mère, on va pouvoir générer le head, header & footer sur n'importe quel controlleur enfant
 */
class View
{
	// Pour le HEAD
	// private $pageTitle = "Gabarit";
	private $cssList = [];
	private $jsList = [];





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



	public function render()
	{
		$this->getHTMLHead();
		$this->getHTMLHeader();
		$this->getHTMLFooter();
		echo $this->head;
		echo $this->header;
		foreach ($this->main as $content){
			echo $content;
		}
		echo $this->footer;
	}


}
