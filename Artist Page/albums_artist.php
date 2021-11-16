<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");


if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}


?>

<!DOCTYPE html>
<!--Font-->
<link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">
<html>

<head>
    <title>Album List</title>
    <link rel="stylesheet" href="lists_artist.css">
</head>



<body>

    <nav class="menu_head">
        <div class="menu_button_group">
            <a href="home_artist.php">Home</a>
            <a href="songs_artist.php">Songs</a>
            <a href="">Albums</a>
            <a href="editprofile_artist.php">Settings</a>
        </div>
    </nav>
    <div class="wrapper_main">
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
                echo '</div>';
                echo '<div class="header_details">';
                echo '<h1>' . $data["ArtistName"] . ' Album List</h1>';
            }
        }
        ?>
        <div class="duobutton">
            <button type="button" class="button_orange" onclick="location.href='addnewalbum_artist.php'">Create new Album</button>
            <select name="order by" class="button_orange">
            </select>
        </div>
    </div>

    <table class="songtable">
        <tr>
            <th>Album Number</th>
            <th>Album Name</th>
            <th>Genre</th>
            <th>Followers</th>
            <th>Explicity</th>
        </tr>
        <?php
        if (isset($_SESSION['id-artist'])) {
            $idartist = $_SESSION['id-artist'];

            $query = "SELECT *
            FROM `artist`,`Album`
            WHERE `artist`.`idArtist` = '$idartist' 
            AND `artist`.`idArtist` = `Album`.`idArtist`
            ORDER BY `Album`.`idAlbum` DESC";
            // print($query); 
            $result = $mysqli->query($query);
            if (!$result) {
                echo $mysqli->error;
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $x = 1;
                    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
                        echo '<tr>';
                        echo '<td> ' .$data['idAlbum']. '</td>';
                        echo '<td> <a href="editalbums_artists.php?id='.$data['idAlbum'].'">' .$data['AlbumName']. '</td>';
                        echo '<td>' .$data['Genre']. '</td>';
                        echo '<td>' .$data['AmountOfFollower']. '</td>';
                        echo '<td>' .$data['Explicity']. '</td>';
                        echo '</tr>';
                    }
                }
            }
        } ?>
        


    </table>

    </div>
    <div id="div_footer">



    </div>
</body>

</html>