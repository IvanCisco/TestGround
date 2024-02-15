<?php
session_start();
include("../common/connessione.php");
include("../common/funzioni.php");

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mail = $_SESSION["utente"];

        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $password = $_POST["password"];
        $sesso = $_POST["sesso"];
        $datanascita = $_POST["datanascita"];
        $luogonascita = $_POST["luogonascita"];
        $citta = $_POST["citta"];
        $disponibilita = $_POST["disponibilita"];
        $zone = $_POST["zone"];
        $giorni = isset($_POST["giorno"]) ? $_POST["giorno"] : array();
	    $orariInizio = isset($_POST["orainizio"]) ? $_POST["orainizio"] : array();
	    $orariFine = isset($_POST["orafine"]) ? $_POST["orafine"] : array();

        try {
            $conn->begin_Transaction();
            $sql1  = "UPDATE fattorino
                    SET password = '$password',
                        nome = '$nome',
                        cognome = '$cognome',
                        sesso = '$sesso',
                        datanascita = '$datanascita',
                        luogonascita = '$luogonascita',
                        citta = '$citta',
                        disponibilita = '$disponibilita'
                    WHERE mail = '$mail';";
            zonaInsert($zone, $mail, $conn, "operainfatt");
            inserisciOrari($giorni, $orariInizio, $orariFine, $mail, $conn, "flavorasu");
            $conn->query($sql1);
            $conn->commit();
            header("Location: ../frontend/profilo_fattorino.php");
        } catch (\Throwable $e) {
            echo "C'è stato un cazzo di errore bro.";
            echo "Questo è il contenuto di zone: " . count($zone);
            var_dump(zonaInsert($zone, $mail, $conn, "operainfatt"));
            $conn->rollback();
        }
    }
}