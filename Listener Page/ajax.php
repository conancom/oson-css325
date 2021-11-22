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
      
      <div class="col-md-3">
         <!-- <a href="Listener-Search-Page.php?searchResult=<?php echo $Result['searchRes']?>"> -->
            <div class="row Artist-Pic">
               <?php
                  $href = "";  $class = "";
                  
                  if($Result['type'] == "artist"){ $path = "profileimg/".$Result['searchId'].".jpg"; $class = "rounded-corners"; $href = "<a href=Listener-Artist-Profile-Page.php?idArtist=". $Result['searchId'].">";}
                  else if ($Result['type'] == "song"){ $path = "songimg/".$Result['searchId'].".jpg"; } 
                  else { $path = "albumimg/".$Result['searchId'].".jpg"; $href = "<a href=Listener-Album-Profile-Page.php?idAlbum=". $Result['searchId'].  ">";}
               ?>
               <?php echo $href?>
               <img width="250" height="250" src="<?php echo $path?>" alt="<?php echo $path?>" style="padding-bottom: 20px;" class="<?php echo $class?>"></a>
            </div>
            <div class="row Artist-Name">
               <?php echo $href?>
               <h3 style="text-align: center;"><?php echo $Result['searchRes']?></h3></a>
            </div>
            <div class="row Playlist-Type">
               <p style="text-align: center;"><?php echo $Result['type']?></p>
            </div>
         <!-- </a> -->
      </div>

<?php
   }
}
?>