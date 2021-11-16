<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");


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
</head>

<div class="headerartist">
	<div class="headerContentArtist">oson - For Artists</div>
</div>

<body>


	<div class="div_content" class="form">

		<form name="artist-login" action="#" method="post">
			<div class="text_wrapper">
				<label class="text_email">Email Address</label>
			</div><br>
			<input type="text" name="emailaddress" class="text_field" placeholder=" Email Address"><br>

			<div class="text_wrapper">
				<label class="text_pw">Password</label>
			</div><br>
			<input type="password" name="password" class="text_field" placeholder=" ***********"><br>


			<div class="button">
				<input type="submit" name="submit-login" value="Submit" class="button_orange"><br>
				<label class="label_text">Don't have an account ?</label><br>
				<button type="button" class="button_dark"> Register Now </button>
			</div>
		</form>
	</div>


	<div id="div_footer">

	</div>


</body>

</html>