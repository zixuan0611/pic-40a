#!/usr/local/bin/php
<?php
	session_name('Demo'); // resume Demo session
	session_start(); // start a session
?>
<!DOCTYPE html>
<?php
	// either no session or not logged in
	if(!isset($_SESSION['loggedin']) or !$_SESSION['loggedin']) { ?>
<html>
<head>
	<title>Unwelcome</title>
</head>
<body>
	<p>Go back and log in.</p>
</body>
</html> <?php
	}
	else { // then they are logged in for real ?>
<html>
<head>
	<title>Welcome</title>
</head>
<body>
	<p>Welcome. Your email address is </p>
	<?php echo $_SESSION['email'];
	?>
	<p>Here is a list of all registered addresses: </p>
	<?php
		//output the user's email and a list of registered emails
		$our_file = fopen('password.txt', 'r') or die('cannot open file');
		while(!feof($our_file)){
			$line=fgets($our_file);
			$fields = explode("\t", $line);
			echo $fields[0];
			echo " ";
		}
		fclose($our_file);
	?>
	<form method="get" action="logout.php">
		<input type="submit" name="log_out" value="log out" />
	</form>
</body>
</html> <?php
	} ?>