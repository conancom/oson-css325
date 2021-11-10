<?php
    session_start();
    $mysqli = new mysqli("localhost", "root", null, "oson-v0");


    if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    }

    if (isset($_POST["submit-login"])){
        $emailaddress = $_POST['emailaddress'];
        $password = $_POST['password'];
        $query = "SELECT * FROM `listener` WHERE `UserEmail` = '$emailaddress' AND `UserPassword` = '$password'";
		// print($query); 
        $result = $mysqli->query($query);
        if (!$result) {
            echo $mysqli->error;
        }
        else {
			$data = $result -> fetch_array();
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


<div class="headerlistener">
    <div class="headerContentListener">oson</div>
</div>


<body>
<div id="wrapper"> 		
		</div>
		<div class="div_content" class="form">
				
				<form name ="listener-login" action="#" method="post">
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

	<div class="div_footer">  
		
	</div>

</div>
</body>
</html>

