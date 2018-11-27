<?php
include_once('config/config.php');
include_once('config/db_admin.php');

class users{

	# ---------- INSERT functions ---------------

	private function insertUser($name) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_User (nameUser) VALUES ('$name');
						SELECT LAST_INSERT_ID();";
		$result = $db->executeQuery($sql);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				return $row['LAST_INSERT_ID()'];
			}
		} else {
			echo "ERROR inserting User";
		}
		return -1;
	}

	private function insertPhoto($image_url) {
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

	private function insertSong($name, $genre, $video) {
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

	private function insertEmotion($name, $emoji) {
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

	private function insertIdentity($user_id, $photo_id) {
		$db = new administradorBD();
		$sql = "INSERT INTO fp_Identity (User_idUser, Photo_idPhoto) VALUES ('$user_id', '$photo_id')";
		return $db->executeQuery($sql);
	}

	private function insertLike($user_id, $song_id) {
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
	
	private function getUser($id){
		$sql = "SELECT * FROM fp_User WHERE idUser = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}

	private function getLikedSongs($id){
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

	private function getPhotos($id){
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

	# ---------- User-facing functions ---------------

	public function findUser($image) {
		$image_id = $this->insertPhoto(NULL);
		$image_path = "unknown_pictures/$image_id.png";
		if (updatePhoto($image_id, $image_path)) {
			file_put_contents($image_path,base64_decode($image));
			$script = "get_face.py";

			if (!isset($object)) 
				$object = new stdClass();
			$object->path = $img_path;

			// Execute the python script with the JSON data
			$result = shell_exec("/usr/local/bin/python3 $script " . escapeshellarg(json_encode($object)));
			// Decode the result
			$resultData = json_decode($result, true);
			return $resultData['result'];
		}
		return -1;
  }

	public function addUser($name, $image) {
		$user_id = $this->insertUser($name);
		if ($user_id != -1) {
			// TODO Verify that there is face in picture
			$path = config::obtieneRuta()."known_people/$id.png";
			$image_id = $this->insertPhoto($path);
			if ($image_id != -1) {
				file_put_contents($path,base64_decode($image));
				if ($this->insertIdentity($user_id, $image_id)) {
					return $user_id;
				}
			}
		}
		return -1;
	}
	
	public function getUserInfo($id){
    $result = $this->getUser($id);
    $json = array();
    while($row = mysqli_fetch_assoc($result)){
      $json['id'] = $row['idUser'];
      $json['name'] = $row['nameUser'];
      $data[] = $json;
    }
    return json_encode($data);
}

	public function getUserSongs($id){
		$result = $this->getSongs($id);
		$json = array();
		while($row = mysqli_fetch_assoc($result)){
				$json['name'] = $row['name'];
				$json['genre'] = $row['genre'];
				$json['video'] = $row['video'];
				$data[] = $json;
		}						
		return json_encode($data);
	}

	public function getUserPhotos($id) {
		$result = $this->getSongs($id);
		$json = array();
		while($row = mysqli_fetch_assoc($result)){
				$json['date'] = $row['date'];
				$json['url'] = $row['url'];
				$data[] = $json;
		}						
		return json_encode($data);
	}

 }

?>	