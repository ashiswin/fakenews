<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_POST['userId'])) {
		$userId = $_POST['userId'];
		$articleId = $_POST['articleId'];
		$content = $_POST['content'];
		$title = $_POST['title'];

		if (isset($_POST['child_of'])) {
			$child_of = $_POST['child_of'];
		} else {
			$child_of = null;
		}

		$CommentConnector = new CommentConnector($conn);

		if(!$CommentConnector->create($userId, $content, $title, $articleId, $child_of)) {
			$response['success'] = false;
			$response['message'] = "Failed to create comment!";
		}
		else {
			$response['success'] = true;

			// Update parent
			if ($child_of != null) {
				$comment_id = $conn->insert_id;
				$parent = $CommentConnector->select($child_of);
				$children = $parent['children'];
				if ($children != null && $children != "0") {
					$children = $children . "," . $comment_id;
					$response['test'] = $children;
				} else {
					$children = $comment_id;
				}
				if (!$CommentConnector->updateChildren($child_of, $children)) {
					$response['message'] = "Warning: Parent not updated";
				}
			}
		}
	} else {
		$response['success'] = false;
		$response['message'] = "POST empty";
 	}
 	echo(json_encode($response));
?>