<?php
	require_once 'utils/database.php'; // Provides handle to sql session
	require_once 'connectors/UserConnector.php'; // Gives all the functions related to User
	require_once 'connectors/ArticleVotesConnector.php';
	
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

    // Call this script when someone is loging in
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	$response = array();
	
	$UserConnector = new UserConnector($conn);
	$ArticleVotesConnector = new ArticleVotesConnector($conn);
	
	$result = $UserConnector->selectByEmail($email); // Check if email exists in Database

	if(!$result) { // If it doesn't exist
		$response["message"] = "Invalid email or password!";
		$response["success"] = false;
	}
	else { // Check if password is correct
		$passwordHash = hash('sha512', ($password . $result[UserConnector::$COLUMN_SALT]));
		if(strcmp($passwordHash, $result[UserConnector::$COLUMN_PASSWORDHASH]) == 0) { // If password matches
			$response["success"] = true;
			$response["id"] = $result[UserConnector::$COLUMN_ID]; // Record the admin id
			$response["first_name"] = $result[UserConnector::$COLUMN_FIRST_NAME];
			$response["last_name"] = $result[UserConnector::$COLUMN_LAST_NAME];
			$response["email"] = $result[UserConnector::$COLUMN_EMAIL];
			$response["admin"] = $result[UserConnector::$COLUMN_ADMIN];
			
			$voted_articles = $ArticleVotesConnector->selectByUser($result[UserConnector::$COLUMN_ID]);
			$response["voted_articles"] = array();
			for($i = 0; $i < count($voted_articles); $i++) {
				array_push($response['voted_articles'], $voted_articles[$i]['article_id']);
			}
 		}
		else { // If password does not match
			$response["success"] = false;
			$response["message"] = "Invalid email or password!";
		}
	}
	
	echo(json_encode($response)); // return a response
?>
