<?php
 
//Including Database configuration file.
$mysqli = new mysqli("localhost", "root", null, "oson-v2");
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    }
 
//Getting value of "search" variable from "script.js".
 
if (isset($_POST['search'])) {
 
//Search box value assigning to $Name variable.
 
   $Name = $_POST['search'];
 
//Search query.
 
   //$Query = "SELECT `Name` FROM `song`,`album` WHERE `Name` LIKE '%$Name%' LIMIT 5";
   $Query = "SELECT s.`Name` as searchRes FROM `song` s WHERE s.`Name` LIKE '%$Name%' UNION SELECT a.`ArtistName` as searchRes FROM `artist` a WHERE a.`ArtistName` LIKE '%$Name%' LIMIT 5";
 
//Query execution
 
   // $ExecQuery = MySQLi_query($con, $Query);
   $ExecQuery = $mysqli->query($Query);
 
//Creating unordered list to display the result.
 
   echo '
 
<ul>
 
   ';
 
   //Fetching result from the database.
 
   while ($Result = $ExecQuery->fetch_array()) {
 
       ?>
 
   <!-- Creating unordered list items.
 
        Calling javascript function named as "fill" found in "script.js" file.
 
        By passing fetched result as a parameter. -->

   <div onclick="testajax()">
   <li onclick="fill(<?php echo $Result['searchRes']; ?>)" >
 
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
 
       <?php echo $Result['searchRes']; ?>
 
   </li></a>
 
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
 
   <?php
 
}}
 
 
?>
 
</ul>