<?php
session_start();
/*
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
*/
$mysqli = new mysqli("localhost", "root", '', "oson-v2");


if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}
if (isset($_POST["submit-newsong"])) {

    $songname = $_POST['songname'];
    $genre = $_POST['genre'];
    $explicity = $_POST['Explicity'];
    $album = $_POST['Album'];
    $featuringartist =  $_POST['featuringartist'];

    $query = "INSERT INTO `song`(`Duration`,`Genre`, `Name`, `Language`, `Popularity`, `Explicity`) 
    VALUES ('0', '$genre', '$songname', '-', '0', '$explicity');";

    //$query2 = "SELECT LAST_INSERT_ID();";
    //print $query;

    $insert = $mysqli->query($query);

    if (!$insert) {
        echo $mysqli->error;
    } else {
        $idartist = $_SESSION['id-artist'];
        $newestsongid = mysqli_insert_id($mysqli);
        move_uploaded_file($_FILES["my_file"]["tmp_name"], 'songimg/' . $newestsongid . '.jpg');
        move_uploaded_file($_FILES["my_song"]["tmp_name"], 'song/' . $newestsongid . '.mp3');
        $query2 = "INSERT `createsong`(idArtist, idSong , EntryOfArtist)
        VALUES ('$idartist','$newestsongid','0');";
        $insert2 = $mysqli->query($query2);

        if (!$insert2) {
            echo $mysqli->error;
        }
        if (isset($_POST['featuringartist'])) {
            $query3 = "INSERT `createsong`(idArtist, idSong , EntryOfArtist)
            VALUES ('$featuringartist','$newestsongid','0');";
            $insert3 = $mysqli->query($query3);

            if (!$insert3) {
                echo $mysqli->error;
            }
        }
        header("Location: songs_artist.php");
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Create New Song</title>
    <link rel="stylesheet" href="lists_artist.css">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="home_artist.css">

    <!--Bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</head>

<body style="background-color: rgba(44, 38, 38, 1);">

    <style>
        .menu_head a {
            cursor: pointer;
            transition: color 0.5s, background-color 0.2s, border-radius 0.5s;
        }

        .menu_head a:hover {
            position: relative;
            color: white;
            background-color: rgba(255, 115, 21, 0.5);
            border-radius: 10px;
        }

        .after-head {
            position: absolute;
            height: 250px;
            width: 100%;
            opacity: 0.5;
            z-index: -1;
        }

        .CancelButton {

            transition: background-color 0.5s, border-color 0.5s;
            cursor: pointer;
        }

        .CancelButton a {
            color: white;
            text-decoration: none;
        }

        .CreateNewSong {
            height: 200px;
            transition: background-color 0.5s, border-color 0.5s;
            cursor: pointer;
        }

        .CreateNewSong:hover,
        .CancelButton:hover {
            background-color: rgba(255, 115, 21, 1);
            border-color: rgba(255, 115, 21, 0.5);
        }
    </style>
    <section class="Header">
        <nav class="menu_head">
            <div class="menu_button_group">
                <a href="home_artist.php">Home</a>
                <a href="songs_artist.php">Songs</a>
                <a href="albums_artist.php">Albums</a>
                <a href="editprofile_artist.php">Settings</a>
            </div>
        </nav>

        <div class="after-head" style="background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(121,83,9,1) 26%, rgba(255,115,21,1) 94%);">

        </div>

        <div class="wrapper_main ">
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
                    echo "<h1>" . $data["ArtistName"] . "'s new Song</h1>";
                }
            }
            ?>
        </div>
        </div>
    </section>

    <div class="hrContainer">
        <hr class="horizontalLine">
    </div>

    <div class="AlbumForm">
        <div class="row">
            <div id="wrapper">
                <div id="div_content" class="form">
                    <form name="add-song" action="#" method="post" enctype="multipart/form-data">
                        <div id="text_wrapper">
                            <label id="songname" style="margin-bottom: 10px;">Song Name</label>
                        </div>

                        <input type="text " name="songname" id="text_field " placeholder=" Song Name " style="margin-bottom: 10px; width: 250px">

                        <br>

                        <label style="margin-right: 60%;">Genre</label>

                        <label style="margin-bottom: 10px;">Explicity</label>

                        <br>

                        <select name="genre" style="margin-right: 60px; margin-bottom: 10px; padding-right: 35px; width: 250px;">
                            <option>-</option>
                            <option value="pop">Pop</option>
                            <option value="rap">Rap</option>
                            <option value="edm">EDM</option>
                            <option value="rock">Rock</option>
                            <option value="randb">R&B</option>
                            <option value="jazz">Jazz</option>
                            <option value="metal">Metal</option>
                            <option value="soul">Soul</option>
                            <option value="raggae">Raggae</option>
                            <option value="classical">Classical</option>
                            <option value="soundtracks">Soundtracks</option>
                            <option value="Country">Country</option>
                            <option value="blues">Blues</option>
                            <option value="folk">Folk</option>
                            <option value="indie">Indie</option>
                        </select>
                        <select name="Explicity" style="padding-right: 75px; margin-bottom: 10px; ">
                            <option>-</option>
                            <option value='E'>Explitcit</option>
                        </select><br>
                        <label>Album</label><br>
                        <select name="Album" style="padding-right: 80px; margin-bottom: 10px; padding-right: 115px; width: 250px;">
                            <option>-</option>
                            <?php
                            if (isset($_SESSION['id-artist'])) {
                                $idartist = $_SESSION['id-artist'];

                                $query2 = "SELECT * 
                                FROM `artist`, `Album`
                                WHERE `artist`.`idArtist` = '$idartist' 
                                AND `Album`.`idArtist` = `artist`.`idArtist`;";
                                // print($query); 
                                $result2 = $mysqli->query($query2);
                                if (!$result2) {
                                    echo $mysqli->error;
                                } else {
                                    if (mysqli_num_rows($result2) > 0) {
                                        $x = 1;
                                        while ($data2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                                            echo '<option value="' . $data2['AlbumName'] . '">' . $data2['AlbumName'] . '</option>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </select><br>

                        <div id="text_wrapper ">
                            <label id="featuringartist" style="margin-bottom: 10px; ">Featuring Arist</label>

                        </div>
                        <select type="text " name="featuringartist" id="text_field " placeholder=" Featuring Arist " style="margin-bottom: 10px; width: 250px;">
                            <option>-</option>
                            <?php
                            if (isset($_SESSION['id-artist'])) {
                                $idartist = $_SESSION['id-artist'];

                                $query2 = "SELECT * 
                                FROM `artist`
                                WHERE `artist`.`idArtist` <> '$idartist' ;";
                                // print($query); 
                                $result2 = $mysqli->query($query2);
                                if (!$result2) {
                                    echo $mysqli->error;
                                } else {
                                    if (mysqli_num_rows($result2) > 0) {
                                        $x = 1;
                                        while ($data2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                                            echo '<option value="' . $data2['idArtist'] . '">' . $data2['ArtistName'] . '</option>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </select><br>

                        <label style="margin-right:100px; margin-bottom: 10px; ">Upload Song</label>
                        <input type="file" name="my_song" style="height: 40px;" /> Upload <br>
                        <label style="margin-right: 33px; margin-bottom: 70px; ">Upload Cover Image</label>
                        <input type="file" name="my_file" style="height: 40px;" /> Upload

                        <div class="button ">
                            <input type="submit" name="submit-newsong" value="Create new Song " class="button_orange CreateNewSong" style="margin-bottom: 20px; margin-left: 29%; height: 35px;"> Create new song</button><br>
                            <button type="button" class="button_dark CancelButton" style="margin-left: 19%; margin-bottom: 10px; " onclick="location.href='songs_artist.php'"><a href="home_artist.php"> Cancel </a></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>