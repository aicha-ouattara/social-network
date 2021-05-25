<?php


/**
 *
 */
class LikeManager
{

	function __construct()
	{
		if (isset($_POST)) {
			var_dump($_POST);
			$model = new Like();
			$model->changeLike($_POST['user_id'], $_POST['post_id']);
		}
	}
}
