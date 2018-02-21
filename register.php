<?php                                                                                                                                                                           
	$db = new PDO('sqlite:database/userdata.db');
	                                                                                                                                                                         
	if (!$db)
	{
		 die("Error: Failed to connect to DB! If this error persists, please contact the web admin.");
	}

	while ($row = $db->query('SELECT email FROM Users'))
		if ($row == $_POST['email'])
		{
			die("Error: Account exists with specified email!";);
		}
	}

	while ($row = $db->query('SELECT usernami FROM Users'))
		if ($row == $_POST['username'])
		{
			die("Error: Account exists with specified username!");
		}
	}

	if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
	{
		die("Error: Invalid email!");
	}
	elseif (!(
		preg_match('/[a-z]/', $_POST['pword']) && preg_match('/[A-Z]/', $_POST['pword']) && preg_match('/\d/', $_POST['pword']) && preg_match('/[^a-zA-Z\d]/', $_POST['pword'])
	))
	{
		die("Error: Password must contain a lowercase letter, an uppercase letter, a number, and a special character!");
	}
	elseif ( !ctype_print($_POST['username']) || (strlen($_POST['username']) <= 16) )
	{
		die("Error: Username must be less than 16 characters long, and contain only printable ASCII characters!");
	}
	else
	{
		try {
			$passHash = password_hash(base64_encode(hash('sha256', $_POST['pword'], true)), PASSWORD_BCRYPT);
			$stmt = $db->prepare("INSERT INTO Users VALUES (?, ?, ?, ?, datetime('now')");
			$stmt->execute( array( $_POST['username'], $passHash, $_POST['email'], 0 ) );
			session_start();
			$_SESSION['username'] = $_POST['username'];
			echo "Registered! You may go back to the main page now.";
		}
		catch (Exception $e)
		{
			die("An unknown error occured, please try again. If this error persists, please contact the web admin."); //Obviously the best PHP function ever
		}
	} 
?>