<?php
    // Call this script when someone is loging in
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	$response = array();
	
	require_once 'utils/database.php'; // Provides handle to sql session
	require_once 'connectors/UserConnector.php'; // Gives all the functions related to User
	
	$UserConnector = new UserConnector($conn);
	$result = $UserConnector->selectByEmail($email); // Check if email exists in Database

	if(!$result) { // If it doesn't exist
		$response["message"] = "Invalid email or password!";
		$response["success"] = false;
	}
	else { // Check if password is correct
		$passwordHash = hash('sha512', ($password . $result[UserConnector::$COLUMN_SALT]));
		if(strcmp($passwordHash, $result[UserConnector::$COLUMN_PASSWORDHASH]) == 0) { // If password matches
			$response["success"] = true;
			$response["adminid"] = $result[UserConnector::$COLUMN_ID]; // Record the admin id
		}
		else { // If password does not match
			$response["success"] = false;
			$response["message"] = "Invalid email or password!";
		}
	}
	
	echo(json_encode($response)); // return a response
?>