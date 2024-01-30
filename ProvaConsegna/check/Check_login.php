<?php

session_start();
include("../common/connessione_database_base.php");
include("../common/funzioni.php");
//include("js/javascript.js");
// si noti che la sessione va inizializzata prima di mandare qualunque dato in output
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';
$tipo_utente = $_POST['tipo_utente'] ?? '';


if ($conn) {
	// Debug per controllare i valori delle variabili POST
	
    echo("Email: " . $email);
    echo("Password: " . $password);
    echo("Tipo utente: " . $tipo_utente);
	$result= isUser($conn,$email,$password,$tipo_utente);

	// Debug per controllare il risultato della funzione isUser
    echo("Risultato isUser: " . print_r($result, true));
	
	if ($result["status"]==="ok")
	{//SESSIONE
	  $_SESSION["utente"]=$email;
	  $_SESSION["tipo"]=$tipo_utente;
	  $_SESSION["logged"]=true;
	  

	  //REINDIRIZZAMENTO IN CASO DI ACCESSO
	  header("Location: ../frontend/".$tipo_utente.".php?status=ok&msg=". urlencode($result["msg"]));
	  exit();
	  //REINDIRIZZAMENTO IN CASO DI ERRORE
	}else{

	  //header("Location:../login.php?status=error&msg=". urlencode($result["msg"]));
	  //exit();
	   $errorMessage = $result["msg"]; // Assuming the error message is part of the result
    echo '<script type="text/javascript">',
    			'showError($errorMessage);',
    			'</script>';
    header("Location:../login.php?status=error&msg=". urlencode($result["msg"]));
    exit();
	}
}

?>