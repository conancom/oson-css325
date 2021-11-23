<?php
session_start();
$mysqli = new mysqli("localhost", "root", '', "oson-v2");
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}
if (isset($_SESSION['id-listener'])) {
    $listenerid = $_SESSION['id-listener'];
    $query = "SELECT `idListener`, `UserEmail`, `Gender`, `UserName`, `UserDateOfBirth`, `PreferredGenre`, `Country`, `profile_url` FROM `listener` WHERE `idListener` = " . $listenerid;
    $result = $mysqli->query($query);
    if ($result) {
        $data = $result->fetch_array();
        //print_r($data);
    }
}
if (isset($_POST['submit-edit']) and isset($_SESSION['id-listener'])) {

    $emailaddress = $_POST['emailaddress'];

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }else{
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
                                    <input type="text" name="emailaddress" class="text_field" placeholder=" Email Address" value=<?php
                                                                                                                                    echo '"' . $data['UserEmail'] . '"';
                                                                                                                                    ?>><br>

                                    <div id="text_wrapper">
                                        <label class="text_pw">Password</label>
                                    </div>
                                    <input type="password" name="password" id='passwordEdit' class="text_field" placeholder=" ***********" disabled /><br>
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

                                    <input type="text" name="username" class="text_field" placeholder=" Username" value=<?php
                                                                                                                        echo '"' . $data['UserName'] . '"';
                                                                                                                        ?>><br>

                                    <div class="text_wrapper">
                                        <label class="country_text" style="font-family: 'Kanit', sans-serif;"> &#160&#160 &#160&#160 &#160&#160 &#160&#160 &#160&#160Preferred Genre</label>
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