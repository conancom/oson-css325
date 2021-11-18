<?php
session_start();

$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
/*
$mysqli = new mysqli("localhost", "root", '', "oson-v2");*/

if ($mysqli->connect_errno) {
	echo $mysqli->connect_error;
}

if (isset($_POST["submit-login"])) {
	$emailaddress = $_POST['emailaddress'];
	$password = $_POST['password'];
	$query = "SELECT * FROM `listener` WHERE `UserEmail` = '$emailaddress' AND `UserPassword` = '$password'";
	// print($query); 
	$result = $mysqli->query($query);
	if (!$result) {
		echo $mysqli->error;
	} else {
		$data = $result->fetch_array();
		$_SESSION['id-listener'] = $data['idListener'];
		header("Location: Listener-Main-Page.php");
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Oson Login</title>
	<link rel="stylesheet" href="login.css">
</head>

<body>

	<style>
		body {
			background-image: url("Cover-Background-2.jpg");
			background-repeat: no-repeat;
			background-size: cover;
		}

		.listener_register_button:hover {
			background-color: rgba(255, 115, 21, 1);
			border-color: rgba(255, 115, 21, 0.5);
		}

		.listener_register_button {
			transition: background-color 0.5s, border-color 0.5s;
			cursor: pointer;
		}

		.listener_submit_button:hover {
			background-color: rgba(255, 115, 21, 0.5);
			border-color: rgba(255, 115, 21, 0.5);
			color: white;
		}

		.listener_submit_button {
			transition: background-color 0.5s;
		}
	</style>
	<div class="headerlistener">
		<div class="headerContentListener">O s o n</div>
	</div>
	<div id="wrapper">
	</div>
	<div class="div_content" class="form">

		<form name="listener-login" action="#" method="post">
			<div class="text_wrapper">
				<label class="text_email" style="cursor: pointer; font-family: 'Kanit', sans-serif;">Email Address</label>
			</div><br>
			<input type="text" name="emailaddress" class="text_field" placeholder=" Email Address" style="cursor: pointer; font-family: 'Kanit', sans-serif;"><br>

			<div class="text_wrapper">
				<label class="text_pw" style="cursor: pointer; font-family: 'Kanit', sans-serif;">Password</label>
			</div><br>
			<input type="password" name="password" class="text_field" placeholder=" ***********" style="cursor: pointer; font-family: 'Kanit', sans-serif;"><br>


			<div class="button">
				<input type="submit" name="submit-login" value="Submit" class="button_orange listener_submit_button"><br>
				<label class="label_text" style="cursor: pointer; font-family: 'Kanit', sans-serif;">Don't have an account ?</label><br>
				<button type="button " class="button_dark listener_register_button" onclick="location.href='listener_register.php'"> <a href="listener_register.php" style="text-decoration: none; color: white; font-family: 'Kanit', sans-serif;">Register Now </a> </button>

			</div>
		</form>

		<div class="div_footer">

		</div>

	</div>
</body>

</html>