<?php

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
			$sql = "INSERT INTO rlavorasu (mailrist, turno)
					SELECT '$mail', id
					FROM turno
					WHERE giorno = '$giorno'
					AND orainizio = '$orarioApertura'
					AND orafine = '$orarioChiusura'";
		} else {
			$sql = "INSERT INTO flavorasu (mailfatt, turno)
					SELECT '$mail', id
					FROM turno
					WHERE giorno = '$giorno'
					AND orainizio = '$orarioApertura'
					AND orafine = '$orarioChiusura'";
		}
		
		if ($conn->query($sql) == FALSE || inserisciInTurno($giorno, $orarioApertura, $orarioChiusura, $conn) == FALSE) {
			echo "Error " . $sql . "<br>" . $conn->error;
			return FALSE;
		}
	}
	return TRUE;
}

function inserisciInTurno($giorno, $orarioApertura, $orarioChiusura, $conn) {
	$sql = "INSERT IGNORE INTO turno (giorno, orainizio, orafine) VALUES ('$giorno', '$orarioApertura', '$orarioChiusura');";
	if ($conn->query($sql) == FALSE) {
		echo "Error " . $sql . "<br>" . $conn->error;
		return FALSE;
	}
	return TRUE;
}
	
?>