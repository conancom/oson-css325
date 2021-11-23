<?php
session_start();
$listenerid = $_SESSION['id-listener'];

$mysqli = new mysqli("localhost", "root", null, "oson-v2");

if (isset($_GET['idAlbum'])) {
    $albumid = $_GET['idAlbum'];
    $query = "SELECT * FROM `album` WHERE idAlbum = " . $albumid;
}

if (isset($_POST['follow-album']) && isset($_POST['is-follow'])) {
    // $check_if_exist = "";
    if ($_POST['is-follow'] == 0) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $follow_q = sprintf("INSERT INTO `followalbum`(`idListener`, `idAlbum`, `FollowDate`, `FollowTime`) VALUES(%d, %d, '%s', '%s')", $listenerid, $albumid, $date, $time);
        echo $follow_q;
        $result = $mysqli->query($follow_q);
        if (!$result) {
            echo $mysqli->error;
        } else {
            header("Location: Listener-Album-Profile-Page.php?idAlbum=" . $albumid);
        }
    } else {
        $unfollow_q = sprintf("DELETE FROM `followalbum` WHERE `idListener` = %d AND `idAlbum` = %d", $listenerid, $albumid);
        echo $unfollow_q;
        $result = $mysqli->query($unfollow_q);
        if (!$result) {
            echo $mysqli->error;
        } else {
            header("Location: Listener-Album-Profile-Page.php?idAlbum=" . $albumid);
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <link rel="Stylesheet" href="Listener-Album-Profile-Styling.css">
    <link rel="Stylesheet" type="text/css" href="Trackbar-Styling.css">
    <link rel="Stylesheet" type="text/css" href="Listener-Main-Page-Styling.css">

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
                        <ion-icon name="albums-outline"></ion-icon></ion-icon>
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
                    <div class="ArtistContainer">
                        <div class="row">
                            <?php
                            $query = "SELECT COUNT(fa.`FollowAlbumid`) as NUMFOLLOWER, a.*, art.ArtistName, art.idArtist FROM `album` a, `followalbum` fa, `artist` art WHERE a.idArtist = art.idArtist AND fa.`idAlbum` = a.`idAlbum` AND a.`idAlbum` = " . $albumid;
                            // $query = "SELECT * FROM `album` WHERE idAlbum = " . $albumid;
                            $result = $mysqli->query($query);
                            $al = $result->fetch_array();
                            ?>

                            <div class="col-md-3">
                                <img src="<?php echo "albumimg/" . $al['idAlbum'] . ".jpg" ?>" style="clip-path: circle(36.9% at 50% 50%); width: 55%;">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <h1>
                                        <?php echo $al['AlbumName'] ?>
                                    </h1>
                                </div>
                                <div class="row">
                                    <a href="<?php echo "Listener-Artist-Profile-Page.php?idArtist=".$al['idArtist']?>"><p>
                                        <?php echo $al['ArtistName'] ?>
                                    </p></a>
                                </div>

                                <div class="row">

                                    <p>
                                        <?php echo  $al['NUMFOLLOWER']; ?> Followers
                                    </p>
                                </div>

                                <div class="row g-0">
                                    <div class="col FollowButton ">
                                        <?php
                                        // $query = sprintf("SELECT COUNT(*) ISFOLLOW FROM `followalbum` WHERE `idListener` = %d AND `idAlbum` = %d", $listenerid, $albumid);
                                        $query = sprintf("SELECT COUNT(*) ISFOLLOW, art.* FROM `followalbum` fa, `album` al, `artist` art 
                                            WHERE fa.`idListener` = %d AND fa.`idAlbum` = %d AND al.`idAlbum` = fa.`idAlbum` AND al.`idArtist` = art.`idArtist`", $listenerid, $albumid);
                                        $result = $mysqli->query($query);
                                        $data = $result->fetch_array();

                                        ?>
                                        <form action="#fllw" method="post">
                                            <input type="hidden" name="is-follow" value="<?php echo $data['ISFOLLOW'] ?>">
                                            <button name="follow-album" class="FollowBtn" style="border: none; padding: 10px 30px; border-radius: 10px;">
                                                <?php if ($data['ISFOLLOW'] == 0) {
                                                    echo "Follow";
                                                } else {
                                                    echo "Unfollow";
                                                } ?>
                                            </button>
                                        </form>
                                        <?php
                                        // if (isset($_POST['follow-album']) && isset($_POST['is-follow'])) {
                                        //     // $check_if_exist = "";
                                        //     if ($_POST['is-follow'] == 0) {
                                        //         $date = date('Y-m-d');
                                        //         $time = date('H:i:s');
                                        //         $follow_q = sprintf("INSERT INTO `followalbum`(`idListener`, `idAlbum`, `FollowDate`, `FollowTime`) VALUES(%d, %d, '%s', '%s')", $listenerid, $albumid, $date, $time);
                                        //         echo $follow_q;
                                        //         $result = $mysqli->query($follow_q);
                                        //         if (!$result) {
                                        //             echo $mysqli->error;
                                        //         } else {
                                        //             header("Location: Listener-Album-Profile-Page.php?idAlbum=" . $albumid);
                                        //         }
                                        //     } else {
                                        //         $unfollow_q = sprintf("DELETE FROM `followalbum` WHERE `idListener` = %d AND `idAlbum` = %d", $listenerid, $albumid);
                                        //         echo $unfollow_q;
                                        //         $result = $mysqli->query($unfollow_q);
                                        //         if (!$result) {
                                        //             echo $mysqli->error;
                                        //         } else {
                                        //             header("Location: Listener-Album-Profile-Page.php?idAlbum=" . $albumid);
                                        //         }
                                        //     }
                                        // }
                                        ?>
                                    </div>

                                    <div class="col FollowButton ">
                                        <form action="#don" method="post">
                                            <input type="hidden" name="id-artist" value="<?php echo $albumid ?>">
                                            <button name="donate" style="border: none; padding: 10px 30px; border-radius: 10px;" class="Donate">
                                                Donate
                                            </button>
                                        </form>
                                        <?php
                                        if (isset($_POST['donate'])) {
                                            // echo 'idArtist =====' . $data['idArtist'];
                                            $insert_donate = sprintf("INSERT INTO `donatetoartist`(`idListener`, `idArtist`, `Amount`, `CreditCardInformatio`) VALUES (%d, %d, %f, '%s')", $listenerid, $data['idArtist'], 9.99, "VISA-xxx09436552");
                                            // echo $insert_donate;
                                            $result = $mysqli->query($insert_donate);
                                            if (!$result) {
                                                echo $mysqli->error;
                                            }
                                            // else { header("Location: Listener-Album-Profile-Page.php?idAlbum=" . $albumid); }
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!---------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <h1> Album </h1>
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
                        $query = "SELECT * FROM `consistalbum` WHERE idAlbum = " . $albumid;
                        $album_eles = $mysqli->query($query);
                        if ($album_eles) {
                            $index = 0;
                            while ($ele = $album_eles->fetch_array()) {
                                $query = "SELECT * FROM `song` WHERE idSong = " . $ele['idSong'];
                                $song = $mysqli->query($query);
                                $song = $song->fetch_array();
                        ?>
                                <!-- <a href="Listener-Album-Profile-Page.php?play_idSong=<?php echo $song['idSong'] ?>&idAlbum=<?php echo $albumid ?>"> -->
                                <div class="row">
                                    <!-- <form action="Listener-Main-Page.php" method="post"> -->
                                    <div class="col-md-3">
                                        <p><?php echo $song['Name'] ?></p>
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

                                                if ($if_exist['SONG_EXIST'] == 0) {
                                                    $insert = sprintf("INSERT INTO `consistplaylist`(`idSong`, `idPlaylist`, `CreationTimeStamp`) VALUES (%d, %d, NOW())", $_POST['add-id-song-2-pl'], $_POST['id-playlist']);
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
                                            <button type="submit" name="first-hit" class="AddToPlaylistButton">+PL</button>
                                        </form>

                                        <?php


                                        if (isset($_POST['first-hit'])) {
                                            // echo "sddss";
                                            // echo $_POST['add-id-song'];
                                            if ($_POST['add-id-song'] == $song['idSong']) {
                                                $query_pl = "SELECT * FROM `playlist` WHERE `idListener` =" . $listenerid;
                                                $result = $mysqli->query($query_pl);
                                                while ($row = $result->fetch_array()) {
                                        ?>
                                                    <form action="##" method="post">
                                                        <input type="hidden" name="id-playlist" value=<?php echo $row['idPlaylist'] ?>>
                                                        <input type="hidden" name="add-id-song-2-pl" value=<?php echo $_POST['add-id-song'] ?>>
                                                        <button name="add-to-playlist" type="submit">
                                                            <p><?php echo $row['PlaylistName'] ?></p>
                                                        </button>
                                                    </form>
                                                    <!-- <a href="Listener-Main-Page.php"><p><?php echo $row['PlaylistName'] ?></p></a> -->
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>

                                    <!-- <button id="<?php echo 'play-this-song-' . $song['idSong'] ?>" onclick="alert('Clicked!!!')" type="submit" name="play-this-song-from-other-page"> HIDDEN BUTTON </button> -->
                                    <!-- </form> -->
                                </div>
                        <?php
                            }
                        }
                        ?>

                        <!---------------------------------------------------------------------------------------------------->

                        <!---------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
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

                            $x++;
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