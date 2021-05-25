<?php

/**
 *
 */
class CommentManager
{

	function __construct()
	{
		if (isset($_POST)) {
			var_dump($_POST);
			$model = new Comment();
			$model->addComment($_POST['user_id'], $_POST['post_id'], $_POST['content']);
		}
	}
}
