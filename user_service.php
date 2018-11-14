<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once('users.php');
  $action = "";
  if (isset($_POST['action'])) {
    $action = $_POST['action'];
  }

	if ($action == "get_data") {
    if (isset($_POST['id'])) {
      $users = new users();
      $id = $_POST['id'];
      echo $users->getUserData($id);
    } else {
      echo "Incorrect, provide id";
    }
	} else if ($action == "get_songs") {
    if (isset($_POST['id'])) {
      $users = new users();
      $id = $_POST['id'];
      echo $users->getUserSongs($id);
    } else {
      echo "Incorrect, provide id";
    }
	} else if ($action == "new_user") {
    if (isset($_POST['name']) && isset($_POST['image'])) {
      $users = new users();
		  $name = $_POST['name'];
      $image = $_POST['image'];
      echo $users->addUser($name, $image);
    } else {
      echo "Incorrect, provide name and image";
    }
	} else if ($action == "login") {
    if (isset($_POST['image'])) {
      $users = new users();
      $image = $_POST['image'];
      echo $users->findUser($image);
    } else {
      echo "Incorrect, provide image";
    }
	}
} else {
	echo "error";
}

?>