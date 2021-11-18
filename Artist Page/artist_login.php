<?php
session_start();
/*
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
*/
$mysqli = new mysqli("localhost", "root", '', "oson-v2");


if ($mysqli->connect_errno) {
	echo $mysqli->connect_error;
}

if (isset($_POST["submit-login"])) {
	$emailaddress = $_POST['emailaddress'];
	$password = $_POST['password'];
	$query = "SELECT * FROM `artist` WHERE `ArtistEmail` = '$emailaddress' AND `ArtistPassword` = '$password'";
	// print($query); 
	$result = $mysqli->query($query);
	if (!$result) {
		echo $mysqli->error;
	} else {
		if (mysqli_num_rows($result) > 0) {
			$data = $result->fetch_array();
			$_SESSION['id-artist'] = $data['idArtist'];
			header("Location: home_artist.php");
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Oson Artist Login</title>
	<link rel="stylesheet" href="login.css">

	<!--Font-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<div class="headerartist">
	<div class="headerContentArtist" style="font-family: 'Typo Round Regular Demo';">O s o n - For Artists</div>
</div>

<body>
	<style>
		body {
			background-image: url("Cover-Background.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			font-family: 'Kanit', sans-serif;
		}

		.artist_register_button:hover {
			background-color: rgba(255, 115, 21, 1);
			border-color: rgba(255, 115, 21, 0.5);
		}

		.artist_register_button {
			transition: background-color 0.5s, border-color 0.5s;
			cursor: pointer;
		}

		.artist_submit_button:hover {
			background-color: rgba(255, 115, 21, 0.5);
			border-color: rgba(255, 115, 21, 0.5);
			color: white;
		}

		.artist_submit_button {
			transition: background-color 0.5s;
		}

		.container {
			margin: auto;
			width: 50%;
			margin-top: 200px;

		}
	</style>

	<div class="div_content container" class="form">

		<form name="artist-login" action="#" method="post">
			<div class="text_wrapper email">
				<label class="text_email email_label">Email Address</label>
			</div><br>
			<input type="text" name="emailaddress" class="text_field email_text" placeholder=" Email Address"><br>

			<div class="text_wrapper password">
				<label class="text_pw password_label">Password</label>
			</div><br>
			<input type="password" name="password" class="text_field password_text" placeholder=" ***********"><br>

			<div class="button">
				<input type="submit" name="submit-login" value="Submit" class="button_orange artist_submit_button" style="cursor: pointer;"><br>
				<label class="label_text">Don't have an account ?</label><br>
				<button type="button" class="button_dark artist_register_button"><a href="artist_register.php" style="text-decoration: none; color: white;">Register Now </a> </button>
			</div>

		</form>
	</div>

	<div id="div_footer">

	</div>

</body>

</html>