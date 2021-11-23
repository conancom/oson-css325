<?php
$mysqli = new mysqli("localhost", "root", null, "oson-v2");
if ($mysqli->connect_errno) {
   echo $mysqli->connect_error;
}

if (isset($_POST['search'])) {
   $Name = $_POST['search'];
   $Query = "SELECT s.`Name` as searchRes, s.`idSong` as searchId, 'song' as type FROM `song` s WHERE s.`Name` LIKE '%$Name%' UNION 
               SELECT al.`AlbumName` as searchRes, al.`idAlbum` as searchId, 'album' as type FROM `album` al WHERE al.`AlbumName` LIKE '%$Name%' UNION
                  SELECT a.`ArtistName` as searchRes, a.`idArtist` as searchId, 'artist' as type FROM `artist` a WHERE a.`ArtistName` LIKE '%$Name%' LIMIT 5";
   $ExecQuery = $mysqli->query($Query);
   while ($Result = $ExecQuery->fetch_array()) {
?>


      <div class="Artist-Constainer" style=" margin-left: 55px; width: 240px; height: 240px; display: inline;">
         <div class="row">
            <div class="Artist-Pic" style="margin-left: 3%;">
               <?php
               $href = "";
               $class = "";

               if ($Result['type'] == "artist") {
                  $path = "profileimg/" . $Result['searchId'] . ".jpg";
                  //$class = "rounded-corners";
                  $href = "<a href=Listener-Artist-Profile-Page.php?idArtist=" . $Result['searchId'] . ">";
               } else if ($Result['type'] == "song") {
                  $path = "songimg/" . $Result['searchId'] . ".jpg";
               } else {
                  $path = "albumimg/" . $Result['searchId'] . ".jpg";
                  $href = "<a href=Listener-Album-Profile-Page.php?idAlbum=" . $Result['searchId'] .  ">";
               }
               ?>

               <?php echo $href ?>
               <img src="<?php echo $path ?>" alt="<?php echo $path ?>"  class="<?php echo $class ?>"></a>
            </div>
         </div>

         <div class="row Artist-Name">
            <?php echo $href ?>
            <h3 style="color: white; text-align: center; margin-top: 20px;"><?php echo $Result['searchRes'] ?></h3></a>
         </div>
         <div class="row">
            <div class="Artist-Type">
               <p style="color:white; text-align: center;"><?php echo $Result['type'] ?></p>
            </div>
         </div>
      </div>


<?php
   }
}
?>