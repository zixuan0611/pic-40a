#!/usr/local/bin/php
<?php
	session_name('Demo'); // resume Demo session
	session_start(); // start a session
	if(isset($_GET['log_out'])){ //if we have logged out, clear all and return
		session_unset();
		session_destroy();
		echo("<script>window.location = 'index.php';</script>");
	}
?>