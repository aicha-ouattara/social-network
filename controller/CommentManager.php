<?php

/**
 *
 */
class CommentManager
{
	private $comment;

	function __construct()
	{
		// need to check the user rights
		// And save his id in $this->user_id

		// We need an action
		if (isset($_POST['action'])) {
			//Creation of a comment instance
			$this->comment = $this->getData();

			switch ($_POST['action']) {
				case "new":
					$this->comment->addComment();
					die;
				case "delete":
					$this->comment->removeComment();
					die;
				case "modify":
					$this->comment->modifyComment();
					die;
				case "respond":
					$this->comment->addChildComment();
					die;
				default:
					new JsonResponse(400, "Wrong action asked");
					die;
			}
		}else {
			new JsonResponse(400, "No action asked");
			die;
		}
	}

	public function getData()
	{
		$model = new Comment();
		if (isset($_POST['comment_id'])) {$model->setId($_POST['comment_id']);}
		if (isset($_POST['user_id'])) {$model->setUserId($_POST['user_id']);}
		if (isset($_POST['post_id'])) {$model->setPostId($_POST['post_id']);}
		if (isset($_POST['mother_id'])) {$model->setMotherId($_POST['mother_id']);}
		if (isset($_POST['content'])) {$model->setContent($_POST['content']);}
		return $model;
	}


}
