<?php


/**
 *
 */
class PostReactionManager
{
	private $reaction;

	function __construct()
	{
		if (isset($_POST)) {
			// get an instance of reaction
			$this->reaction = $this->getData();
			//check if user as not already chosen
			if ($this->reaction->alreadyExist() == false) {
				$this->reaction->addInDb();
				new JsonResponse(200, "Reaction Saved");
				die;
			}else {
				new JsonResponse(400, "Reaction already exists");
				die;
			}

		}else {
			new JsonResponse(400, "No Data");
			die;
		}
	}

	private function getData(){
		$model = new Reaction();
		if (isset($_POST['id'])) {$model->setId($_POST['id']);}
		if (isset($_POST['post_id'])) {$model->setPostId($_POST['post_id']);}
		if (isset($_POST['user_id'])) {$model->setUserId($_POST['user_id']);}
		if (isset($_POST['choice'])) {$model->setChoice($_POST['choice']);}
		return $model;
	}
}
