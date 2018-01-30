<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$passwordHash = $_POST['passwordHash'];
	$salt = $_POST['salt'];

	$UserConnector = new UserConnector($conn);

	if(!$UserConnector->create($first_name, $last_name, $email, $passwordHash, $salt)) {
		$response['success'] = false;
		$response['message'] = "Failed to create user!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>