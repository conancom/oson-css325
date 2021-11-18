<?php
session_start();
/*
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
*/
$mysqli = new mysqli("localhost", "root", '', "oson-v2");


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
            <a href="songs_artist.php">Songs</a>
            <a href="">Albums</a>
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
                echo '<h1>' . $data["ArtistName"] . ' Album List</h1>';
            }
        }
        ?>
        <div class="duobutton">
            <button type="button" class="button_orange CreateNewSongButton" onclick="location.href='addnewalbum_artist.php'">Create new Album</button>
            <select name="order by" class="button_orange Duobutton">
            </select>
        </div>
    </div>

    <table class="songtable">
        <tr>
            <th>Album Number</th>
            <th>Album Name</th>
            <th>Genre</th>
            <th>Followers</th>
            <th>Explicity</th>
        </tr>
        <?php
        if (isset($_SESSION['id-artist'])) {
            $idartist = $_SESSION['id-artist'];

            $query = "SELECT *
            FROM `artist`,`Album`
            WHERE `artist`.`idArtist` = '$idartist' 
            AND `artist`.`idArtist` = `Album`.`idArtist`
            ORDER BY `Album`.`idAlbum` DESC";
            // print($query); 
            $result = $mysqli->query($query);
            if (!$result) {
                echo $mysqli->error;
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $x = 1;
                    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                        echo '<tr>';
                        echo '<td> ' . $data['idAlbum'] . '</td>';
                        echo '<td> <a href="editalbums_artists.php?id=' . $data['idAlbum'] . '">' . $data['AlbumName'] . '</td>';
                        echo '<td>' . $data['Genre'] . '</td>';
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