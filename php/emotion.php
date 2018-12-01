<?php

class Emotion {
  public function getEmotion($url) {
    $curl = 'curl -s -H "Ocp-Apim-Subscription-Key: 6b4a0bbbb8794de6974023fb6390e494" "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=emotion" -H "Content-Type: application/json" --data-ascii "{\"url\":\"'.$url.'\"}"';

    $result = shell_exec("curl $curl");

    return $result;
  }
}

?>