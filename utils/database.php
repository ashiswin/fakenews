<?php
	$conn = new mysqli("devostrum.no-ip.info", "fakenews", "fakenews", "fakenews");
	if($conn->connect_error) {
		$response["success"] = false;
		$response["message"] = "Connection failed: " . $conn->connect_error;
	}
?>
