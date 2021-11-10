

<?php
// Connect to the database
session_start();
$mysqli = new mysqli("localhost", "root", null, "oson-v0");


if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
}

if (isset($_POST["submit-register"])){
    $emailaddress = $_POST['emailaddress'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $gender = $_POST['gender'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $country = $_POST['country'];
    $dateofbirth = "$year-0$month-$day";
    print "DOB -> " . $dateofbirth;
    $timezone = date_default_timezone_get();
    print "The current server timezone is: " . $timezone;
    $createdAt = date('m/d/Y h:i:s a', time());
    print ($createdAt); 


    print($emailaddress . '  ' . $gender . '  ' . $month . ' ' . $country);

    // $query = "SELECT * FROM myuser WHERE (username = '$username' AND password = '$password') OR (email = '$username' AND password = '$password')";
  
    // $result = $mysqli->query($query);
    
    // if ($result) {
    //   $data = $result->fetch_array();
    //   // $data = $row[0];
    //   // print($row["Userid"]);
    //   // print($row["Username"]);
    //   echo "userID => " . $data["Userid"];
    //   $_SESSION['current_uid'] = $data["Userid"];
    //   echo "SESSION SET";
    //   header("Location: http://localhost/css325/CSS326/CSS326/html/index.php");
    //   exit();
    // }
    // else {
    //   echo "FAILED";
    // }
}
?>