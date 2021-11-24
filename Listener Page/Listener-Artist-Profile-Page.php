<?php
session_start();
$listenerid = $_SESSION['id-listener'];

$mysqli = new mysqli("localhost", "root", null, "oson-v2");

if (isset($_GET['idArtist'])) {
    $artistid = $_GET['idArtist'];
    $query = "SELECT * FROM `artist` WHERE idArtist = " . $artistid;
}

if (isset($_POST['follow-album']) && isset($_POST['is-follow'])) {
    // $check_if_exist = "";
    if ($_POST['is-follow'] == 0) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $follow_q = sprintf("INSERT INTO `followarist`(`idListener`, `idArtist`, `FollowDate`, `FollowTime`) VALUES(%d, %d, '%s', '%s')", $listenerid, $artistid, $date, $time);
        echo $follow_q;
        $result = $mysqli->query($follow_q);
        if (!$result) {
            echo $mysqli->error;
        } else {
            header("Location: Listener-Artist-Profile-Page.php?idArtist=" . $artistid);
        }
    } else {
        $unfollow_q = sprintf("DELETE FROM `followarist` WHERE `idListener` = %d AND `idArtist` = %d", $listenerid, $artistid);
        echo $unfollow_q;
        $result = $mysqli->query($unfollow_q);
        if (!$result) {
            echo $mysqli->error;
        } else {
            header("Location: Listener-Artist-Profile-Page.php?idArtist=" . $artistid);
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="Stylesheet" type="text/css" href="Listener-Main-Page-Styling.css">
    <link rel="Stylesheet" href="Listener-Artist-Profile-Page-Styling.css">
    <link rel="Stylesheet" type="text/css" href="Trackbar-Styling.css">


    <!--Bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--Icons-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a062562745.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="row">
        <div class="columntest-side">
            <div class="Sidebar" style="position: fixed;">
                <a href="Listener-Main-Page.php">
                    <p>
                        <ion-icon name="home-outline"></ion-icon>
                        Home
                    </p>
                </a>
                <a href="Listener-Search-Page.php">
                    <p>
                        <ion-icon name="search-outline"></ion-icon>
                        Search
                    </p>
                </a>
                <a href="Listener-Playlist-Page.php">
                    <p>
                        <ion-icon name="reorder-four-outline"></ion-icon>
                        Playlist
                    </p>
                </a>
                <a href="Listener-Album-Page.php">
                    <p>
                        <ion-icon name="albums-outline"></ion-icon>
                        Album
                    </p>
                </a>
                <a href="Listener-Settings-Page.php">
                    <p>
                        <ion-icon name="settings-outline"></ion-icon>
                        Settings
                    </p>
                </a>
            </div>
        </div>

        <div class="columntest-artist">
            <div class="Main">
                <div class="ArtistProfile">
                    <div class="ArtistContainer" style="padding-top: 20px;  color: white;">
                        <div class="row">
                            <?php
                            $query = "SELECT COUNT(fart.`FollowArtistId`) as NUMFOLLOWER, art.* FROM `artist` art, `followarist` fart WHERE fart.`idArtist` = art.`idArtist` AND art.`idArtist` = " . $artistid;
                            $result = $mysqli->query($query);
                            $art = $result->fetch_array();
                            ?>
                            <div class="col-md-3">
                                <img src="<?php echo 'profileimg/' . $artistid . '.jpg' ?>" style="clip-path: circle(36.9% at 50% 50%); width: 55%;">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <h1>
                                        <?php echo $art['ArtistName'] ?>
                                    </h1>
                                </div>

                                <div class="row">
                                    <h1>
                                        <?php echo $art['NUMFOLLOWER'] ?> Followers
                                    </h1>
                                </div>

                                <div class="row g-0">
                                    <div class="col FollowButton ">
                                        <?php
                                        // $query = sprintf("SELECT COUNT(*) ISFOLLOW FROM `followalbum` WHERE `idListener` = %d AND `idAlbum` = %d", $listenerid, $albumid);
                                        $query = sprintf("SELECT COUNT(fart.FollowArtistId) as ISFOLLOW, art.* FROM `followarist` fart, `artist` art  
                                            WHERE fart.idListener = %d AND art.idArtist = fart.idArtist AND fart.idArtist = %d", $listenerid, $artistid);
                                        $result = $mysqli->query($query);
                                        $data = $result->fetch_array();
                                        ?>
                                        <form action="#fllw" method="post">
                                            <input type="hidden" name="is-follow" value="<?php echo $data['ISFOLLOW'] ?>">
                                            <button class="FollowBtn" name="follow-album">
                                                <?php if ($data['ISFOLLOW'] == 0) {
                                                    echo "Follow";
                                                } else {
                                                    echo "Unfollow";
                                                } ?>
                                            </button>
                                        </form>
                                        <?php

                                        ?>
                                    </div>

                                    <div class="col FollowButton ">
                                        <form method="post">
                                            <button type="button" class="DonateBtn" name="donate" style="margin-left: -500px;" 
                                            <?php echo "onclick=\"location.href='Donation-Gateway.php?idArtist=".$artistid."'\">"; ?>
                                             
                                             
                                                Donate
                                            </button>
                                        </form>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!---------------------------------------------------------------------------------------------------->

                        <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                            <h1>Top 5 Songs From <?php echo $art['ArtistName'] ?></h1>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p>Name</p>
                            </div>
                            <div class="col-md-3">
                                <p>Popularity</p>
                            </div>
                            <div class="col-md-3">
                                <p>Duration</p>
                            </div>

                        </div>
                        <!---------------------------------------------------------------------------------------------------->
                        <?php
                        // CAUSE ERROR //
                        // $query = "SELECT cs.*, s.* FROM `createsong` cs, `song` s WHERE s.idSong = cs.idSong AND cs.idArtist =" . $artistid . " ORDER BY s.Popularity DESC LIMIT 0, 5";
                        // $result = $mysqli->query($query);

                        # $query = "SELECT * FROM `createsong` WHERE idArtist = " . $artistid;
                        $query = "SELECT s.Popularity, cs.* FROM createsong cs, song s WHERE cs.idArtist =" . $artistid . " AND cs.idSong = s.idSong ORDER BY s.Popularity DESC LIMIT 0,5";
                        $artist_eles = $mysqli->query($query);
                        while ($ele = $artist_eles->fetch_array()) {
                            $query = "SELECT * FROM `song` WHERE idSong = " . $ele['idSong'];
                            $song = $mysqli->query($query);
                            $song = $song->fetch_array();
                        ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <p><?php
                                        $songname = $song['Name'];
                                        echo '<form action="#" method="post">';
                                        $songid = $song['idSong'];
                                        echo '<input type="hidden" name="play-id-song" value="' . $songid . '">';
                                        echo '<button type="submit" name="pressedsong">' . $songname . '</button>';
                                        echo '</form>';

                                        ?></p>



                                </div>

                                <div class="col-md-3">
                                    <p><?php echo $song['Popularity'] ?></p>
                                </div>

                                <div class="col-md-3">
                                    <p><?php echo $song['Duration'] ?></p>
                                </div>

                                <div class="col-md-3">
                                    <?php
                                    if (isset($_POST['add-to-playlist'])) {
                                        if ($_POST['add-id-song-2-pl'] == $song['idSong']) {
                                            $query_if_exist = sprintf("SELECT COUNT(`idSong`) as SONG_EXIST FROM `consistplaylist` WHERE `idPlaylist` = %d AND `idSong` = %d", $_POST['id-playlist'], $song['idSong']);
                                            $result = $mysqli->query($query_if_exist);
                                            $if_exist = $result->fetch_array();
                                            // echo 'SONG EXIST ====' . $if_exist['SONG_EXIST']; 
                                            if ($if_exist['SONG_EXIST'] == 0) {
                                                $insert = sprintf("INSERT INTO `consistplaylist`(`idSong`, `idPlaylist`, `CreationTimeStamp`) VALUES (%d, %d, NOW())", $_POST['add-id-song-2-pl'], $_POST['id-playlist']);
                                                echo $insert;
                                                $result = $mysqli->query($insert);
                                                if ($result) {
                                                    echo "ADDED TOPLAYLIST";
                                                }
                                            } else {
                                                echo "XXXXX already in pl";
                                            }
                                        }
                                    }
                                    ?>
                                    <form action="#" method="post">
                                        <input type="hidden" name="add-id-song" value=<?php echo $song['idSong']; ?>>
                                        <button class="AddToPlaylist" type="submit" name="first-hit">Add to Playlist</button>
                                    </form>

                                    <?php


                                    if (isset($_POST['first-hit'])) {
                                        if ($_POST['add-id-song'] == $song['idSong']) {
                                            $query_pl = "SELECT * FROM `playlist` WHERE `idListener` =" . $listenerid;
                                            $result = $mysqli->query($query_pl);
                                            while ($row = $result->fetch_array()) {
                                    ?>
                                                <form action="##" method="post">
                                                    <input type="hidden" name="id-playlist" value=<?php echo $row['idPlaylist'] ?>>
                                                    <input type="hidden" name="add-id-song-2-pl" value=<?php echo $_POST['add-id-song'] ?>>
                                                    <button class="AddToPlaylistClicked" name="add-to-playlist" type="submit">
                                                        <p><?php echo $row['PlaylistName'] ?></p>
                                                    </button>
                                                </form>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <hr>

                        <div class="row">
                            <h1>
                                Albums
                            </h1>
                        </div>

                        <!---------------------------------------------------------------------------------------------------->

                        <!-- <div class="row">
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                        </div> -->
                        <div class="row">
                            <?php
                            $query = "SELECT al.* FROM album al WHERE al.idArtist = " . $artistid;
                            $result = $mysqli->query($query);
                            while ($album = $result->fetch_array()) {
                            ?>

                                <div class="col-md-3" style="width: 250px; margin-left: 20px;">

                                    <div class="row Artist-Pic">
                                        <a style="text-decoration: none;" href="Listener-Album-Profile-Page.php?idAlbum=<?php echo $album['idAlbum'] ?>">
                                            <img width="250" height="250" src="<?php echo 'albumimg /' . $album['idAlbum'] . '.jpg'; ?>" alt="Album Picture" style="padding-bottom: 20px;"></a>
                                    </div>
                                    <div class="row Artist-Name" style="margin-top: 15px;">
                                        <a style="text-decoration: none;" href="Listener-Album-Profile-Page.php?idAlbum=<?php echo $album['idAlbum'] ?>">
                                            <h3 style="text-align: center;"><?php echo $album['AlbumName'] ?></h3>
                                        </a>
                                    </div>
                                    <div class="row Playlist-Type">
                                        <p style="text-align: center;">Album [<?php echo $album['Genre'] ?>]</p>
                                    </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row Trackbar">

        <div class="col">
            <div class="buttonsContainer" style="position:relative; top: 20%; left: 10%;">
                <button style="width: 50px; height: 50px; border: none; border-radius: 360%; padding: 10px;" onclick="previous_song()" id="pre"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
                <button style="width: 50px; height: 50px; border: none; border-radius: 360%;" onclick="justplay()" id="play"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button style="width: 50px; height: 50px; border: none; border-radius: 360%;" onclick="next_song()" id="next"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
            </div>
        </div>

        <div class="col-8">
            <div class="row">
                <div class="music-data">
                    <p id="title" class="title">Title.mp3</p>
                    <p id="artist" class="artistName">Artist name</p>
                </div>
            </div>

            <div class="row">
                <div class="duration" style="margin-left: 100px;">
                    <input type="range" min="0" max="100" value="0" id="duration_slider" onchange="change_duration()">
                    <img type="hidden" id="track_image" class="track_image" style=" visibility: hidden; width:0;">
                </div>

            </div>
        </div>

        <div class="col">
            <div class="music-option">
                <div class="volume">
                    <p id="volume_show">75</p>
                    <i class="fa fa-volume-up" aria-hidden="true" onclick="mute_sound()" id="volume_icon"></i>
                    <input type="range" min="0" max="100" value="75" onchange="volume_change()" id="volume">
                    <button style="border: none;" id="auto" onclick="autoplay_switch()"><i class="fa fa-circle-o-notch" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let previous = document.querySelector('#pre');
        let play = document.querySelector('#play');
        let next = document.querySelector('#next');
        let title = document.querySelector('#title');
        let recent_volume = document.querySelector('#volume');
        let volume_show = document.querySelector('#volume_show');
        let slider = document.querySelector("#duration_slider");
        let show_duration = document.querySelector('#show_duration');
        let track_image = document.querySelector('#track_image');
        let auto_play = document.querySelector('#auto');
        let present = document.querySelector('#present');
        let total = document.querySelector('#total');
        let artist = document.querySelector('#artist');

        let timer;

        let autoplay = 0;

        let index_no = 0;
        let Playing_song = false;

        //create a audio Element
        let track = document.createElement('audio');

        //All songs list
        let All_song = [
            <?php

            if (!isset($_POST['pressedsong'])) {


                $query = "SELECT DISTINCT `song`.*, `artist`.`ArtistName`
FROM `artist`, `song`, `createsong`, `ListenToSong`, `listener`
WHERE `listener`.`idListener` = '$listenerid'
AND `listener`.`idListener` = `ListenToSong`.`idListener`
AND `artist`.`idArtist` = `createsong`.`idArtist` 
AND `createsong`.`idSong` = `song`.`idSong` 
AND `ListenToSong`.`idSong` = `song`.`idSong`  
ORDER BY `ListenToSongId` DESC
LIMIT 0, 10;";
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $numrows = mysqli_num_rows($result);
                        $x = 1;
                        while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                            echo '{';
                            echo 'name: "' . $data['Name'] . ' |",';
                            echo 'path: "song/' . $data['idSong'] . '.mp3",';
                            echo 'img: "songimg/' . $data['idSong'] . '.jpg",';
                            echo 'singer: "| ' . $data['ArtistName'] . '"';
                            if ($x < $numrows) {
                                echo '},';
                            } else {
                                echo '}';
                            }

                            $song = $data['idSong'];



                            $query2 = "INSERT INTO `listentosong` (`idListener`, `idSong`, `DurationListenedTo`) 
VALUES ('$listenerid', '$song', '1.0') ";
                            $result2 = $mysqli->query($query2);
                            if (!$result2) {
                                echo $mysqli->error;
                            }


                            $x++;
                        }
                    } else {
                        $query1 = "SELECT `song`.*, `artist`.`ArtistName`, COUNT(`ListenToSong`.`ListenToSongId`) 
        FROM `artist`, `song`, `createsong`, `ListenToSong` 
        WHERE `artist`.`idArtist` = `createsong`.`idArtist` 
        AND `createsong`.`idSong` = `song`.`idSong` 
        AND `ListenToSong`.`idSong` = `song`.`idSong` 
        GROUP BY `song`.`idSong` 
        ORDER BY COUNT(`ListenToSong`.`ListenToSongId`) DESC 
        LIMIT 0, 10; ";
                        $result1 = $mysqli->query($query1);
                        if (!$result1) {
                            echo $mysqli->error;
                        } else {
                            if (mysqli_num_rows($result1) > 0) {
                                $numrows = mysqli_num_rows($result1);
                                $x = 1;
                                while ($data1 = $result1->fetch_array(MYSQLI_ASSOC)) {
                                    echo '{';
                                    echo 'name: "' . $data1['Name'] . ' |",';
                                    echo 'path: "song/' . $data1['idSong'] . '.mp3",';
                                    echo 'img: "songimg/' . $data1['idSong'] . '.jpg",';
                                    echo 'singer: "| ' . $data1['ArtistName'] . '"';
                                    if ($x < $numrows) {
                                        echo '},';
                                    } else {
                                        echo '}';
                                    }


                                    $song = $data1['idSong'];



                                    $query3 = "INSERT INTO `listentosong` (`idListener`, `idSong`, `DurationListenedTo`) 
                    VALUES ('$listenerid', '$song', '1.0') ";
                                    $result3 = $mysqli->query($query3);
                                    if (!$result3) {
                                        echo $mysqli->error;
                                    }

                                    $x++;
                                }
                            }
                        }
                    }
                }
            } else {
                $playsong = $_POST['play-id-song'];


                $query = "SELECT `song`.*, `artist`.`ArtistName`
FROM `artist`, `song`, `createsong`
WHERE `artist`.`idArtist` = `createsong`.`idArtist` 
AND `createsong`.`idSong` = `song`.`idSong` 
AND `song`.`idSong` = '$playsong'";

                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {

                        $data = $result->fetch_array();
                        echo '{';
                        echo 'name: "' . $data['Name'] . ' |",';
                        echo 'path: "song/' . $data['idSong'] . '.mp3",';
                        echo 'img: "songimg/' . $data['idSong'] . '.jpg",';
                        echo 'singer: "| ' . $data['ArtistName'] . '"';
                        echo '}';

                        $song = $data['idSong'];



                        $query2 = "INSERT INTO `listentosong` (`idListener`, `idSong`, `DurationListenedTo`) 
VALUES ('$listenerid', '$song', '1.0') ";
                        $result2 = $mysqli->query($query2);
                        if (!$result2) {
                            echo $mysqli->error;
                        }
                    }
                }
            }
            ?>
        ];


        // All functions

        // function load the track
        function load_track(index_no) {
            clearInterval(timer);
            reset_slider();

            track.src = All_song[index_no].path;
            title.innerHTML = All_song[index_no].name;
            track_image.src = All_song[index_no].img;
            artist.innerHTML = All_song[index_no].singer;
            track.load();

            timer = setInterval(range_slider, 1000);
        }

        load_track(index_no);


        //mute sound function
        function mute_sound() {
            track.volume = 0;
            volume.value = 0;
            volume_show.innerHTML = 0;
        }


        // checking.. the song is playing or not
        function justplay() {
            if (Playing_song == false) {
                playsong();

            } else {
                pausesong();
            }
        }


        // reset song slider
        function reset_slider() {
            slider.value = 0;
        }

        // play song
        function playsong() {
            track.play();
            Playing_song = true;
            play.innerHTML = '<i class="fa fa-pause" aria-hidden="true"></i>';
        }

        //pause song
        function pausesong() {
            track.pause();
            Playing_song = false;
            play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
        }


        // next song
        function next_song() {
            play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
            if (index_no < All_song.length - 1) {
                index_no += 1;
                load_track(index_no);
                playsong();

            } else {
                index_no = 0;
                load_track(index_no);
                playsong();
            }
        }


        // previous song
        function previous_song() {
            play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
            if (index_no > 0) {
                index_no -= 1;
                load_track(index_no);
                playsong();

            } else {
                index_no = All_song.length;
                load_track(index_no);
                playsong();
            }
        }


        // change volume
        function volume_change() {
            volume_show.innerHTML = recent_volume.value;
            track.volume = recent_volume.value / 100;
        }

        // change slider position 
        function change_duration() {
            slider_position = track.duration * (slider.value / 100);
            track.currentTime = slider_position;
        }

        // autoplay function
        function autoplay_switch() {
            if (autoplay == 1) {
                autoplay = 0;
                auto_play.style.background = "rgba(255,255,255,0.2)";
            } else {
                autoplay = 1;
                auto_play.style.background = "#FF8A65";
            }
        }


        function range_slider() {
            let position = 0;

            // update slider position
            if (!isNaN(track.duration)) {
                position = track.currentTime * (100 / track.duration);
                slider.value = position;
            }

            // function will run when the song is over
            if (track.ended) {
                play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
                if (autoplay == 1) {
                    index_no += 1;
                    load_track(index_no);
                    playsong();
                }
            }
        }
    </script>
</body>

</html>