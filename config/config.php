<?php
class config{
	public static function obtieneServidorBD(){
		// return '127.0.0.1'; /* local */
		return 'localhost'; /* Ubiquitous */
	}
	
	public static function obtieneNombreBD(){
		// return 'moviles'; /* local */
		return 'pddm_1023530'; /* Ubiquitous */
	}
	
	public static function obtieneUsuarioBD(){
		// return 'root'; /* local */
		return '1023530_user'; /* Ubiquitous */
	}
	
	public static function obtienePasswordBD(){
		// return 'root'; /* local */
		return '1023530'; /* Ubiquitous */
  }
  
  public static function obtieneRuta() {
		// return $path = 'http://localhost/~semylevy/face_recognition/'; /* local */
		return $path = 'http://ubiquitous.csf.itesm.mx/~pddm-1023530/MusicMood/php/'; /* Ubiquitous */
  }
}
?>