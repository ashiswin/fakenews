<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';
	require_once 'connectors/ArticleVotesConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	
	$id = $_GET['id'];

	$ArticleConnector = new ArticleConnector($conn);
	$ArticleVotesConnector = new ArticleVotesConnector($conn);

	$response['article'] = $ArticleConnector->select($id);
	
	$response['article']['article_votes'] = array();
	$voters = $ArticleVotesConnector->selectByArticle($id);
	for($i = 0; $i < count($voters); $i++) {
		array_push($response['article']['article_voters'], $voters[$i]['user_id']);
	}
	
	$response['success'] = true;

	echo(json_encode($response));
?>
