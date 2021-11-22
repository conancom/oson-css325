<?php
session_start();

$mysqli = new mysqli("localhost", "root", '', "oson-v2");


if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
}


?>
<!DOCTYPE html>
<!--Font-->

<html>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title>Song List</title>
  <link rel="stylesheet" href="lists_artist.css">
  <link rel="stylesheet" href="home_artist.css">
</head>



<body>
  <style>
    body {
      font-family: 'Typo Round Regular';
    }

    .CreateNewSongButton,
    .Duobutton {
      font-size: 17px;
      color: white;
      transition: background-color 0.5s, border-color 0.5s;
      cursor: pointer;
      height: 27px;
      margin-top: 15px;
    }

    .CreateNewSongButton:hover,
    .Duobutton:hover {
      background-color: rgba(255, 115, 21, 0.5);
      border-color: rgba(255, 115, 21, 0.5);
      color: white;
    }

    .menu_head a {
      cursor: pointer;
      transition: color 0.5s, background-color 0.2s, border-radius 0.5s;
    }

    .menu_head a:hover {
      position: relative;
      color: white;
      background-color: rgba(255, 115, 21, 0.5);
      border-radius: 10px;
    }

    .after-head {
      position: absolute;
      height: 250px;
      width: 100%;
      opacity: 0.5;
      z-index: -1;
    }
  </style>

  <nav class="menu_head">
    <div class="menu_button_group">
      <a href="home_artist.php">Home</a>
      <a href="#">Songs</a>
      <a href="albums_artist.php">Albums</a>
      <a href="editprofile_artist.php">Settings</a>
    </div>
  </nav>

  <div class="after-head" style="background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(121,83,9,1) 26%, rgba(255,115,21,1) 94%);">

  </div>

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
          echo '<div class="profilepic" style="background: url(profileimg/' . $id . '.jpg); 
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
        echo '<h1>' . $data["ArtistName"] . ' Song List</h1>';
      }
    }
    ?>

    <div class="duobutton">
      <button type="button" class="button_orange CreateNewSongButton" onclick="location.href='addsong_artist.php'" style="font-family: 'Kanit', sans-serif;">Create new Song</button>

      <select name="order by" class="button_orange Duobutton" style="font-family: 'Kanit', sans-serif;">
      </select>
    </div>
  </div>

  <table class="songtable" style="font-family: 'Kanit', sans-serif;">
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

            echo '<tr>';
            echo '<td>' . $data['songid'] . '</td>';
            echo '<td> <a href="editsong_artist.php?id=' . $data['songid'] . '">' . $data['Name'] . '</td>';

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
  </div>

  <div id="div_footer">

  </div>
</body>

</html>