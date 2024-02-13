<?php
include("../common/connessione.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dati = json_decode(file_get_contents("php://input"), TRUE);
    
    if (isset($dati["g"]) && isset($dati["inizio"]) && isset($dati["fine"]) && isset($dati["email"]) && isset($dati["tab"])) {
        $giorno = $dati["g"];
        $orainizio = $dati["inizio"];
        $orafine = $dati["fine"];
        $mail = $dati["email"];
        $tabella = $dati["tab"];

        $sql = "DELETE FROM $tabella 
                WHERE mail = '$mail'
                AND turno = (
                    SELECT id
                    FROM turno
                    WHERE giorno = '$giorno'
                    AND orainizio = '$orainizio'
                    AND orafine = '$orafine');";
        if ($conn->query($sql)) {
            $risposta = array("successo" => TRUE);
            echo json_encode($risposta);
        } else {
            $risposta = array("successo" => FALSE, "errore" => "Esecuzione della query non riuscita.");
            echo json_encode($risposta);
        }
    } else {
        $risposta = array("successo" => FALSE, "errore" => "Uno dei parametri non è stato impostato.");
    }
    $conn->close();
}