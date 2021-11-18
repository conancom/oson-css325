<?php
session_start();
/*
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
*/
$mysqli = new mysqli("localhost", "root", '', "oson-v2");
$albumId  = $_GET['id'];

if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
}

?>



<!DOCTYPE html>

<html>

<head>
  <title>Album List</title>
  <link rel="stylesheet" href="lists_artist.css">
  <link rel="stylesheet" href="home_artist.css">
  <!--Font-->
  <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>



<body>

  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }

    .after-head {
      position: absolute;
      height: 250px;
      width: 100%;
      opacity: 0.5;
      z-index: -1;
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
  </style>

  <nav class="menu_head">
    <div class="menu_button_group">
      <a href="home_artist.php">Home</a>
      <a href="songs_artist.php">Songs</a>
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
        echo '<h1>' . $data["ArtistName"] . ' ' . $data1["AlbumName"] . ' Song List</h1>';
      }
    }
    ?>
    <div class="duobutton">
      <button type="button" class="button_orange" onclick="location.href='addtoalbum_artist.php?id=<?php echo $albumId ?>'"> Add new Song</button>
      <button type="button" class="button_grey" onclick="location.href='removefromalbum_artist.php?id=<?php echo $albumId ?>'"> Remove Song(s)</button>

      </select>
    </div>
  </div>

  <table class="songtable">
    <tr>
      <th>Song Number</th>
      <th>Song Name</th>

      <th>Genre</th>
      <th>Listeners</th>
      <th>Streams</th>
      <th>Popularity</th>
      <th>Explicity</th>
    </tr>

    <?php
    if (isset($_SESSION['id-artist'])) {
      $idartist = $_SESSION['id-artist'];

      $query = "SELECT *, `song`.`idSong` AS 'songid', `song`.`Name` AS 'songname'
            FROM `artist`,`Album`,`song`,`consistalbum`
            WHERE `artist`.`idArtist` = '$idartist' 
            AND `artist`.`idArtist` = `Album`.`idArtist`
            AND `Album`.`idAlbum` = $albumId
            AND `consistalbum`.`idAlbum` = `Album`.`idAlbum`
            AND `consistalbum`.`idSong`= `song`.`idSong`
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
            echo '<tr>';
            echo '<td> ' . $data['songid'] . '</td>';
            echo '<td> ' . $data['songname'] . '</td>';

            echo '<td>' . $data['Genre'] . '</td>';
            $song = $data['songid'];
            $query2 = "SELECT count(DISTINCT `ListenToSong`.`idListener`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong` = $song
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
            AND `song`.`idSong` = $song
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
            echo '<td>' . $data['AmountOfFollower'] . '</td>';
            echo '<td>' . $data['Explicity'] . '</td>';
            echo '</tr>';
          }
        }
      }
    } ?>
  </table>

  </div>
  <div id="div_footer">



  </div>
</body>

</html>