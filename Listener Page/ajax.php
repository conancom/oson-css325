<?php
$mysqli = new mysqli("localhost", "root", null, "oson-v2");
if ($mysqli->connect_errno) {
   echo $mysqli->connect_error;
}

if (isset($_POST['search'])) {
   $Name = $_POST['search'];
   $Query = "SELECT s.`Name` as searchRes, s.`idSong` as searchId, 'song' as type FROM `song` s WHERE s.`Name` LIKE '%$Name%' UNION 
               SELECT a.`ArtistName` as searchRes, a.`idArtist` as searchId, 'artist' as type FROM `artist` a WHERE a.`ArtistName` LIKE '%$Name%' LIMIT 5";
   $ExecQuery = $mysqli->query($Query);
   while ($Result = $ExecQuery->fetch_array()) {
?>
      
      <div class="col-md-3">
         <a href="Listener-Search-Page.php?searchResult=<?php echo $Result['searchRes']?>">
            <div class="row Artist-Pic">
               <img src="Images/IU.jpeg" alt="IU Profile Picture" style="padding-bottom: 20px;">
            </div>
            <div class="row Artist-Name">
               <h3 style="text-align: center;"><?php echo $Result['searchRes']?></h3>
            </div>
            <div class="row Playlist-Type">
               <p style="text-align: center;"><?php echo $Result['type']?></p>
            </div>
         </a>
      </div>

<?php
   }
}
?>