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

  // Safe way to obtain last inserted ID (only for SELECT)
 public function executeQueryGetId($sql){
  $conecta = mysqli_connect(config::obtieneServidorBD(),
                            config::obtieneUsuarioBD(),
                            config::obtienePasswordBD());
  if(!$conecta){
    die('No puedo conectarme:' .mysqli_connect_error());
  }
    
  mysqli_select_db($conecta,config::obtieneNombreBD());
    
  if (!mysqli_query($conecta,$sql)) {
    echo("Error description: " . mysqli_error($conecta));
  }
  $id = mysqli_insert_id($conecta);
  mysqli_close($conecta);
  return $id;

}

}

?>