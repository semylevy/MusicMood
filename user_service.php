<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once('users.php');
  $action = "";
  if (isset($_POST['action'])) {
    $action = $_POST['action'];
	}
	
	if ($action == "new_user") {
    if (isset($_POST['name']) && isset($_POST['image'])) {
      $users = new users();
		  $name = $_POST['name'];
			$image = $_POST['image'];
			$id = $users->addUser($name, $image); 
			if ($id != -1) {
				echo $users->getUserInfo($id);
			} else {
				echo "Could not add user";
			}
    } else {
      echo "Incorrect, provide name and image";
    }
	} else if ($action == "login") {
    if (isset($_POST['image'])) {
      $users = new users();
			$image = $_POST['image'];
			$id = $users->findUser($image);
			if ($id != -1) {
				echo $users->getUserInfo($id);
			} else {
				echo "Could not find user";
			}
    } else {
      echo "Incorrect, provide image";
    }
	} else if ($action == "get_songs") {
    if (isset($_POST['id'])) {
      $users = new users();
      $id = $_POST['id'];
      echo $users->getUserSongs($id);
    } else {
      echo "Incorrect, provide id";
    }
	}
} else {
	echo "error";
}

?>