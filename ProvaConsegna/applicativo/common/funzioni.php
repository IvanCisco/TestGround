<?php


/* Funzioni relative alla gestione degli utenti */
/*
function isUser($conn,$email,$password,$tipo_utente)
{
	$risultato= array("msg"=>"","status"=>"ok");

   /* inserire controlli dell'input 
   if ($tipo_utente=="Acquirente")
   {
   $sql = "SELECT * FROM acquirente WHERE mail = '$email' and password = '$password'";
   
   $res = $conn->query($sql);

   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "Login o password sbagliate";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "Login effettuato con successo";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;

	}elseif($tipo_utente=="Ristorante")
   {
   	$sql = "SELECT * FROM ristorante WHERE mail = '$email' and password = '$password'";

   	$res = $conn->query($sql);
   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "Login o password sbagliate";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "Login effettuato con successo";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;
}elseif($tipo_utente=="Fattorino")
   {
   	$sql = "SELECT * FROM fattorino WHERE mail = '$email' and password = '$password'";

   	$res = $conn->query($sql);
   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "Login o password sbagliate";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "Login effettuato con successo";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;
   }
}

   /*
   $res = $conn->query($sql);
   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "Login o password sbagliate";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "Login effettuato con successo";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;
}
*/
function isUser($conn, $email, $password, $tipo_utente) {
    $risultato = array("msg" => "", "status" => "ko");

    $table = "";
    switch ($tipo_utente) {
        case "Acquirente":
            $table = "acquirente";
            break;
        case "Ristorante":
            $table = "ristorante";
            break;
        case "Fattorino":
            $table = "fattorino";
            break;
        default:
            $msg = "Tipo utente non valido";
            $risultato["msg"] = $msg;
            return $risultato;
    }

    $sql = "SELECT * FROM $table WHERE mail = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res === false) {
        $msg = "Errore durante l'esecuzione della query: " . $conn->error;
        error_log($msg);
        $risultato["msg"] = "Errore durante l'autenticazione";
    } else {
        if ($res->num_rows == 1) {
            $msg = "Login effettuato con successo";
            $risultato["status"] = "ok";
            $risultato["msg"] = $msg;
        } else {
            $msg = "Login o password sbagliate";
            $risultato["msg"] = $msg;
        }
    }

    return $risultato;
}

function mailExists($mail, $conn, $table) {
	$controllo_mail = "SELECT * FROM " . $table . " WHERE mail ='$mail'";
	$result = $conn->query($controllo_mail);
	
	if ($result->num_rows > 0) {
		return TRUE;
	}
	return FALSE;
	}
	
function inserisciOrari($giorni, $orariApertura, $orariChiusura, $mail, $conn, $tabella) {
	$contatore = count($giorni);
	for ($i = 0; $i < $contatore; $i++) {
		$giorno = $giorni[$i];
		$orarioApertura = $orariApertura[$i];
		$orarioChiusura = $orariChiusura[$i];
		if ($tabella == "rlavorasu") {
			$sql = "INSERT INTO " . $tabella . " (mailrist, giorno, orainizio, orafine) VALUES ('$mail', '$giorno', '$orarioApertura', '$orarioChiusura')";
		} else {
			$sql = "INSERT INTO " . $tabella . " (mailfatt, giorno, orainizio, orafine) VALUES ('$mail', '$giorno', '$orarioApertura', '$orarioChiusura')";
		}
		
		if ($conn->query($sql) == FALSE) {
			echo "Error " . $sql . "<br>" . $conn->error;
			return FALSE;
		}
	}
	return TRUE;
}
	
?>