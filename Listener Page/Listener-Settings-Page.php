<?php
    session_start();
    $mysqli = new mysqli("localhost", "root", '', "oson-v2");
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
    }
    $listenerid = $_SESSION['id-listener'];
    $query = "SELECT `idListener`, `UserEmail`, `Gender`, `UserName`, `UserDateOfBirth`, `PreferredGenre`, `Country`, `profile_url` FROM `listener` WHERE `idListener` = ". $listenerid;
    $result = $mysqli->query($query);
    if($result) { $data = $result->fetch_array(); print_r($data);}
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
                    <div class="PlaylistContainer">
                        <h3 class="Username" style="color: white; padding: 20px; font-size: 35px;">
                            Username
                        </h3>
                        <div class="row">
                            <div class="div_content" class="form">

                                <form name="listener-registration" action="Listener-Main-Page.html" method="post">
                                    <div class="text_wrapper">
                                        <label class="text_email">Email Address</label>
                                    </div><br>
                                    <input type="text" name="emailaddress" class="text_field" placeholder=" Email Address"><br>

                                    <div id="text_wrapper">
                                        <label class="text_pw">Password</label>
                                    </div>
                                    <input type="password" name="password" class="text_field" placeholder=" ***********"><br>
                                    <br>

                                    <div class="row no-gutter g-1" style="position: relative;">
                                        <div class="col-2">
                                            <label class="ChangePass" style="color: white;">Change Password</label>
                                        </div>

                                        <div class="col-2">
                                            <button class="ChangePasswordButton">Change</button>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="text_wrapper">
                                        <label class="text_username">Username</label>
                                    </div><br>

                                    <input type="text" name="username" class="text_field" placeholder=" Username"><br>
                                    <div class="button">
                                        <input type="submit" name="submit" value="Confirm Edit" class="button_orange">
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