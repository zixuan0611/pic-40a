#!/usr/local/bin/php
<?php
	session_name('Demo'); // name the session
	session_start(); // start a session
	$_SESSION['loggedin'] = false; // have not logged in
	$_SESSION['email'] = '';

	/**
	This function validates an email address for future validation
	if it is not registered, we will continue to check email_address.
	Otherwise it flags $register_email_error as true.

	@param string $address the email address the user entered
	@param boolean $register_error the error flag to possibly change
	*/

	function validate_register($address, &$register_error){
		$our_file = fopen('password.txt', 'r') or die('cannot open file');
		while(!feof($our_file)){
			$line=fgets($our_file);
			$fields = explode("\t", $line);
			//echo $fields[1];
			//echo "<script type='text/javascript'>alert($message);</script>";
			if ($fields[0] === $address){ //if address already registered
				$register_error = true;
				//echo "<script type='text/javascript'>alert('yeah');</script>";
			}
		}
		fclose($our_file);
	}

	/**
	This function validates an email address for future validation
	if it is correct, we will continue to check password for registeration.
	Otherwise it flags $register_email_error as true.

	@param string $address the email address the user entered
	@param boolean $register_email_error the error flag to possibly change
	*/

	function validate_register_email($address, &$register_email_error){
		$length = strlen($address);
		$register_email_error = true;

		for ($i=0; $i<$length; $i++){
			if ($address[$i] === '@') { //if there is an @
				//echo "<script type='text/javascript'>alert('@@');</script>";
				$register_email_error = false;
			}
		}
		//if there is a invalid condition as below
		if ($length < 3 || $address[0] === '@' || $address[$length-1] === '@'){
			$register_email_error = true;
		}
	}

	/**
	This function validates a password for future register
	if it returns correct, after this function executes,
	the program will remember user information and log them in to welcome.php.
	Otherwise it flags $register_pass_error as true.

	@param string $password the password the user entered
	@param boolean $register_pass_error the error flag to possibly change
	*/	

	function validate_register_pass($password, &$register_pass_error){
		$length = strlen($password);
		if ($length < 6) { //if the password length is invalid
			$register_pass_error = true;
		}
		for ($i=0; $i<$length; $i++){
			//if the password is not alphanumeric
			if (!preg_match('/\d/', $password[$i]) && !preg_match('/[a-zA-Z]/', $password[$i])) {
				$register_pass_error = true;
			}
		}
	}

	/**
	This function validates an email address for future validation
	if it is correct, we will continue to check password for login.
	Otherwise it flags $login_email_error as true.

	@param string $address the email address the user entered
	@param boolean $login_email_error the error flag to possibly change
	*/

	function validate_login_email($address, &$login_email_error){
		$our_file = fopen('password.txt', 'r') or die('cannot open file');
		$login_email_error = true;
		while(!feof($our_file)){
			$line=fgets($our_file);
			$fields = explode("\t", $line);
			//echo "<script type='text/javascript'>alert('$fileds[0]');</script>";
			if ($fields[0] === $address){ //if we found our email address
				$login_email_error = false;
				//echo "<script type='text/javascript'>alert('yeah');</script>";
			}
		}
		fclose($our_file);
	}

	/**
	This function validates a password for future login
	if it returns correct, after this function executes,
	the program will log them in and send them to the welcome page.
	Otherwise it flags $login_pass_error as true.

	@param string $password the password the user entered
	@param boolean $login_pass_error the error flag to possibly change
	*/
	function validate_login_pass($address, $password, &$login_pass_error){
		//echo "hello";
		$our_file = fopen('password.txt', 'r') or die('cannot open file');
		$login_pass_error = true;
		$h_pass = hash('md2', $password);
		//echo $h_pass;
		//$message = "wrong answer";
		//echo "<script type='text/javascript'>alert('$h_pass');</script>";
		while(!feof($our_file)){
			//echo "keke";
			$line=fgets($our_file);
			$fields = explode("\t", $line);
			$fields[1] = trim($fields[1]);
			//echo $fields[1], '</br>';
			//echo strlen($fields[1]);
			//echo $h_pass, '</br>';
			//echo strlen($h_pass);

			//echo "<script type='text/javascript'>alert('$line');</script>";
			if ($fields[1] === $h_pass && $fields[0] === $address){ //if the passwords match
				//echo "check";
				$login_pass_error = false;
				//echo "<script type='text/javascript'>alert('yeah');</script>";
			}
		}
		fclose($our_file);
	}


	$login_email_error = false;
	$login_pass_error = false;
	$register_error = false;
	$register_email_error = false;
	$register_pass_error = false;
	if(isset($_POST['Register'])){ // if something was posted as register
		//$message = $_POST['name'];
		//echo "<script type='text/javascript'>alert(typeof('$message'));</script>";
		validate_register($_POST['name'], $register_error); // check it
		if(!$register_error){ //if there is no register_error
			validate_register_email($_POST['name'], $register_email_error);
			if(!$register_email_error){ //if there is no register_email_error
				validate_register_pass($_POST['pass'], $register_pass_error);
				if(!$register_pass_error){ //if there is no register_pass_error
					$our_file = fopen('password.txt', 'a') or die('cannot open');
					$hashed_pass = hash('md2', $_POST['pass']);
					//$entry = $_POST['name']."\t".$hashed_pass;
					//remember user registeration information to file
					fwrite($our_file, $_POST['name']);
					fwrite($our_file, "\t");
					fwrite($our_file, $hashed_pass);
					fwrite($our_file, "\n");
					fclose($our_file);
					$_SESSION['loggedin'] = true;
					$_SESSION['email'] = $_POST['name'];
					$message = 'register successful';
					echo("<script>alert('$message')</script>");
					echo("<script>window.location = 'welcome.php';</script>");
				}
			}
		}
	}
	else if (isset($_POST['Log_in'])){ //if something was posted as login
		validate_login_email($_POST['name'], $login_email_error);
		if(!$login_email_error){ //if there is no login_email_error
			validate_login_pass($_POST['name'], $_POST['pass'], $login_pass_error);
			if(!$login_pass_error){ // if passwords match, great
				$_SESSION['loggedin'] = true;
				$_SESSION['email'] = $_POST['name'];
				echo("<script>window.location = 'welcome.php';</script>");
			}

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
</head>
<body>
	<main>
		<form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
			<fieldset>
				<p>
					<label for="name">email address: </label>
					<input type="text" name="name" id="name"/>
				</p>
				<p>
					<label for="pass">&ge;password(6 characters letters or digits): </label>
					<input type="password" name="pass" id="pass"/>
				</p>
			</fieldset>
			<input type="submit" name="Register" value="Register" />
			<input type="submit" name="Log_in" value="Log in" />
			<!--if there is a register_error-->			
			<?php if($register_error) { ?>
				<p>Already registered. Please log in or validate.</p> <?php
			} ?>

			<!--if there is a register_email_error-->
			<?php if($register_email_error) { ?>
				<p>The email address is invalid, must be string@string.</p> <?php
			} ?>

			<!--if there is a register_pass_error-->
			<?php if($register_pass_error) { ?>
				<p>The password must be at least 6 characters, with letters and digits only.</p> <?php
			} ?>

			<!--if there is a login_email_error-->
			<?php if($login_email_error) { ?>
				<p>No such email address. Please register or validate.</p> <?php
			} ?>

			<!--if there is a login_pass_error-->
			<?php if($login_pass_error) { ?>
				<p>Your password is invalid.</p> <?php
			} ?>
					
		</form>
	</main>
</body>
</html>