<?php
class config{
	public static function obtieneServidorBD(){
		return '127.0.0.1';
	}
	
	public static function obtieneNombreBD(){
		return 'moviles';
	}
	
	public static function obtieneUsuarioBD(){
		return 'root';
	}
	
	public static function obtienePasswordBD(){
		return 'root';
  }
  
  public static function obtieneRuta() {
    return $path = 'http://localhost/~semylevy/face_recognition/';
  }
}
?>