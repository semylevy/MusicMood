<?php

include_once('queries.php');

class users {
	# ---------- User-facing functions ---------------

	public function findUser($image) {
		$image_id = $this->insertPhoto(NULL);
		$image_path = config::obtieneRuta()."unknown_pictures/$image_id.png";
		if (updatePhoto($image_id, $image_path)) {
			file_put_contents($image_path,base64_decode($image));
			$script = "../python/get_face.py";

			if (!isset($object))
				$object = new stdClass();
			$object->path = $img_path;

			// Execute the python script with the JSON data
			$result = shell_exec("/usr/bin/python3.5 $script " . escapeshellarg(json_encode($object)));
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