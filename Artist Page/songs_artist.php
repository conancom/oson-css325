<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");


if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
}


?>
<!DOCTYPE html>
<!--Font-->
<link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
<html>

<head>
  <title>Song List</title>
  <link rel="stylesheet" href="lists_artist.css">
</head>



<body>

  <nav class="menu_head">
    <div class="menu_button_group">
      <a href="home_artist.php">Home</a>
      <a href="">Songs</a>
      <a href="albums_artist.php">Albums</a>
      <a href="editprofile_artist.php">Settings</a>
    </div>
  </nav>

  <div class="wrapper_main">
    <?php
    if (isset($_SESSION['id-artist'])) {
      $idartist = $_SESSION['id-artist'];

      $query = "SELECT * FROM `artist` WHERE `idArtist` = '$idartist'";
      // print($query); 
      $result = $mysqli->query($query);
      if (!$result) {
        echo $mysqli->error;
      } else {
        if (mysqli_num_rows($result) > 0) {
          $data = $result->fetch_array();
          $_SESSION['id-artist'] = $data['idArtist'];
          $id = $data["idArtist"];
          echo '<div class="profilepic" style="background: url(img/' . $id . '.jpg); 
                        position: absolute;
                        width: 173px;
                        height: 173px;
                        left: 126px;
                        top: 198px;
                        border-radius: 202px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;
                        align-items: center;
                        margin-top: -2.25%;">';
        }
      }
    }
    ?>
  </div>


  <div class="header_details">
    <h1>Pale Waves Song List</h1>
    <div class="duobutton">
      <button type="button" class="button_orange">Create new Song</button>

      <select name="order by" class="button_orange">
      </select>
    </div>
  </div>

  <table class="songtable">
    <tr>
      <th>Song Number</th>
      <th>Song Name</th>
      <th>Album Name</th>
      <th>Listeners</th>
      <th>Streams</th>
      <th>Popularity</th>
      <th>Explicity</th>
    </tr>
    <?php
    if (isset($_SESSION['id-artist'])) {
      $idartist = $_SESSION['id-artist'];

      $query = "SELECT *
            FROM `artist`, `song`, `createsong`,`consistAlbum`, `Album`,`ListenToSong`
            WHERE `artist`.`idArtist` = '$idartist' 
            AND `createsong`.`idArtist` = `artist`.`idArtist`
            AND `createsong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong` = `consistAlbum`.`idSong`
            AND `consistAlbum`.`idAlbum` = `Album`.`idAlbum`
            ORDER BY `song`.`idSong` DESC ";
      // print($query); 
      $result = $mysqli->query($query);
      if (!$result) {
        echo $mysqli->error;
      } else {
        if (mysqli_num_rows($result) > 0) {
          $x = 1;
          while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            // Do stuff with $data
            echo '<tr>';
            echo '<td>' . $data['idSong'] . '</td>';
            echo ' <td> ' . $data['Name'] . '</td>';
            echo '<td> ' . $data['AlbumName'] . '</td>';

            $songid = $data['idSong'];
            $query2 = "SELECT count(DISTINCT `ListenToSong`.`idListener`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong` = $songid
            AND `song`.`idSong`  = `createsong`.`idSong`
            AND `createsong`.`idArtist` = `artist`.`idArtist`
            GROUP BY `ListenToSong`.`idListener`";

            // print($query); 

            $result2 = $mysqli->query($query2);
            if (!$result2) {
              echo $mysqli->error;
            } else {
              if (mysqli_num_rows($result2) > 0) {
                $data2 = $result2->fetch_array();
                echo '<td> ' . $data2['count(DISTINCT `ListenToSong`.`idListener`)'] . '</td>';
              }
            }
            
            echo '<td> ' . $data['idSong'] . ' </td>';
            echo '<td> ' . $data['idSong'] . ' </td>';
            echo '<td>' . $data['idSong'] . ' </td>';
            echo '</tr>';
            $x++;
          }
        }
      }
    }

    ?>

  </table>

  </div>
  <div id="div_footer">



  </div>
</body>

</html>