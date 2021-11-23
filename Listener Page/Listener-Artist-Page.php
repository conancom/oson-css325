<?php
session_start();
$listenerid = $_SESSION['id-listener'];
$mysqli = new mysqli("localhost", "root", null, "oson-v2");

if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
} else {
    $query = "SELECT fart.*, art.* FROM followarist fart, artist art WHERE fart.idArtist = art.idArtist AND fart.idListener = "  . $_SESSION['id-listener'];
    $followartist_result = $mysqli->query($query);
}

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="Stylesheet" href="Listener-Artist-Page-Styling.css">
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
                        <div class="ArtistsContainer">
                            <h3 style="color: white; padding: 20px; font-size: 35px;">
                                Artists
                            </h3>
                            <div class="row">
                                <?php
                                if ($followartist_result) {
                                    $index = 0;
                                    while ($followartist = $followartist_result->fetch_array()) {
                                ?>
                                        <div class="col-md-3">
                                            <div class="row Artist-Pic">
                                                <a href="Listener-Artist-Profile-Page.php?idArtist=<?php echo $followartist['idArtist'] ?>">
                                                    <img width="250" height="250" src="<?php echo 'profileimg/' . $followartist['idArtist'] . '.jpg' ?>" alt="Artist Picture"></a>
                                            </div>
                                            <div class="row Artist-Name">
                                                <a href="Listener-Artist-Profile-Page.php?idArtist=<?php echo $followartist['idArtist'] ?>">
                                                    <h3 style="text-align: center;"><?php echo $followartist['ArtistName'] ?></h3>
                                                </a>
                                            </div>
                                            <div class="row Artist-Type">
                                                <p style="text-align: center;">Artists</p>
                                            </div>
                                        </div>
                                <?php }
                                } ?>



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
</body>

</html>