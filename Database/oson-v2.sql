-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2021 at 12:58 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oson-v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `idAlbum` bigint(20) NOT NULL,
  `idArtist` bigint(20) NOT NULL,
  `AlbumName` varchar(255) NOT NULL,
  `Genre` varchar(255) NOT NULL,
  `AmountOfSongs` int(11) NOT NULL,
  `TotalDuration` int(11) NOT NULL,
  `CreationTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  `Language` varchar(255) NOT NULL,
  `Explicity` varchar(255) NOT NULL,
  `AmountOfFollower` int(11) NOT NULL,
  `cover_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `idArtist` bigint(20) NOT NULL,
  `ArtistEmail` varchar(255) NOT NULL,
  `ArtistPassword` varchar(255) NOT NULL,
  `ArtistName` varchar(255) NOT NULL,
  `ArtistGenre` varchar(255) NOT NULL,
  `AmountOfFollowers` int(11) NOT NULL,
  `Banking_Information` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `CreationTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  `ArtistRealNames` varchar(255) NOT NULL,
  `profile_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`idArtist`, `ArtistEmail`, `ArtistPassword`, `ArtistName`, `ArtistGenre`, `AmountOfFollowers`, `Banking_Information`, `Country`, `CreationTimeStamp`, `ArtistRealNames`, `profile_url`) VALUES
(1, 'palewaves@gmail.com', 'palewaves', 'Pale Waves', 'Indie', 6000, 'KGB-0123456789', 'United Kingdom', '2021-11-07 04:00:21.16', 'Heather Baron-Gracie', 'img/1'),
(2, 'drake@gmail.com', 'drake', 'Drake', 'Rap', 120000, 'UOB-0987654321', 'United States', '2021-11-07 03:59:41.35', 'Aubrey Drake Graham', 'img/2'),
(3, 'taylorswift@gmail.com', 'taylorswift', 'Taylor Swift', 'Pop', 500000, 'KGB-5633218459', 'United States', '2021-11-09 14:01:15.61', 'Taylor Alison Swift', 'img/3'),
(4, 'brunomars@gmail.com', 'brunomars', 'Bruno Mars', 'Pop', 45200, 'TMB-1855632485', 'United States', '2021-11-09 14:01:15.62', 'Peter Gene Hernandez', 'img/4'),
(5, 'rihanna@gmail.com', 'rihanna', 'Rihanna', 'R&B', 498330, 'AYT-655321578', 'Barbados', '2021-11-09 14:01:15.63', 'Robyn Rihanna Fenty', 'img/5'),
(6, 'justinbieber@gmail.com', 'justinbieber', 'Justin Bieber', 'Pop', 8022230, 'TCB-6328865482', 'Canada', '2021-11-09 14:01:15.64', 'Justin Drew Bieber', 'img/6'),
(7, 'postmalone@gmail.com', 'postmalone', 'Post Malone', 'Rap', 792236, 'KTB-9965321548', 'United States', '2021-11-09 14:01:15.65', 'Austin Richard Post', 'img/7'),
(8, 'eminem@gmail.com', 'eminem', 'Eminem', 'Rap', 3566698, '-', 'United States', '2021-11-09 14:01:15.66', 'Marshall Bruce Mathers III', 'img/8'),
(9, 'kendricklamar@gmail.com', 'kendricklamar', 'Kendrick Lamar', 'Rap', 2365532, 'UOB-6333268545', 'United States', '2021-11-09 14:01:15.67', 'Kendrick Lamar Duckworth', 'img/9'),
(10, 'travisscott@gmail.com', 'travisscott', 'Travis Scott', 'Rap', 69420, 'KGB-986632354', 'United States', '2021-11-09 14:01:15.68', 'Jacques Bermon Webster II', 'img/10');

-- --------------------------------------------------------

--
-- Table structure for table `consistalbum`
--

