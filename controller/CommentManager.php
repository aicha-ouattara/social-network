<?php

/**
 *
 */
class CommentManager
{
	private $id;
	private $action;
	private $user_id;
	private $post_id;
	private $mother_id;
	private $content;


	function __construct()
	{
		// We need an action
		if (isset($_POST['action'])) {

			// need to check the user rights

			// Data protection
			$this->getData();

			$model = new Comment();
			switch ($_POST['action']) {
				case "new":
					$model->addComment($this->user_id, $this->post_id, $this->content);
					die;
				case "delete":
					$model->removeComment($this->id);
					die;
				case "modify":
					$model->modifyComment($this->id, $this->content);
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
		if (isset($_POST['comment_id'])) {$this->id = intval($_POST['comment_id']);}
	}


}
