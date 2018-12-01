<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once('users.php');
  $action = "";
  if (isset($_POST['action'])) {
    $action = $_POST['action'];
	} else {
    echo "Error. Specify action";
  }
	
	if ($action == "new_user") {
    if (isset($_POST['name']) && isset($_POST['image'])) {
      $users = new users();
		  $name = $_POST['name'];
			$image = $_POST['image'];
			$id = $users->addUser($name, $image); 
			if ($id != -1) {
        $url = $users->getUserPicture($id);
        $feeling = $users->getUserFeeling($url);
        $users->addUserFeeling($id, $feeling);
        $name = $users->getUserName($id);
        $data[] = array('id' => '$id', 'name' => $name, 'feeling' => $feeling);
        echo json_encode($data);
			} else {
				$data[] = array('id' => -1, 'name' => "", 'feeling' => "");
				echo json_encode($data);
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
        $url = $users->getUserPicture($id);
        $feeling = $users->getUserFeeling($url);
        $users->addUserFeeling($id, $feeling);
        $name = $users->getUserName($id);
        $data[] = array('id' => $id, 'name' => $name, 'feeling' => $feeling);
        echo json_encode($data);
			} else {
        $data[] = array('id' => -1, 'name' => "", 'feeling' => "");
				echo json_encode($data);
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
  } else if ($action == "new_song") {
    if (isset($_POST['user']) && isset($_POST['genre']) && isset($_POST['name']) && isset($_POST['video']) && isset($_POST['position'])) {
      $users = new users();
      $user = $_POST['user'];
      $genre = $_POST['genre'];
      $name = $_POST['name'];
      $video = $_POST['video'];
      $position = $_POST['position'];
      echo $users->newLikedSong($user, $name, $genre, $video, $position);
    } else {
      echo "Incorrect, provide parameters";
    }
	} else if ($action == "feeling") {
    if (isset($_POST['user'])) {
      $users = new Users();
      $user = $_POST['user'];
      $url = $users->getUserPicture($user);
      if ($url) {
        echo $users->getUserFeeling($url);
      }
    } else {
      echo "Incorrect, provide user";
    }
  } else if ($action == "emotions") {
    if (isset($_POST['user'])) {
      $users = new Users();
      $user = $_POST['user'];
      echo $users->getPastEmotions($user);
    } else {
      echo "Incorrect, provide user";
    }
  } else {
    echo "error";
  }
} else {
	echo "error";
}

?>