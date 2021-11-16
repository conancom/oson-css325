<?php 
    session_start();

    $mysqli = new mysqli("localhost", "root", null, "oson-v0");
    $query = "SELECT `AlbumName` FROM `album` WHERE idAlbum = " . $_GET['idAlbum'];
    $result = $mysqli->query($query);
    $al = $result->fetch_array();
  
    $query = "SELECT * FROM `consistalbum` WHERE idAlbum = " . $_GET['idAlbum'];
    $album_eles = $mysqli->query($query);
    
?>

<!DOCTYPE html>

<html>

<head>

    <link rel="Stylesheet" href="Listener-Album-Profile-Styling.css">

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
                <a href="#" style="color: white;">
                    <p>
                        <ion-icon name="home-outline"></ion-icon>
                        Home
                    </p>
                </a>
                <a href="#" style="color: white;">
                    <p>
                        <ion-icon name="search-outline"></ion-icon>
                        Search
                    </p>
                </a>
                <a href="#" style="color: white;">
                    <p>
                        <ion-icon name="reorder-four-outline"></ion-icon>
                        Playlist
                    </p>
                </a>
                <a href="#" style="color: white;">
                    <p>
                        <ion-icon name="search-outline"></ion-icon>
                        Album
                    </p>
                </a>
                <a href="#" style="color: white;">
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
                            <div class="col-md-3">
                                <img src="Images/Lisa.jfif" style="clip-path: circle(36.9% at 50% 50%); width: 55%;">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <h1>
                                        <?php echo $al['AlbumName']?>
                                    </h1>
                                </div>

                                <div class="row">
                                    <h1>
                                        4269 Followers
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
                            <h1> Album </h1>
                        </div>
                        <!---------------------------------------------------------------------------------------------------->
                        <?php
                            if ($album_eles) {
                                $index = 0;
                                while ($ele = $album_eles->fetch_array()) {    
                                    $query = "SELECT * FROM `song` WHERE idSong = " . $ele['idSong'];
                                    $song = $mysqli->query($query);
                                    $song = $song->fetch_array();                            
                        ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <p><?php echo $song['Name']?></p>
                                </div>

                                <div class="col-md-3">
                                    <p><?php echo $song['Popularity']?></p>
                                </div>

                                <div class="col-md-3">
                                    <p><?php echo $song['Duration']?></p>
                                </div>
                            </div>
                            <hr>

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