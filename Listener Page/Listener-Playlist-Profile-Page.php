<<<<<<< HEAD
<?php
session_start();

$mysqli = new mysqli("localhost", "root", null, "oson-v2");
$query = "SELECT `PlaylistName` FROM `playlist` WHERE idPlaylist = " . $_GET['idPlaylist'];
$result = $mysqli->query($query);
$pl = $result->fetch_array();

$query = "SELECT * FROM `consistplaylist` WHERE idPlaylist = " . $_GET['idPlaylist'];
$playlist_eles = $mysqli->query($query);

=======
<?php 
    session_start();
    $mysqli = new mysqli("localhost", "root", null, "oson-v2");

    $id_playlist = $_GET['idPlaylist'];
    $query = "SELECT `PlaylistName` FROM `playlist` WHERE idPlaylist = " . $id_playlist;
    $result = $mysqli->query($query);
    $pl = $result->fetch_array();
  
>>>>>>> d18ae39fc157e4dae04aa8295d7ff3077a8cbd84
?>

<!DOCTYPE html>

<html>

<head>

    <link rel="Stylesheet" href="Listener-Playlist-Profile-Styling.css">

    <!--Bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--Icons-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                        <ion-icon name="search-outline"></ion-icon>
                        Album
                    </p>
                </a>
                <a href="Listener-Settings-Page.html">
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
                                $query = "SELECT cp.*, s.*, cs.*, art.*, al.AlbumName FROM consistplaylist cp, song s, createsong cs, artist art 
                                WHERE s.idSong = cp.idSong AND cs.idSong = s.idSong AND cs.idArtist = art.idArtist AND cp.idPlaylist = " . $id_playlist;
                                // $query = "SELECT cp.*, s.* FROM consistplaylist cp, song s WHERE s.idSong = cp.idSong AND cp.idPlaylist = " . $id_playlist;
                                $playlist_eles = $mysqli->query($query);
                                print_r($playlist_eles);
                            ?>
                        

                            <div class="col-md-3">
                                <img src="Images/playlist-cover.jpg" style="clip-path: circle(36.9% at 50% 50%); width: 55%;">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <h1>
                                        <?php echo $pl['PlaylistName'] ?>
                                    </h1>
                                </div>

                                <div class="row">
                                    <h1>
                                        <?php echo $playlist_eles->num_rows?> Songs
                                    </h1>
                                </div>

                                <div class="row g-0">
                                    <div class="col FollowButton ">
                                        <button style="background-color: #FF7315; border: none; padding: 10px 30px; border-radius: 10px;">Follow</button>
                                    </div>
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
<<<<<<< HEAD
                        if ($playlist_eles) {
                            $index = 0;
                            while ($ele = $playlist_eles->fetch_array()) {
                                $query = "SELECT * FROM `song` WHERE idSong = " . $ele['idSong'];
                                $song = $mysqli->query($query);
                                $song = $song->fetch_array();
                        ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><?php echo $song['Name'] ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <p><?php echo $song['Popularity'] ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <p><?php echo $song['Duration'] ?></p>
                                    </div>
=======
                            if ($playlist_eles) {
                                $index = 0;
                                while ($row = $playlist_eles->fetch_array()) {                       
                        ?>

                            <div class="row">
                                <div class="col-md-2">
                                    <p><?php echo $index+1?></p>
                                </div>
                                <div class="col-md-2">
                                    <p><?php echo $row['Name']?></p>
                                </div>
                                <div class="col-md-2">
                                    <!-- <?php
                                    $query = "SELECT COUNT(cal.Consiste)"
                                    $playlist_eles = $mysqli->query($query);
                                    print_r($playlist_eles);
                                    ?> -->
                                    <p><?php echo $row['AlbumName']?></p>
                                </div>
                                <div class="col-md-2">
                                    <p><?php echo $row['ArtistName']?></p>
                                </div>
                                <div class="col-md-2">
                                    <p><?php echo $row['Popularity']?></p>
                                </div>
                                <div class="col-md-2">
                                    <p><?php echo $row['Explicity']?></p>
>>>>>>> d18ae39fc157e4dae04aa8295d7ff3077a8cbd84
                                </div>
                                <hr>

                        <?php
<<<<<<< HEAD
                            }
                        }
=======
                                $index++;
                                }
                            } 
>>>>>>> d18ae39fc157e4dae04aa8295d7ff3077a8cbd84
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

    <div class="Trackbar" style="position: fixed;">
        <div class="row">
            <div class="col">
                <div class="music-control">
                    <p>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="play-skip-back-outline"></ion-icon>
                        </a>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="play-outline"></ion-icon>
                        </a>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="play-skip-forward-outline"></ion-icon>
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-8">
                <div class="row">
                    <div class="music-data">
                        <div>
                            <p class="Song-name">Lucid Dreams | Juice WRLD </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="music-progressbar">
                        <div class="bar">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="music-option">
                    <p>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="shuffle-outline"></ion-icon>
                        </a>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="swap-horizontal-outline"></ion-icon>
                        </a>
                        <a href="#" style="text-decoration: none;">
                            <ion-icon name="volume-high-outline"></ion-icon>
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>