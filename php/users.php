<?php

include_once('queries.php');
include_once('emotion.php');

class users {
	# ---------- User-facing functions ---------------
	public function findUser($image) {
		$queries = new Queries();
    $image_id = $queries->insertPhoto(NULL);
    $local_path = "../unknown_pictures/$image_id.png";
		$image_path = config::obtieneRuta().$local_path;
		if ($queries->updatePhoto($image_id, $image_path)) {
			file_put_contents($local_path,base64_decode($image));
			$script = "../python/get_face.py";

			if (!isset($object))
				$object = new stdClass();
			$object->path = $local_path;

			// Execute the python script with the JSON data
      $result = shell_exec("/usr/bin/python3.5 $script " . escapeshellarg(json_encode($object)));
			// Decode the result
      $resultData = json_decode($result, true);
      $user_id = $resultData['result'];
      if ($user_id) {
        if ($queries->insertIdentity($user_id, $image_id)) {
					return $user_id;
				}
      }
		}
		return -1;
  }

	public function addUser($name, $image) {
		$queries = new Queries();
    $user_id = $queries->insertUser($name);
		if ($user_id != -1) {
      // TODO Verify that there is face in picture
      $local_path = "../known_people/$user_id.png";
			$image_path = config::obtieneRuta().$local_path;
      $image_id = $queries->insertPhoto($image_path);
			if ($image_id != -1) {
				file_put_contents($local_path,base64_decode($image));
				if ($queries->insertIdentity($user_id, $image_id)) {
					return $user_id;
				}
			}
		}
		return -1;
	}
	
	public function getUserName($id){
		$queries = new Queries();
    $result = $queries->getUser($id);
    $json = array();
    while($row = mysqli_fetch_assoc($result)){
      return $row['nameUser'];
    }
    return "";
}

	public function getUserSongs($id){
		$queries = new Queries();
		$result = $queries->getLikedSongs($id);
		$json = array();
		while($row = mysqli_fetch_assoc($result)){
				$json['name'] = $row['name'];
				$json['genre'] = $row['genre'];
        $json['video'] = $row['video'];
        $json['position'] = $row['position'];
				$data[] = $json;
		}						
		return json_encode($data);
	}

	public function getUserPhotos($id) {
		$queries = new Queries();
		$result = $queries->getPhotos($id);
		$json = array();
		while($row = mysqli_fetch_assoc($result)){
				$json['date'] = $row['date'];
				$json['url'] = $row['url'];
				$data[] = $json;
		}						
		return json_encode($data);
  }
  
  public function newLikedSong ($user, $name, $genre, $video, $position) {
    $queries = new Queries();
    $song_id = $queries->insertSong($name, $genre, $video, $position);
    if ($song_id != -1) {
      return $queries->insertLike($user, $song_id);
    } else {
      return -1;
    }
  }

  public function getUserFeeling ($photo_url) {
    $emotion = new Emotion();
    $result = $emotion->getEmotion($photo_url);
    if ($this->isJson($result)) {
      $json = json_decode($result, true);
      $feelings = $json[0]['faceAttributes']['emotion'];
      $max = 0;
      $current = "";
      foreach ($feelings as $key => $value) {
        if ($value > $max) {
          $max = $value;
          $current = $key;
        }
      }
      return $current;
    } else {
      return "Error getting emotion";
    }
  }

  private function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
   }

  public function getUserPicture($user) {
    $queries = new Queries();
    $result = $queries->getLastPhoto($user);
    while($row = mysqli_fetch_assoc($result)){
      return $row['url'];
    }
  }

  public function addUserFeeling($user, $feeling) {
    $queries = new Queries();
    $result = $queries->getEmotionId($feeling);
    $id_emotion = 0;
    while($row = mysqli_fetch_assoc($result)){
      $id_emotion = $row['idEmotion'];
    }
    return $queries->insertFeel($user, $id_emotion);
  }

  public function getPastEmotions($user_id) {
    $queries = new Queries();
		$result = $queries->getEmotions($user_id);
		$json = array();
		while($row = mysqli_fetch_assoc($result)){
				$json['emotion'] = $row['emotion'];
				$json['date'] = $row['date'];
				$data[] = $json;
		}
		return json_encode($data);
  }

 }

?>	