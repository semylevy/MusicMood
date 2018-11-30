<?php

include_once('../config/config.php');
include_once('../config/db_admin.php');

# ---------- INSERT functions ---------------

class Queries {
	public function insertUser($name) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_User (nameUser) VALUES ('$name');
						SELECT LAST_INSERT_ID();";
		$result = $db->executeQuery($sql);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				return $row['LAST_INSERT_ID()'];
			}
		} else {
			echo "ERROR inserting User. Query: ".$sql;
		}
		return -1;
	}

	public function insertPhoto($image_url) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Photo (urlPhoto) VALUES ('$image_url');
						SELECT LAST_INSERT_ID();";
		$result = $db->executeQuery($sql);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				return $row['LAST_INSERT_ID()'];
			}
		} else {
			echo "ERROR inserting Photo";
		}
		return -1;
	}

	public function insertSong($name, $genre, $video) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Song (nameSong, genreSong, videoSong) VALUES ('$name', '$genre', '$video');
						SELECT LAST_INSERT_ID();";
		$result = $db->executeQuery($sql);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				return $row['LAST_INSERT_ID()'];
			}
		} else {
			echo "ERROR inserting Song";
		}
		return -1;
	}

	public function insertEmotion($name, $emoji) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Emotion (nameEmotion, emojiEmotion) VALUES ('$name', '$emoji');
						SELECT LAST_INSERT_ID();";
		$result = $db->executeQuery($sql);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				return $row['LAST_INSERT_ID()'];
			}
		} else {
			echo "ERROR inserting Emotion";
		}
		return -1;
	}

	public function insertIdentity($user_id, $photo_id) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Identity (User_idUser, Photo_idPhoto) VALUES ('$user_id', '$photo_id')";
		return $db->executeQuery($sql);
	}

	public function insertLike($user_id, $song_id) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Like (User_idUser, Song_idSong) VALUES ('$user_id', '$song_id')";
		return $db->executeQuery($sql);
	}

	# ---------- UPDATE functions ---------------

	public function updatePhoto($image_id, $image_url) {
		$db = new administradorBD();
		$sql = "UPDATE fp_Photo SET urlPhoto = $image_url WHERE idPhoto = $image_id";
		return $db->executeQuery($sql);
	}

	# ---------- SELECT functions ---------------
	
	public function getUser($id){
		$sql = "SELECT * FROM fp_User WHERE idUser = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}

	public function getLikedSongs($id){
		$sql = "SELECT 
    					s.nameSong AS name,
    					s.genreSong AS genre,
    					s.videoSong AS video
						FROM
    					fp_Song s
        				INNER JOIN
    					fp_Like l ON s.idSong = l.Song_idSong
        				INNER JOIN
    					fp_User u ON u.idUser = l.User_idUser
						WHERE
    					l.User_idUser = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}

	public function getPhotos($id){
		$sql = "SELECT 
    					p.datePhoto AS date, p.urlPhoto AS url
						FROM
    					fp_Photo p
        				INNER JOIN
    					fp_Identity i ON p.idPhoto = i.Photo_idPhoto
        				INNER JOIN
    					fp_User u ON u.idUser = i.User_idUser
						WHERE
    					i.User_idUser = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}
}

?>