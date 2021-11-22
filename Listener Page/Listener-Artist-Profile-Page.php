<?php
session_start();
$listenerid = $_SESSION['id-listener'];

$mysqli = new mysqli("localhost", "root", null, "oson-v2");

if (isset($_GET['idArtist'])) {
    $artistid = $_GET['idArtist'];
    $query = "SELECT * FROM `artist` WHERE idArtist = " . $artistid;
}

?>

<!DOCTYPE html>

<html>

<head>

    <link rel="Stylesheet" href="Listener-Artist-Profile-Page-Styling.css">

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
                                            <button name="follow-album" style="background-color: #FF7315; border: none; padding: 10px 30px; border-radius: 10px;">
                                                <?php if ($data['ISFOLLOW'] == 0) {
                                                    echo "Follow";
                                                } else {
                                                    echo "Unfollow";
                                                } ?>
                                            </button>
                                        </form>
                                        <?php
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
                                    </div>

                                    <div class="col FollowButton ">
                                        <form action="#don" method="post">
                                            <button name="donate" style="background-color: #FF7315; border: none; padding: 10px 30px; border-radius: 10px;">
                                                Donate
                                            </button>
                                        </form>
                                        <?php
                                        if (isset($_POST['donate'])) {

                                            $insert_donate = sprintf("INSERT INTO `donatetoartist`(`idListener`, `idArtist`, `Amount`, `CreditCardInformatio`) VALUES (%d, %d, %f, '%s')", $listenerid, $artistid, 9.99, "VISA-xxx09436552");
                                            $result = $mysqli->query($insert_donate);
                                            if (!$result) {
                                                echo $mysqli->error;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!---------------------------------------------------------------------------------------------------->

                        <div class="row">
                            <h1>Top Songs From <?php echo $art['ArtistName'] ?></h1>
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
                            $query = "SELECT * FROM `song` WHERE idSong = " . $ele['idSong'] ;
                            $song = $mysqli->query($query);
                            $song = $song->fetch_array();
                        ?>
                            <div class="row">
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
                                        <button type="submit" name="first-hit">+PL</button>
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
                                                    <button name="add-to-playlist" type="submit">
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
                                while($album = $result-> fetch_array()) {
                            ?>

                            <div class="col-md-3">

                                <div class="row Artist-Pic">
                                    <a href="Listener-Album-Profile-Page.php?idAlbum=<?php echo $album['idAlbum'] ?>">
                                        <img width="250" height="250" src="<?php echo 'albumimg /' . $album['idAlbum'] . '.jpg'; ?>" alt="Album Picture" style="padding-bottom: 20px;"></a>
                                </div>
                                <div class="row Artist-Name">
                                    <a href="Listener-Album-Profile-Page.php?idAlbum=<?php echo $album['idAlbum'] ?>">
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