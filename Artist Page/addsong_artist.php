<!DOCTYPE html>
<html>

<head>
    <title>Create New Song</title>
    <link rel="stylesheet" href="lists_artist.css">
    <link rel="stylesheet" href="register.css">

    <!--Bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</head>

<body style="background-color: rgba(44, 38, 38, 1);">
    <section class="Header">
        <nav class="menu_head">
            <div class="menu_button_group">
                <a href="#home">Home</a>
                <a href="#songs">Songs</a>
                <a href="#albums">Albums</a>
                <a href="#settings">Settings</a>
            </div>
        </nav>

        <div class="wrapper_main ">
            <div class=" profilepic ">
            </div>
            <div id="menu_head " class="header_details ">
                <h1>Pale Waves - New Song</h1>
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
                    <form name="add-song" action="songs_artist.html" method="post">
                        <div id="text_wrapper">
                            <label id="songname" style="margin-bottom: 10px;">Song Name</label>
                        </div>

                        <input type="text " name="songname " id="text_field " placeholder=" Song Name " style="margin-bottom: 10px; width: 250px">

                        <br>

                        <label style="margin-right: 60%;">Genre</label>

                        <label style="margin-bottom: 10px;">Explicity</label>

                        <br>

                        <select name="genre" style="margin-right: 60px; margin-bottom: 10px; padding-right: 35px; width: 250px;">
                        <option>-</option>
				<option value="pop ">Pop</option>
				<option value="rap ">Rap</option>
				<option value="edm ">EDM</option>
				<option value="rock ">Rock</option>
				<option value="randb ">R&B</option>
				<option value="jazz ">Jazz</option>
				<option value="metal ">Metal</option>
				<option value="soul ">Soul</option>
				<option value="raggae ">Raggae</option>
				<option value="classical ">Classical</option>
				<option value="soundtracks ">Soundtracks</option>
				<option value="Country ">Country</option>
				<option value="blues ">Blues</option>
				<option value="folk ">Folk</option>
				<option value="indie ">Indie</option>
                </select>
                        <select name="Explicity " style="padding-right: 75px; margin-bottom: 10px; ">
                        <option>-</option>
                </select><br>
                        <label>Album</label><br>
                        <select name="Album " style="padding-right: 80px; margin-bottom: 10px; padding-right: 115px; width: 250px;">
                        <option>-</option>
                </select><br>

                        <div id="text_wrapper ">
                            <label id="featuringartist " style="margin-bottom: 10px; ">Featuring Arist</label>
                        </div>
                        <input type="text " name="featuringartist " id="text_field " placeholder=" Featuring Arist " style="margin-bottom: 10px; width: 250px;"><br>

                        <label style="margin-right:100px; margin-bottom: 10px; ">Upload Song</label>
                        <button type="button " id="upload " class="button_grey "> Upload </button><br>
                        <label style="margin-right: 40px; margin-bottom: 70px; ">Upload Cover Image</label>
                        <button type="button " id="upload " class="button_grey "> Upload </button>

                        <div class="button ">
                            <button type="submit " name="submit " value="Create new Song " class="button_orange " style="margin-bottom: 20px; margin-left: 29%; "> Create new song</button><br>
                            <button type="button " class="button_dark " style="margin-left: 19%; margin-bottom: 10px; "> Cancel </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>