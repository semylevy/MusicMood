<?php

include_once('../config/config.php');
include_once('../config/db_admin.php');

# ---------- INSERT functions ---------------

class Queries {
	public function insertUser($name) {
		$db = new administradorBD();
    $sql = "INSERT INTO fp_User (nameUser) VALUES ('$name');";
    $id = $db->executeQueryGetId($sql);
		if ($id) {
      return $id;
		} else {
      echo "ERROR inserting user. Query: ".$sql;
    }
		return -1;
	}

	public function insertPhoto($image_url) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Photo (urlPhoto) VALUES ('$image_url');";
    $id = $db->executeQueryGetId($sql);
		if ($id) {
			return $id;
		} else {
			echo "ERROR inserting Photo";
		}
		return -1;
	}

	public function insertSong($name, $genre, $video, $position) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Song (nameSong, genreSong, videoSong, positionSong) VALUES ('$name', '$genre', '$video', '$position');";
		$id = $db->executeQueryGetId($sql);
		if ($id) {
			return $id;
		} else {
			echo "ERROR inserting Song";
		}
		return -1;
	}

	public function insertEmotion($name, $emoji) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Emotion (nameEmotion, emojiEmotion) VALUES ('$name', '$emoji');";
		$id = $db->executeQueryGetId($sql);
		if ($id) {
			return $id;
		} else {
			echo "ERROR inserting Emotion";
		}
		return -1;
  }
  
  public function insertFeel($user_id, $emotion_id) {
    $db = new administradorBD();
		$sql = "INSERT INTO fp_Feel (User_idUser, Emotion_idEmotion) VALUES ('$user_id', '$emotion_id');";
		return $db->executeQuery($sql);
  }

  public function getEmotionId($emotion) {
    $db = new administradorBD();
    $sql = "SELECT idEmotion FROM fp_Emotion WHERE fp_Emotion.nameEmotion LIKE '$emotion';";
    return $db->executeQuery($sql);
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
    $sql = "UPDATE fp_Photo SET urlPhoto = '$image_url' WHERE idPhoto = $image_id";
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
    					s.videoSong AS video,
              s.positionSong as position
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

	public function getLastPhoto($id){
		$sql = "SELECT 
    					p.urlPhoto AS url
						FROM
    					fp_Photo p
        				INNER JOIN
    					fp_Identity i ON p.idPhoto = i.Photo_idPhoto
        				INNER JOIN
    					fp_User u ON u.idUser = i.User_idUser
						WHERE
              i.User_idUser = $id
            ORDER BY p.datePhoto DESC
            LIMIT 1";
		$db = new administradorBD();
		return $db->executeQuery($sql);
  }
  
  public function getEmotions($id) {
    $sql = "SELECT Emotion_idEmotion as emotion, dateMood as date FROM fp_Feel WHERE User_idUser = $id";
    $db = new administradorBD();
		return $db->executeQuery($sql);
  }
}

?>