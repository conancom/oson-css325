<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "oson-v2");
$listenerid = $_SESSION['id-listener'];
$id_playlist = $_GET['idPlaylist'];
$query = "SELECT `PlaylistName` FROM `playlist` WHERE idPlaylist = " . $id_playlist;
$result = $mysqli->query($query);
$pl = $result->fetch_array();

if (isset($_POST['delete-playlist'])) {
    $delete = sprintf("DELETE FROM playlist WHERE idListener = %d AND idPlaylist = %d", $listenerid, $id_playlist);
    $result = $mysqli->query($delete);
    // echo $delete;
    if ($result) {
        header("Location: Listener-Playlist-Page.php");
    } else {
        echo $mysqli->error;
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="Stylesheet" type="text/css" href="Listener-Main-Page-Styling.css">
    <link rel="Stylesheet" href="Listener-Playlist-Profile-Styling.css">
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
                            $query = "SELECT cp.*, s.*, cs.*, art.* FROM consistplaylist cp, song s, createsong cs, artist art 
                                WHERE s.idSong = cp.idSong AND cs.idSong = s.idSong AND cs.idArtist = art.idArtist AND cp.idPlaylist = " . $id_playlist  . " ORDER BY s.Popularity DESC";
                            // $query = "SELECT cp.*, s.* FROM consistplaylist cp, song s WHERE s.idSong = cp.idSong AND cp.idPlaylist = " . $id_playlist;
                            $playlist_eles = $mysqli->query($query);
                            // print_r($playlist_eles);
                            ?>

                            <div class="col-md-3">
                                <img src="Images/playlist-cover.jpg" style="clip-path: circle(36.9% at 50% 50%); width: 55%;">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <?php
                                    if (isset($_POST['input-pl-name'])) {
                                        $update = sprintf("UPDATE `playlist` SET `PlaylistName`= '%s' 
                                        WHERE idPlaylist = %d  
                                        AND idListener = %d", $_POST['input-pl-name'], $id_playlist, $listenerid);
                                        $result = $mysqli->query($update);
                                        if (!$result) {
                                            echo "You are not the owner of this playlist.";
                                        }

                                        header("Refresh:0");
                                    }
                                    ?>
                                    <div>
                                        <form action="#ed" method="post">
                                            <?php
                                            if (isset($_POST['edit-pl-name'])) { ?>
                                                <input type="text" name="input-pl-name" style="text-indent: 10px;" value="<?php echo $pl['PlaylistName'] ?>"><?php
                                                                                                                                                            } else { ?>
                                                <h1><?php echo $pl['PlaylistName'] ?></h1><?php
                                                                                                                                                            }
                                                                                            ?>
                                            <!-- <input type="text" name="input-pl-name" value="<?php echo $pl['PlaylistName'] ?>">
                                        <h1><?php echo $pl['PlaylistName'] ?></h1> -->


                                            <button type="submit" name="edit-pl-name" class="EditButton" style="margin-top: 15px; margin-bottom: 15px;">Edit</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <h1>
                                        <?php echo $playlist_eles->num_rows ?> Songs
                                    </h1>
                                </div>

                                <div class="row g-0">
                                    <!-- <div class="col FollowButton ">
                                        <button style="background-color: #FF7315; border: none; padding: 10px 30px; border-radius: 10px;">Follow</button>
                                    </div> -->
                                </div>
                                <p></p>
                                <div class="row g-0">

                                    <div class="col FollowButton ">
                                        <form action="#del" method="post">
                                            <button type="submit" name="delete-playlist" class="DeletePlaylistButton">Delete This Playlist</button>
                                        </form>
                                    </div>
                                    <?php
                                    $id_playlist = $_GET['idPlaylist'];
                                    $query = "SELECT * FROM `playlist` WHERE idPlaylist = " . $id_playlist;

                                    $result = $mysqli->query($query);
                                    if (!$result) {
                                        echo $mysqli->error;
                                    } else {
                                        if (mysqli_num_rows($result) > 0) {
                                            $data = $result->fetch_array();
                                            echo ' <form action="#fllw" method="post">';
                                            echo '<input type="hidden" name="start-play-id" value="' . $data['idPlaylist'] . '">';
                                            echo '<button type="submit" name="startplay" class="PlayAllBtn">Play';
                                            echo '</button>';
                                            echo '</form>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!---------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <h1> Playlist </h1>
                            <p></p>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p>Song Number</p>
                            </div>
                            <div class="col-md-2">
                                <p>Song Name</p>
                            </div>
                            <div class="col-md-2">
                                <p>Album Name</p>
                            </div>
                            <div class="col-md-2">
                                <p>Artist</p>
                            </div>
                            <div class="col-md-2">
                                <p>Popularity</p>
                            </div>
                            <div class="col-md-2">
                                <p>Expicit</p>
                            </div>
                        </div>
                        <hr>
                        <!---------------------------------------------------------------------------------------------------->
                        <?php
                        if ($playlist_eles) {
                            $index = 0;
                            while ($row = $playlist_eles->fetch_array()) {
                        ?>

                                <div class="row">
                                    <div class="col-md-2">
                                        <p><?php echo $index + 1 ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><?php echo $row['Name'] ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        $query = "SELECT COUNT(cal.ConsistAlbumId) as EXIST , cal.*, al.* FROM consistalbum cal, song s, album al
                                                WHERE cal.idSong = s.idSong AND cal.idAlbum = al.idAlbum AND s.idSong = " . $row['idSong'];
                                        $album_eles = $mysqli->query($query);
                                        //  print_r($playlist_eles);
                                        $al_temp = $album_eles->fetch_array();
                                        if ($al_temp['EXIST'] == 1) {
                                            echo '<p>' . $al_temp["AlbumName"] . '</p>';
                                        } else {
                                            echo '<p> - </p>';
                                        }
                                        ?>

                                    </div>
                                    <div class="col-md-2">
                                        <p><?php echo $row['ArtistName'] ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><?php echo $row['Popularity'] ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><?php echo $row['Explicity'] ?></p>
                                    </div>

                                    <hr>
                                </div>

                        <?php
                                // echo $index;
                                $index++;
                            }
                        }
                        ?>

                        <!---------------------------------------------------------------------------------------------------->

                        <!---------------------------------------------------------------------------------------------------->

                        <!-- <div class="row">
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            <div class="col-md-3"><img src="Images/Jam&Butterfly.JPG" alt="Album Picture"></div>
                            </div> -->

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
            if (!isset($_POST['startplay'])) {
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



                $playlist = $_POST['start-play-id'];


                $query = "SELECT `song`.*, `artist`.`ArtistName`
                FROM `artist`, `song`, `playlist`,`ConsistPlaylist`, `createsong`
                 WHERE  `playlist`.`idPlaylist` = `ConsistPlaylist`.`idPlaylist`
                 AND `ConsistPlaylist`.`idSong` = `Song`.`idSong`
                 AND  `playlist`.`idPlaylist`= '$playlist'
                 AND `artist`.`idArtist` = `createsong`.`idArtist`
                 AND `createsong`.`idSong` = `song`.`idSong`
                GROUP BY `song`.`idSong`;
            ";

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