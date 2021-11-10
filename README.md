# oson-css325

This is a music player webapp, for CSS 325.

- For user Data --main-font:'Kanit';
<!DOCTYPE html>
<!--Font-->
<link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;700&display=swap" rel="stylesheet">

- For website headers and texts --main-font:'Typo Round Regular Demo';

INSERT INTO `artist`(`ArtistEmail`, `ArtistPassword`, `ArtistName`, `ArtistGenre`, `AmountOfFollowers`, `Banking_Information`, `Country`, `ArtistRealNames`, `profile_url`) VALUES ('palewaves@gmail.com','palewaves','Pale Waves','Indie','6000','KGB-0123456789','England', 'Heather Baron-Gracie','img/1')

INSERT INTO `listener` (`UserEmail`, `UserPassword`, `Gender`, `UserName`, `UserDateOfBirth`, `PreferredGenre`, `CreationTimeStamp`, `Country`, `profile_url`) VALUES ('leon@gmail.com', 'leon', 'Male', 'leonardo', '26-Jun-2000', 'Indie', 'current_timestamp(2)', 'Germany', 'img/1') 

INSERT INTO `song` (`Duration`, `Genre`, `Name`, `Language`, `Popularity`, `Explicity`, `ReleaseDate`, `song_url`, `cover_url`) VALUES ('2.36', 'Rap', 'God\'s plan', '0', 'English', 'E', '2018-01-19', 'song/1', 'cover/1');