CREATE TABLE `consistalbum` (
  `ConsistAlbumId` bigint(20) NOT NULL,
  `idAlbum` bigint(20) NOT NULL,
  `idSong` bigint(20) NOT NULL,
  `EntryOfAlbum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `consistplaylist`
--

CREATE TABLE `consistplaylist` (
  `ConsistPlaylistId` bigint(20) NOT NULL,
  `idSong` bigint(20) NOT NULL,
  `idPlaylist` bigint(20) NOT NULL,
  `CreationTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `createsong`
--

CREATE TABLE `createsong` (
  `CreateSongID` bigint(20) NOT NULL,
  `idArtist` bigint(20) NOT NULL,
  `idSong` bigint(20) NOT NULL,
  `CreationTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  `EntryOfArtist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donatetoartist`
--

CREATE TABLE `donatetoartist` (
  `idDonate` bigint(20) NOT NULL,
  `idListener` bigint(20) NOT NULL,
  `idArtist` bigint(20) NOT NULL,
  `DonateTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  `Amount` float NOT NULL,
  `CreditCardInformatio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followalbum`
--

CREATE TABLE `followalbum` (
  `FollowAlbumId` bigint(20) NOT NULL,
  `idListener` bigint(20) NOT NULL,
  `idAlbum` bigint(20) NOT NULL,
  `FollowDate` date NOT NULL,
  `FollowTime` time(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followarist`
--

CREATE TABLE `followarist` (
  `FollowArtistId` bigint(20) NOT NULL,
  `idListener` bigint(20) NOT NULL,
  `idArtist` bigint(20) NOT NULL,
  `FollowDate` date NOT NULL,
  `FollowTime` time(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `listener`
--

CREATE TABLE `listener` (
  `idListener` bigint(20) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserDateOfBirth` date NOT NULL,
  `PreferredGenre` varchar(255) NOT NULL,
  `CreationTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  `Country` varchar(255) NOT NULL,
  `profile_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listener`
--

INSERT INTO `listener` (`idListener`, `UserEmail`, `UserPassword`, `Gender`, `UserName`, `UserDateOfBirth`, `PreferredGenre`, `CreationTimeStamp`, `Country`, `profile_url`) VALUES
(1, 'leon@gmail.com', 'leon', 'Male', 'leonardo', '2000-06-26', 'Indie', '2021-11-09 14:17:11.09', 'Germany', 'img/1'),
(2, 'junior@gmail.com', 'junior', 'Male', 'floyd', '2002-09-07', 'Rap', '2021-11-09 14:21:35.47', 'North Korea', 'img/2'),
(3, 'fluke@gmail.com', 'fluke', 'Male', 'fussgy', '2000-12-25', 'Indie', '2021-11-09 14:21:35.48', 'Thailand', 'img/3');

-- --------------------------------------------------------

--
-- Table structure for table `listentosong`
--

CREATE TABLE `listentosong` (
  `ListenToSongId` bigint(20) NOT NULL,
  `idListener` bigint(20) NOT NULL,
  `idSong` bigint(20) NOT NULL,
  `DurationListenedTo` int(11) NOT NULL,
  `ListenTimeStamp` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `idPlaylist` bigint(20) NOT NULL,
  `idListener` bigint(20) NOT NULL,
  `TotalDuration` int(11) NOT NULL,
  `PlaylistName` varchar(255) NOT NULL,
  `AmountOfSongs` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Genre` varchar(255) NOT NULL,
  `Publicity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `idSong` bigint(20) NOT NULL,
  `Duration` float NOT NULL,
  `Genre` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Language` varchar(255) NOT NULL,
  `Popularity` float NOT NULL,
  `Explicity` varchar(255) NOT NULL,
  `ReleaseDate` date NOT NULL,
  `song_url` varchar(255) NOT NULL,
  `cover_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`idSong`, `Duration`, `Genre`, `Name`, `Language`, `Popularity`, `Explicity`, `ReleaseDate`, `song_url`, `cover_url`) VALUES
(1, 2.49, 'Rap', 'God\'s plan', 'English', 0, 'E', '2018-01-19', 'song/1', 'cover/1'),
(2, 4, 'Pop', 'Red', 'English', 0, '-', '2012-10-22', 'song/2', 'cover/2'),
(3, 3, 'R&B', 'Love On the Brain', 'English', 0, 'E', '2016-06-26', 'song/3', 'cover/3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`idAlbum`),
  ADD KEY `idArtist` (`idArtist`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`idArtist`);

--
-- Indexes for table `consistalbum`
--
ALTER TABLE `consistalbum`
  ADD PRIMARY KEY (`ConsistAlbumId`),
  ADD KEY `idAlbum` (`idAlbum`),
  ADD KEY `idSong` (`idSong`);

--
-- Indexes for table `consistplaylist`
--
ALTER TABLE `consistplaylist`
  ADD PRIMARY KEY (`ConsistPlaylistId`),
  ADD KEY `idPlaylist` (`idPlaylist`),
  ADD KEY `idSong` (`idSong`);

--
-- Indexes for table `createsong`
--
ALTER TABLE `createsong`
  ADD PRIMARY KEY (`CreateSongID`),
  ADD KEY `idArtist` (`idArtist`),
  ADD KEY `idSong` (`idSong`);

--
-- Indexes for table `donatetoartist`
--
ALTER TABLE `donatetoartist`
  ADD PRIMARY KEY (`idDonate`),
  ADD KEY `idArtist` (`idArtist`),
  ADD KEY `idListener` (`idListener`);

--
-- Indexes for table `followalbum`
--
ALTER TABLE `followalbum`
  ADD PRIMARY KEY (`FollowAlbumId`),
  ADD KEY `idAlbum` (`idAlbum`),
  ADD KEY `idListener` (`idListener`);

--
-- Indexes for table `followarist`
--
ALTER TABLE `followarist`
  ADD PRIMARY KEY (`FollowArtistId`),
  ADD KEY `idArtist` (`idArtist`),
  ADD KEY `idListener` (`idListener`);

--
-- Indexes for table `listener`
--
ALTER TABLE `listener`
  ADD PRIMARY KEY (`idListener`);

--
-- Indexes for table `listentosong`
--
ALTER TABLE `listentosong`
  ADD PRIMARY KEY (`ListenToSongId`),
  ADD KEY `idListener` (`idListener`),
  ADD KEY `idSong` (`idSong`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`idPlaylist`),
  ADD KEY `idListener` (`idListener`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`idSong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `idAlbum` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `idArtist` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `consistalbum`
--
ALTER TABLE `consistalbum`
  MODIFY `ConsistAlbumId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consistplaylist`
--
ALTER TABLE `consistplaylist`
  MODIFY `ConsistPlaylistId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `createsong`
--
ALTER TABLE `createsong`
  MODIFY `CreateSongID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donatetoartist`
--
ALTER TABLE `donatetoartist`
  MODIFY `idDonate` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followalbum`
--
ALTER TABLE `followalbum`
  MODIFY `FollowAlbumId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followarist`
--
ALTER TABLE `followarist`
  MODIFY `FollowArtistId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listener`
--
ALTER TABLE `listener`
  MODIFY `idListener` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `listentosong`
--
ALTER TABLE `listentosong`
  MODIFY `ListenToSongId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `idPlaylist` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `idSong` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`);

--
-- Constraints for table `consistalbum`
--
ALTER TABLE `consistalbum`
  ADD CONSTRAINT `consistalbum_ibfk_1` FOREIGN KEY (`idAlbum`) REFERENCES `album` (`idAlbum`),
  ADD CONSTRAINT `consistalbum_ibfk_2` FOREIGN KEY (`idSong`) REFERENCES `song` (`idSong`);

--
-- Constraints for table `consistplaylist`
--
ALTER TABLE `consistplaylist`
  ADD CONSTRAINT `consistplaylist_ibfk_1` FOREIGN KEY (`idPlaylist`) REFERENCES `playlist` (`idPlaylist`),
  ADD CONSTRAINT `consistplaylist_ibfk_2` FOREIGN KEY (`idSong`) REFERENCES `song` (`idSong`);

--
-- Constraints for table `createsong`
--
ALTER TABLE `createsong`
  ADD CONSTRAINT `createsong_ibfk_1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`),
  ADD CONSTRAINT `createsong_ibfk_2` FOREIGN KEY (`idSong`) REFERENCES `song` (`idSong`);

--
-- Constraints for table `donatetoartist`
--
ALTER TABLE `donatetoartist`
  ADD CONSTRAINT `donatetoartist_ibfk_1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`),
  ADD CONSTRAINT `donatetoartist_ibfk_2` FOREIGN KEY (`idListener`) REFERENCES `listener` (`idListener`);

--
-- Constraints for table `followalbum`
--
ALTER TABLE `followalbum`
  ADD CONSTRAINT `followalbum_ibfk_1` FOREIGN KEY (`idAlbum`) REFERENCES `album` (`idAlbum`),
  ADD CONSTRAINT `followalbum_ibfk_2` FOREIGN KEY (`idListener`) REFERENCES `listener` (`idListener`);

--
-- Constraints for table `followarist`
--
ALTER TABLE `followarist`
  ADD CONSTRAINT `followarist_ibfk_1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`),
  ADD CONSTRAINT `followarist_ibfk_2` FOREIGN KEY (`idListener`) REFERENCES `listener` (`idListener`);

--
-- Constraints for table `listentosong`
--
ALTER TABLE `listentosong`
  ADD CONSTRAINT `listentosong_ibfk_1` FOREIGN KEY (`idListener`) REFERENCES `listener` (`idListener`),
  ADD CONSTRAINT `listentosong_ibfk_2` FOREIGN KEY (`idSong`) REFERENCES `song` (`idSong`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`idListener`) REFERENCES `listener` (`idListener`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
