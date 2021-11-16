<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");


if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Oson Artist Login</title>
    <link rel="stylesheet" href="home_artist.css">
</head>



<body>

    <nav class="menu_head">
        <div class="menu_button_group">
            <a href="#home">Home</a>
            <a href="#songs">Songs</a>
            <a href="#albums">Albums</a>
            <a href="#settings">Settings</a>
        </div>
    </nav>

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

        <h1><?php
            echo  $data['ArtistName'];
            ?>
        </h1>
        <h2>
            <label class="subheader">
                1.6k currently listening. </label>
            <label class="subheader">
                <?php
                echo  $data['AmountOfFollowers'];
                ?> follows </label>
        </h2>

    </div>

    <div class="grid-container">
        <div class="grid-stat">This week's statistics</div>
        <div class="grid-trendsong">Trending Songs</div>
        <div class="grid-trendalbum">Trending Albums</div>
        <div class="underline1"></div>
        <div class="underline2"></div>
        <div class="underline3"></div>

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

                        echo '<div class="newlisteners">' . $data['count(DISTINCT `ListenToSong`.`idListener`)'] . ' New Listeners</div>';
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

                        echo '<div class="streams">' . $data['count(DISTINCT `ListenToSongid`)'] . ' Streams</div>';
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

                        echo '<div class="newfollows">' . $data['count(DISTINCT `FollowArist`.`idListener`)'] . ' New Follows</div>';
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
                            echo ' <div class="donations">' . $x . ' $ worth of Donations</div>';
                        }else{
                            echo ' <div class="donations">' . $data['SUM(`donatetoartist`.`amount`)'] . ' $ worth of Donations</div>';
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
                        echo '<div class="trendingsongs' . $x . '">';
                        echo '</div>';
                        echo '<div class="dessong' . $x . '">';
                        echo  $data['Name'] . '<br>' . $data['COUNT(`ListenToSongId`)'] . ' Total Streams';
                        echo '</div>';
                        $x++;
                    }
                }
            }
        }
        ?>


        <img class="trendingalbums1" src="img/album1.png" />
        <div class="trendingalbums1">
        </div>
        <div class="desalbums1">
            Fall in to pieces<br> 23.3k Total Streams
        </div>
        <img class="trendingalbums2" src="img/album1.png" />
        <div class="trendingalbums2">
        </div>
        <div class="desalbums2">
            Fall in to pieces<br> 23.3k Total Streams
        </div>
        <img class="trendingalbums3" src="img/album1.png" />
        <div class="trendingalbums3">
        </div>
        <div class="desalbums3">
            Fall in to pieces<br> 23.3k Total Streams
        </div>

    </div>

    </div>
    </div>

    <div id="div_footer">



    </div>
</body>

</html>