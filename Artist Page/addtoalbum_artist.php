<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
$albumId  = $_GET['id'];
$idartist = $_SESSION['id-artist'];

if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
}

if (isset($_POST['submit-add']) and isset($_SESSION['id-artist'])) {


  

  $query = "SELECT *, `song`.`Popularity` AS 'pop', `song`.`Explicity` AS 'e', `song`.`idSong` AS 'songid'
            FROM `artist`, `song`, `createsong`,`consistAlbum`, `Album`
            WHERE `artist`.`idArtist` = '$idartist'
            AND `createsong`.`idArtist` = `artist`.`idArtist`
            AND `createsong`.`idSong` = `song`.`idSong`
            GROUP BY `song`.`idSong`
            ORDER BY `song`.`idSong` DESC";

  // print($query); 
  $result = $mysqli->query($query);
  if (!$result) {
    echo $mysqli->error;
  } else {
    
    if (mysqli_num_rows($result) > 0) {
      $x = 1;
      while ($data = $result->fetch_array(MYSQLI_ASSOC)) {

        // Do stuff with $
        $songtoadd = 'songtoadd' . $data['songid'];
        if (isset($_POST[$songtoadd])) {
          $songtoaddid = $_POST[$songtoadd];
          $query1 = "INSERT INTO `consistalbum` (`idAlbum`, `idSong`, `EntryOfAlbum`) VALUES ('$albumId', '$songtoaddid', '0') ";
          $insert = $mysqli->query($query1);
          if (!$insert) {
            echo $mysqli->error;
          }
        }
      }
      
    }
  }
  header("Location: editalbums_artists.php?id=" . $albumId);
}

?>


<!DOCTYPE html>
<!--Font-->
<link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
<html>

<head>
  <title>Album List</title>
  <link rel="stylesheet" href="lists_artist.css">
</head>



<body>

  <nav class="menu_head">
    <div class="menu_button_group">
      <a href="home_artist.php">Home</a>
      <a href="songs_artist.php">Songs</a>
      <a href="albums_artist.php">Albums</a>
      <a href="editprofile_artist.php">Settings</a>
    </div>
  </nav>
  <form name="form" method="post" >
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
          echo '</div>';
          echo '<div class="header_details">';
          $query1 = "SELECT * FROM `album` WHERE `idAlbum` = '$albumId'";
          // print($query); 
          $result1 = $mysqli->query($query1);
          if (!$result1) {
            echo $mysqli->error;
          } else {
            if (mysqli_num_rows($result1) > 0) {
              $data1 = $result1->fetch_array();
            }
          }
          echo '<h1> Add Song to ' . $data["ArtistName"] . ', ' . $data1["AlbumName"] . '</h1>';
        }
      }
      ?>


      <div class="duobutton">

        <input name="submit-add" type="submit" value="Confirm Adding" class="button_orange">

        <select name="order by" class="button_orange" style="visibility: hidden;">
        </select>
      </div>
    </div>

    <table class="songtableedit">
      <tr>
        <th>

        </th>
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

        $query = "SELECT *, `song`.`Popularity` AS 'pop', `song`.`Explicity` AS 'e', `song`.`idSong` AS 'songid'
        FROM `artist`, `song`, `createsong`,`consistAlbum`, `Album`
        WHERE `artist`.`idArtist` = '$idartist'
        AND `createsong`.`idArtist` = `artist`.`idArtist`
        AND `createsong`.`idSong` = `song`.`idSong`
        AND (
          (NOT EXISTS
            (SELECT 1 FROM `consistAlbum`, `song` 
              WHERE `consistAlbum`.`idSong` = `song`.`idSong` 
              AND `consistAlbum`.`idSong` 
              AND `createsong`.`idArtist` = `artist`.`idArtist`
              AND `createsong`.`idSong` = `song`.`idSong` AND `artist`.`idArtist` = '$idartist')))
        GROUP BY `song`.`idSong` 
        ORDER BY `song`.`idSong` DESC";
        // print($query); 
        $result = $mysqli->query($query);
        if (!$result) {
          echo $mysqli->error;
        } else {
          if (mysqli_num_rows($result) > 0) {
            $x = 1;
            while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
              // Do stuff with $

              echo '<tr>';
              echo '<td> <input type="checkbox" name="songtoadd' . $data['songid'] . '" value="' . $data['songid'] . '"/> </td>';
              echo '<td>' . $data['songid'] . '</td>';
              echo '<td> ' . $data['Name'] . '</td>';

              $songid = $data['songid'];
              $query1 = "SELECT *
            FROM `song`, `consistAlbum`, `Album`
            WHERE `song`.`idSong` = $songid
            AND `song`.`idSong` = `consistAlbum`.`idSong`
            AND `consistAlbum`.`idAlbum` = `Album`.`idAlbum`";
              // print($query); 

              $result1 = $mysqli->query($query1);
              if (!$result1) {
                echo $mysqli->error;
              } else {
                if (mysqli_num_rows($result1) > 0) {
                  $data1 = $result1->fetch_array();

                  echo '<td> ' . $data['AlbumName'] . '</td>';
                } else {
                  echo '<td> - </td>';
                }
              }


              $query2 = "SELECT count(DISTINCT `ListenToSong`.`idListener`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong` = $songid
            GROUP BY `song`.`idSong`";
              // print($query); 

              $result2 = $mysqli->query($query2);
              if (!$result2) {
                echo $mysqli->error;
              } else {
                if (mysqli_num_rows($result2) > 0) {
                  $data2 = $result2->fetch_array();
                  echo '<td> ' . $data2['count(DISTINCT `ListenToSong`.`idListener`)'] . '</td>';
                } else {
                  echo '<td>  0 </td>';
                }
              }

              $query3 = "SELECT count(DISTINCT `ListenToSong`.`ListenToSongId`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong` = '$songid'
            GROUP BY `song`.`idSong`";
              // print($query); 

              $result3 = $mysqli->query($query3);
              if (!$result3) {
                echo $mysqli->error;
              } else {
                if (mysqli_num_rows($result3) > 0) {
                  $data3 = $result3->fetch_array();
                  echo '<td> ' . $data3['count(DISTINCT `ListenToSong`.`ListenToSongId`)'] . '</td>';
                } else {
                  echo '<td>  0 </td>';
                }
              }

              echo '<td> ' . $data['pop'] . ' </td>';
              echo '<td>' . $data['e'] . ' </td>';
              echo '</tr>';
              $x++;
            }
          }
        }
      }

      ?>


    </table>


  </form>

  <div id="div_footer">



  </div>
</body>

</html>