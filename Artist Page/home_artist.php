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
    <title>Oson Artist Login</title>
    <link rel="stylesheet" href="home_artist.css">

    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            <a href="#home">Home</a>
            <a href="songs_artist.php">Songs</a>
            <a href="albums_artist.php">Albums</a>
            <a href="editprofile_artist.php">Settings</a>
        </div>
    </nav>

    <div class="after-head" style="background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(121,83,9,1) 26%, rgba(255,115,21,1) 94%);">

    </div>

    <div class=wrapper_main>
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
        <h1>
            <?php
            echo  $data['ArtistName'];
            ?>
        </h1>
        <h2>
            <label class="subheader" style="font-family: 'Kanit', sans-serif;">
                1.6k currently listening. </label>
            <label class="subheader" style="font-family: 'Kanit', sans-serif;">
                <?php
                echo  $data['AmountOfFollowers'];
                ?> follows </label>
        </h2>
    </div>

    <div class="grid-container">
        <div class="grid-stat" style="font-family: 'Kanit', sans-serif;">This week's statistics</div>
        <div class="grid-trendsong" style="font-family: 'Kanit', sans-serif;">Trending Songs</div>
        <div class="grid-trendalbum" style="font-family: 'Kanit', sans-serif;">Trending Albums</div>
        <div class="underline1" style="font-family: 'Kanit', sans-serif;"></div>
        <div class="underline2" style="font-family: 'Kanit', sans-serif;"></div>
        <div class="underline3" style="font-family: 'Kanit', sans-serif;"></div>

        <div class="grid-subcontainer">
            <img class="newlistenersimg" src="img/down_arrow.png" />
            <?php
            if (isset($_SESSION['id-artist'])) {

                $query = "SELECT count(DISTINCT `ListenToSong`.`idListener`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong`  = `createsong`.`idSong`
            AND `createsong`.`idArtist` = `artist`.`idArtist`
            AND `artist`.`idArtist` = $id
            AND YEARWEEK(`ListenTimeStamp`, 1) = YEARWEEK(CURDATE(), 1);";

                // print($query); 
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $data = $result->fetch_array();

                        echo '<div class="newlisteners" style="font-family: "Kanit", sans-serif;">' . $data['count(DISTINCT `ListenToSong`.`idListener`)'] . ' New Listeners</div>';
                    }
                }
            }
            ?>


            <br>
            <br>
            <img class="streamsimg" src="img/up_arrow.png" />

            <?php
            if (isset($_SESSION['id-artist'])) {

                $query = "SELECT count(DISTINCT `ListenToSongid`)
            FROM `listener`, `song`, `createsong`, `ListenToSong`, `artist` 
            WHERE `ListenToSong`.`idSong` = `song`.`idSong`
            AND `song`.`idSong`  = `createsong`.`idSong`
            AND `createsong`.`idArtist` = `artist`.`idArtist`
            AND `artist`.`idArtist` = $id
            AND YEARWEEK(`ListenTimeStamp`, 1) = YEARWEEK(CURDATE(), 1);";

                // print($query); 
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $data = $result->fetch_array();

                        echo '<div class="streams" style="font-family: "Kanit", sans-serif;">' . $data['count(DISTINCT `ListenToSongid`)'] . ' Streams</div>';
                    }
                }
            }
            ?>

            <br>
            <br>
            <img class="newfollowsimg" src="img/up_arrow.png" />

            <?php
            if (isset($_SESSION['id-artist'])) {

                $query = "SELECT count(DISTINCT `FollowArist`.`idListener`)
            FROM `listener`, `song`, `createsong`, `FollowArist`, `artist` 
            WHERE `artist`.`idArtist` = $id
            AND `FollowArist`.`idArtist` = `artist`.`idArtist`
            AND YEARWEEK(`FollowDate`, 1) = YEARWEEK(CURDATE(), 1);";

                // print($query); 
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $data = $result->fetch_array();

                        echo '<div class="newfollows" style="font-family: "Kanit", sans-serif;">' . $data['count(DISTINCT `FollowArist`.`idListener`)'] . ' New Follows</div>';
                    }
                }
            }
            ?>
            <br>
            <br>
            <img class="donationsimg" src="img/up_arrow.png" />

            <?php
            if (isset($_SESSION['id-artist'])) {

                $query = "SELECT SUM(`donatetoartist`.`amount`)
            FROM `donatetoartist`, `artist` 
            WHERE `donatetoartist`.`idArtist` = `artist`.`idArtist`
            AND `artist`.`idArtist` = $id
            AND YEARWEEK(`DonateTimeStamp`, 1) = YEARWEEK(CURDATE(), 1);";

                // print($query); 
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $data = $result->fetch_array();
                        if (is_null($data['SUM(`donatetoartist`.`amount`)'])) {
                            $x = 0;
                            echo ' <div class="donations" style="font-family: "Kanit", sans-serif;">' . $x . ' $ worth of Donations</div>';
                        } else {
                            echo ' <div class="donations" style="font-family: "Kanit", sans-serif;">' . $data['SUM(`donatetoartist`.`amount`)'] . ' $ worth of Donations</div>';
                        }
                    }
                }
            }
            ?>

        </div>

        <?php
        if (isset($_SESSION['id-artist'])) {

            $query = "SELECT `song`.* , COUNT(`ListenToSongId`) 
            FROM `artist`, `song`, `createsong`, `ListenToSong` 
            WHERE `artist`.`idArtist` = '$id' 
            AND `artist`.`idArtist` = `createsong`.`idArtist` 
            AND `createsong`.`idSong` = `song`.`idSong` 
            AND `ListenToSong`.`idSong` = `song`.`idSong` 
            GROUP BY `idSong` 
            ORDER BY COUNT(`ListenToSongId`) DESC 
            LIMIT 0,3;";
            // print($query); 
            $result = $mysqli->query($query);
            if (!$result) {
                echo $mysqli->error;
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $x = 1;
                    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                        // Do stuff with $data
                        echo  '<img class="trendingsongs' . $x . '" src="songimg/' . $data['idSong'] . '.jpg" width="186" height="186"/>';
                        echo '<div class="trendingsongs' . $x . '" style="font-family: "Kanit", sans-serif;">';
                        echo '</div>';
                        echo '<div class="dessong' . $x . '" style="font-family: "Kanit", sans-serif;">';
                        echo  $data['Name'] . '<br>' . $data['COUNT(`ListenToSongId`)'] . ' Total Streams';
                        echo '</div>';
                        $x++;
                    }
                }
            }
        }
        ?>


        <?php
        if (isset($_SESSION['id-artist'])) {

            $query = "SELECT `album`.* , COUNT(`ListenToSongId`) 
            FROM `artist`, `song`, `createsong`,`consistAlbum`, `Album`, `ListenToSong`
            WHERE `artist`.`idArtist` = $id
            AND `artist`.`idArtist` = `createsong`.`idArtist` 
            AND `createsong`.`idSong` = `song`.`idSong` 
            AND `song`.`idSong` = `consistAlbum`.`idSong`
            AND `consistAlbum`.`idAlbum` = `Album`.`idAlbum`
            AND `ListenToSong`.`idSong` = `song`.`idSong` 
            GROUP BY `idAlbum` 
            ORDER BY COUNT(`ListenToSongId`) DESC 
            LIMIT 0,3;";
            // print($query); 
            $result = $mysqli->query($query);
            if (!$result) {
                echo $mysqli->error;
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $x = 1;
                    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                        // Do stuff with $data
                        echo  '<img class="trendingalbums' . $x . '" src="albumimg/' . $data['idAlbum'] . '.jpg" width="186" height="186"/>';
                        echo '<div class="trendingalbums' . $x . '" style="font-family: "Kanit", sans-serif;">';
                        echo '</div>';
                        echo '<div class="desalbums' . $x . '" style="font-family: "Kanit", sans-serif;">';
                        echo  $data['AlbumName'] . '<br>' . $data['COUNT(`ListenToSongId`)'] . ' Total Streams';
                        echo '<br>';
                        echo '</div>';
                        $x++;
                    }
                }
            }
        }
        ?>




    </div>

    </div>
    </div>

    <div id="div_footer">

    </div>
</body>

</html>