<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';
	require_once 'connectors/ArticleVotesConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	if (isset($_POST['article_id'])) {
		$article = $_POST['article_id'];
		$user = $_POST['user_id'];
		$upvote = 1;

		$ArticleConnector = new ArticleConnector($conn);
		$ArticleVotesConnector = new ArticleVotesConnector($conn);

		if(!$ArticleConnector->upvote($article) || !$ArticleVotesConnector->create($article, $user, $upvote)) {
			$response['success'] = false;
			$response['message'] = "Failed to upvote article!";
		}
		else {
			$response['success'] = true;
		}
	} else {
		$response['success'] = false;
		$response['message'] = "POST empty";
 	}
 	echo(json_encode($response));
?>
