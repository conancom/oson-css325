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

    <body>
        <div class="row">
            <div class="columntest-side">
                <div class="Sidebar" style="position: fixed;">
                    <a href="#">
                        <p>
                            <ion-icon name="home-outline"></ion-icon>
                            Home
                        </p>
                    </a>
                    <a href="#">
                        <p>
                            <ion-icon name="search-outline"></ion-icon>
                            Search
                        </p>
                    </a>
                    <a href="#">
                        <p>
                            <ion-icon name="reorder-four-outline"></ion-icon>
                            Playlist
                        </p>
                    </a>
                    <a href="#">
                        <p>
                            <ion-icon name="search-outline"></ion-icon>
                            Album
                        </p>
                    </a>
                    <a href="#">
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
                                        <img width="250" height="250" src="<?php echo 'profileimg/'.$followartist['idArtist'].'.jpg'?>" alt="Artist Picture"></a>
                                    </div>
                                    <div class="row Artist-Name">
                                        <a href="Listener-Artist-Profile-Page.php?idArtist=<?php echo $followartist['idArtist'] ?>">
                                        <h3 style="text-align: center;"><?php echo $followartist['ArtistName'] ?></h3></a>
                                    </div>
                                    <div class="row Artist-Type">
                                        <p style="text-align: center;">Artists</p>
                                    </div>
                                </div>
                                <?php }} ?>

                                

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
                            <a href="#">
                                <ion-icon name="play-skip-back-outline"></ion-icon>
                            </a>
                            <a href="#">
                                <ion-icon name="play-outline"></ion-icon>
                            </a>
                            <a href="#">
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
                            <a href="#">
                                <ion-icon name="shuffle-outline"></ion-icon>
                            </a>
                            <a href="#">
                                <ion-icon name="swap-horizontal-outline"></ion-icon>
                            </a>
                            <a href="#">
                                <ion-icon name="volume-high-outline"></ion-icon>
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </body>
</body>

</html>