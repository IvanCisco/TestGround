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
		$sql = "INSERT INTO $tabella (mail, turno)
				SELECT '$mail', id
				FROM turno
				WHERE giorno = '$giorno'
				AND orainizio = '$orarioApertura'
				AND orafine = '$orarioChiusura'";
		
		if (inserisciInTurno($giorno, $orarioApertura, $orarioChiusura, $conn) == FALSE || $conn->query($sql) == FALSE) {
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

function zonaInsert($zone, $mail, $conn, $tabella) {
    // Zone in cui il fattorino opera già
    $zoneEsistenti = array();
    $sql = "SELECT zona FROM $tabella WHERE mail = '$mail'";
    $risultato = $conn->query($sql);
    if ($risultato->num_rows > 0) {
        while ($row = $risultato->fetch_assoc()) {
            $zoneEsistenti[] = $row['zona'];
        }
    }

    foreach ($zoneEsistenti as $zonaEsistente) {
        // Controlla se le zone di operatività dopo la modifica sono le stesse
        $isSelected = in_array($zonaEsistente, $zone);
       
        if (!$isSelected) {
            // La zona non è più selezionata dopo la modifica. Elimina il relativo record.
            $sql = "DELETE FROM $tabella WHERE mail = '$mail' AND zona = '$zonaEsistente'";
            if ($conn->query($sql) === FALSE) {
                return FALSE;
            }
        }
    }
   
    foreach ($zone as $nuovaZona) {
        // Controlla se questa zona deve essere inserita tra quelle di operatività
        if (!in_array($nuovaZona, $zoneEsistenti)) {
            // È una nuova zona selezionata. Inserisci il record.
            $sql = "INSERT INTO $tabella (mail, zona) VALUES ('$mail', '$nuovaZona')";
            if ($conn->query($sql) === FALSE) {
                return FALSE;
            }
        }
    }
   
    return TRUE;
}
?>