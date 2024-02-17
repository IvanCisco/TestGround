<?php
include("../common/connessione.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dati = json_decode(file_get_contents("php://input"), TRUE);

    if ($dati !== null && isset($dati["maill"]) && isset($dati["nomee"]) && isset($dati["prezzoo"]) && isset($dati["descrizionee"]) && isset($dati["tipoo"]) && isset($dati["elencoo"])) {
        $mail = $dati["maill"];
        $nome = $dati["nomee"];
        $prezzo = number_format(floatval($dati["prezzoo"]), 2);
        $descrizione = $dati["descrizionee"];
        $tipo = $dati["tipoo"];
        $elenco = $dati["elencoo"];

        if ($tipo == "menu") {
            $sql = "DELETE FROM pietanza
                    WHERE mail = '$mail'
                    AND nome = '$nome'
                    AND prezzo = $prezzo
                    AND descrizione = '$descrizione'
                    AND tipo = '$tipo'
                    AND elenco = '$elenco'";
        } else {
            $sql = "DELETE FROM pietanza
                    WHERE mail = '$mail'
                    AND nome = '$nome'
                    AND prezzo = $prezzo
                    AND descrizione = '$descrizione'
                    AND tipo = '$tipo'";
        }
        if ($response = $conn->query($sql)) {
            $risposta = array("successo" => TRUE, "errore" => $response . " SQL: " . $sql);
            echo json_encode($risposta);
        } else {
            $risposta = array("successo" => FALSE, "errore" => "Connessione al database non riuscita. Query non eseguita.");
            echo json_encode($risposta);
        } 
    } else {
        $risposta = array("successo" => FALSE, "errore" => "Uno dei parametri non è stato impostato");
        echo json_encode($risposta);
    }
}
?>