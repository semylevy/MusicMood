<?php
include_once('config/config.php');
include_once('config/db_admin.php');

class users{
	
	private function getUser($id){
		$sql = "SELECT * FROM Users WHERE id_users = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}

	private function getSongs($id){
		$sql = "SELECT song FROM Songs WHERE user = $id";
		$db = new administradorBD();
		return $db->executeQuery($sql);
	}

	# Do face recognition here
	public function findUser($image) {
    $db = new administradorBD();
    $sql = "SELECT MAX(id) FROM new_users";
    $result = $db->executeQuery($sql);
    $new_id = 0;

    if($result){
      while($row = mysqli_fetch_assoc($result)){
        $new_id = $row['MAX(id)'];
      }
      $new_id++;
    }

    $img_path = "unknown_pictures/$new_id.png";
    $script = "get_face.py";

    file_put_contents($img_path,base64_decode($image));

    if (!isset($object)) 
      $object = new stdClass();
    $object->path = $img_path;

    // Execute the python script with the JSON data
    $result = shell_exec("/usr/local/bin/python3 $script " . escapeshellarg(json_encode($object)));
    // Decode the result
    $resultData = json_decode($result, true);

    $sql2 = "INSERT INTO new_users (id) VALUES ('$new_id')";
    $result = $db->executeQuery($sql2);

    return $resultData['result'];
  }

	public function addUser($name, $image) {
		$db = new administradorBD();

    $sql = "SELECT LAST_INSERT_ID()";
    $result = $db->executeQuery($sql);
    while($row = mysqli_fetch_assoc($result)){
      $id = $row['LAST_INSERT_ID()'];
    }

    $path = "known_people/$id.png";
    $ruta = config::obtieneRuta().$path;

    $sql = "INSERT INTO Users (name_users, image_users) VALUES('$name', '$ruta')";

    if($db->executeQuery($sql)){
            file_put_contents($path,base64_decode($image));
            return $id;
    } else {
			echo "Could not add user";
		}
	}
	
	public function getUserData($id){
    $result = $this->getUser($id);
    $json = array();

    while($row = mysqli_fetch_assoc($result)){
      $json['id'] = $row['id_users'];
      $json['name'] = $row['name_users'];
      $json['img'] = $row['image_users'];
      $data[] = $json;
    }

    return json_encode($data);
}

	public function getUserSongs($id){
                $result = $this->getSongs($id);
                $json = array();

                while($row = mysqli_fetch_assoc($result)){
                   $json['song'] = $row['song'];
                   $data[] = $json;
                }
                          
               return json_encode($data);
	}
 }

?>