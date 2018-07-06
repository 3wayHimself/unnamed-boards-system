<?php
	$db = new PDO('sqlite:database/content.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!$db)
	{
		die("Error: Failed to connect to DB! If this error persists, please contact the web admin.");
	}

	try {
		/* Insecure. You should know better. */
		$stmt = $db->prepare("SELECT * FROM Threads WHERE rowid=?"); //id, cid, name, content, sorting, pinned, uid
		$stmt->execute(array($_GET['tid']))->fetchAll() as $result;
	}
	catch (Exception $s)
	{
		die("Error: DB problem.  Contact the web admin if this error persits")
	}

	//rendering stuff
?>
