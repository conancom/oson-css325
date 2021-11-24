<?php
session_start();
$mysqli = new mysqli("localhost", "root", '', "oson-v2");
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}
if (isset($_SESSION['id-listener'])) {
    $listenerid = $_SESSION['id-listener'];
    $query = "SELECT `idListener`, `UserEmail`, `Gender`, `UserName`, `UserDateOfBirth`, `PreferredGenre`, `Country`FROM `listener` WHERE `idListener` = " . $listenerid;
    $result = $mysqli->query($query);
    if ($result) {
        $data = $result->fetch_array();
        //print_r($data);
    }else{
        echo $mysqli->error;
    }
}
if (isset($_POST['submit-edit']) and isset($_SESSION['id-listener'])) {

    $emailaddress = $_POST['emailaddress'];

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = $data['UserPassword'];
    }
    $username = $_POST['username'];
    $genre = $_POST['genre'];

    $query2 = "UPDATE `listener` SET 
    `UserEmail` = '$emailaddress',
     `UserPassword` = '$password',
      `UserName` = '$username ',
       `PreferredGenre` = '$genre' 
       WHERE `listener`.`idListener` = '$listenerid';";
    $result2 = $mysqli->query($query2);
    if ($result2) {

        header("Location: Listener-Main-Page.php");
        //print_r($data);
    }
}

?>


<!DOCTYPE html>

<html>

<head>
    <link rel="Stylesheet" href="Listener-Settings-Page-Styling.css">
    <link rel="Stylesheet" href="register.css">
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
                <div class="Recents">
                    <div class="PlaylistContainer">
                        <h3 class="Username" style="color: white; padding: 20px; font-size: 35px;">
                            <?php

                            echo $data['UserName'] . "'s Profile";

                            ?>
                        </h3>
                        <div class="row">
                            <div class="div_content" class="form">

                                <form name="listener-edit" method="POST">
                                    <div class="text_wrapper">
                                        <label class="text_email">Email Address</label>
                                    </div><br>
                                    <input style="text-indent: 4px; padding: 15px; font-family: 'Kanit', sans-serif;" type="text" name="emailaddress" class="text_field" placeholder=" Email Address" value=<?php
                                                                                                                                                                                                            echo '"' . $data['UserEmail'] . '"';
                                                                                                                                                                                                            ?>><br>

                                    <div id="text_wrapper">
                                        <label class="text_pw">Password</label>
                                    </div>
                                    <input style="text-indent: 4px; padding: 15px; font-family: 'Kanit', sans-serif;" type="password" name="password" id='passwordEdit' class="text_field" placeholder=" ***********" disabled /><br>
                                    <br>

                                    <div class="row no-gutter g-1" style="position: relative;">
                                        <div class="col-2">
                                            <label class="ChangePass" style="color: white;">Change Password</label>
                                        </div>

                                        <div class="col-2">
                                            <button type="button" class="ChangePasswordButton" onclick="document.getElementById('passwordEdit').disabled = false;">Change</button>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="text_wrapper">
                                        <label class="text_username">Username</label>
                                    </div><br>

                                    <input style="text-indent: 4px; padding: 15px; font-family: 'Kanit', sans-serif;" type="text" name="username" class="text_field" placeholder=" Username" value=<?php
                                                                                                                                                                                                    echo '"' . $data['UserName'] . '"';
                                                                                                                                                                                                    ?>><br>

                                    <div class="text_wrapper">
                                        <label class="country_text"> &#160&#160 &#160&#160 &#160&#160 &#160&#160 &#160&#160Preferred Genre</label>
                                    </div><br>
                                    <select name="genre" class="countrybox" style="font-family: 'Kanit', sans-serif;">
                                        <option>-</option>
                                        <option value="pop" <?php
                                                            if ($data['PreferredGenre'] == 'pop') {
                                                                echo ' selected';
                                                            }
                                                            ?>>Pop</option>
                                        <option value="rap" <?php
                                                            if ($data['PreferredGenre'] == 'rap') {
                                                                echo ' selected';
                                                            }
                                                            ?>>Rap</option>
                                        <option value="edm" <?php
                                                            if ($data['PreferredGenre'] == 'edm') {
                                                                echo ' selected';
                                                            }
                                                            ?>>EDM</option>
                                        <option value="rock" <?php
                                                                if ($data['PreferredGenre'] == 'rock') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Rock</option>
                                        <option value="randb" <?php
                                                                if ($data['PreferredGenre'] == 'randb') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>R&B</option>
                                        <option value="jazz" <?php
                                                                if ($data['PreferredGenre'] == 'jazz') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Jazz</option>
                                        <option value="metal" <?php
                                                                if ($data['PreferredGenre'] == 'metal') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Metal</option>
                                        <option value="soul" <?php
                                                                if ($data['PreferredGenre'] == 'soul') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Soul</option>
                                        <option value="raggae" <?php
                                                                if ($data['PreferredGenre'] == 'raggae') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Raggae</option>
                                        <option value="classical" <?php
                                                                    if ($data['PreferredGenre'] == 'classical') {
                                                                        echo ' selected';
                                                                    }
                                                                    ?>>Classical</option>
                                        <option value="soundtracks" <?php
                                                                    if ($data['PreferredGenre'] == 'soundtracks') {
                                                                        echo ' selected';
                                                                    }
                                                                    ?>>Soundtracks</option>
                                        <option value="Country" <?php
                                                                if ($data['PreferredGenre'] == 'Country') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Country</option>
                                        <option value="blues" <?php
                                                                if ($data['PreferredGenre'] == 'blues') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Blues</option>
                                        <option value="folk" <?php
                                                                if ($data['PreferredGenre'] == 'folk') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Folk</option>
                                        <option value="indie" <?php
                                                                if ($data['PreferredGenre'] == 'indie') {
                                                                    echo ' selected';
                                                                }
                                                                ?>>Indie</option>

                                    </select><br>
                                    <div class="button">
                                        <input type="submit" name="submit-edit" value="Confirm Edit" class="button_orange confirmEdit">
                                    </div>

                                </form>

                                <div id="div_footer">

                                </div>

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