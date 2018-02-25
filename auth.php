<?php
	$db = new PDO('sqlite:database/userdata.db');
	
	if (!$db)
	{
		die("Error: Failed to connect to DB! If this error persists, please contact the web admin.");
	}
	
	try
	{
		$passHash = password_hash(base64_encode(hash('sha256', $_POST['pword'], true)), PASSWORD_BCRYPT);
		$stmt = $db->prepare("SELECT phash FROM Users WHERE username=?");
		$stmt->execute(array($_POST['username'])) as $result;
		if password_verify(base64_encode(hash('sha256', $_POST['pword'], true)), $result)
		{
			session_start();
			$_SESSION['username'] = $_POST['username'];
			echo "Logged is as $_SESSION['username']";
		}
		else
		{
			die("Incorrect password.");
		}
	}
	catch (Exception $e)
	{
		die("An unknown error occured, please try again. If this error persists, please contact the web admin."); //Obviously the best PHP function ever
	}
?>
