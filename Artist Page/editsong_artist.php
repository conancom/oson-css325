<?php
session_start();
$mysqli = new mysqli("localhost", "root", 'Wirz140328', "oson-v2");
$songId  = $_GET['id'];
$idartist = $_SESSION['id-artist'];

if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}

if (isset($_POST['submit-edit']) and isset($_SESSION['id-artist'])) {


    $songname = $_POST['songname'];
    $genre = $_POST['genre'];
    $explicity = $_POST['Explicity'];
    $featuringartist = $_POST['featuringartist'];

    $query = "UPDATE `song` SET `Genre` = '$genre', `Name`='$songname', `Explicity` ='$explicity'
    WHERE `idSong` = '$songId';";
    $query1 = "SELECT `@LastUpdateID` AS 'LastUpdateID';";

    // print($query); 
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
    } else {


        $newestsongid = $songId;
        if(file_exists('songimg/' . $newestsongid . '.jpg')){
            unlink('songimg/' . $newestsongid . '.jpg');
        }
        move_uploaded_file($_FILES["my_file"]["tmp_name"], 'songimg/' . $newestsongid . '.jpg');
        if (isset($_POST['featuringartist'])) {
            $query3 = "INSERT `createsong`(idArtist, idSong , EntryOfArtist)
            VALUES ('$featuringartist','$newestsongid','0');";
            $insert3 = $mysqli->query($query3);

            if (!$insert3) {
                echo $mysqli->error;
            }
        }

        $query4 = "DELETE FROM `createsong` WHERE `createsong`.`idArtist` <>  '$featuringartist' AND `createsong`.`idSong` =  '$songId' 
        AND `createsong`.`idArtist` <>  '$idartist'";
        $delete = $mysqli->query($query4);
        if (!$delete) {
            echo $mysqli->error;
        }


        header("Location: songs_artist.php");
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title> Details Song</title>
    <link rel="stylesheet" href="lists_artist.css">
    <link rel="stylesheet" href="register.css">
</head>

<body>

    <section class="Header">
        <nav class="menu_head">
            <div class="menu_button_group">
                <a href="home_artist.php">Home</a>
                <a href="songs_artist.php">Songs</a>
                <a href="albums_artist.php">Albums</a>
                <a href="editprofile_artist.php">Settings</a>
            </div>
        </nav>

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
                    echo '<h1>' . $data["ArtistName"] . ' Edit Song</h1>';
                }
            }
            ?>
    </section>

    <div class="EditSongForm">
        <div id="wrapper">


            <?php
            if (isset($_SESSION['id-artist'])) {
                $idartist = $_SESSION['id-artist'];

                $query = "SELECT * FROM `song` WHERE `idSong` = '$songId'";
                // print($query); 
                $result = $mysqli->query($query);
                if (!$result) {
                    echo $mysqli->error;
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        $data = $result->fetch_array();
                        echo '<h1 style="text-align: center; margin-bottom: 19px;"> Edit ' . $data['Name'] . ' </h1>';
                    }
                }
            }
            ?>

            <div id="div_content" class="form">

                <form name="artist-login" action="#" method="post" enctype="multipart/form-data">
                    <div id="text_wrapper">
                        <label id="songname">Song Name</label>
                    </div>
                    <input type="text" name="songname" id="text_field" placeholder=" Song Name" step="padding-bottom: 15px;"><br>

                    <label style="padding-right: 155px; padding-bottom: 29px; ">Genre</label>
                    <label style="padding-bottom: 19px;">Explicity</label><br>
                    <select name="genre">
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
                    <select name="Explicity">
                        <option>-</option>
                        <option value='E'>Explitcit</option>
                    </select><br>


                    <div id="text_wrapper">
                        <label id="featuringartist">Featuring Arist</label>
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


                    <label>Cover Image</label>

                    <input type="file" name="my_file" />

                    <div class="button">
                        <input type="submit" name="submit-edit" value="Confirm Edit" style="margin-left: 25%; padding: 8px" class="button_orange"><br>
                        <button type="button" class="button_dark" onclick="location.href='songs_artist.php'" style="margin-left: 14%; padding: 8px"> Cancel </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>