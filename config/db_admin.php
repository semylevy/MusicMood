<?php
include_once('config.php');

class administradorBD{
	
	public function executeQuery($sql){
		$conecta = mysqli_connect(config::obtieneServidorBD(),
                              config::obtieneUsuarioBD(),
                              config::obtienePasswordBD());
		if(!$conecta){
			die('No puedo conectarme:' .mysqli_connect_error());
		}
			
		mysqli_select_db($conecta,config::obtieneNombreBD());
			
		$result = mysqli_query($conecta,$sql);
		if (!$result) {
			echo("Error description: " . mysqli_error($conecta));
		}
		mysqli_close($conecta);
		return $result;
	}
 }

?>