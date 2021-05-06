<?php

/**
 *
 */
class addPost
{
	$this->response = [];

	function __construct()
	{
		// var_dump($_POST);
		// var_dump($_FILES);

		// $target_dir = UPLOADS;
		$target_file = UPLOADS . basename($_FILES["fileToUpload"]["name"]);

		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {

		}
		else {
			$this->response[] = {'error' => }
		}
	}

	private function checkSource()
	{
		$check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			return true;
		} else {
			echo "File is not an image.";
			return false;
		}
	}

	private function checkChoice($choice){
		if (trim($choice) == '') {
			// code...
		}
	}

	private function FunctionName($value='')
	{
		// code...
	}


}
