<?php
session_start();
include("../common/connessione.php");
include("../common/funzioni.php");

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mail = $_SESSION["utente"];

        $password = $_POST["password"];
        $nome = $_POST["nome"];
        $ragsoc = $_POST["ragsoc"];
        $partitaiva = $_POST["partitaiva"];
        $zona = $_POST["zona"];
        $via = $_POST["via"];
        $numero = $_POST["numero"];
        $cap = $_POST["cap"];
        $citta = $_POST["citta"];
        $viasl = $_POST["viasl"];
        $numerosl = $_POST["numerosl"];
        $capsl = $_POST["capsl"];
        $cittasl = $_POST["cittasl"];
        $giorni = isset($_POST["giorno"]) ? $_POST["giorno"] : array();
	    $orariInizio = isset($_POST["orainizio"]) ? $_POST["orainizio"] : array();
	    $orariFine = isset($_POST["orafine"]) ? $_POST["orafine"] : array();

        try {
            $conn->begin_Transaction();
            $sql1 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$via', '$numero', '$cap', '$citta')";
            $sql2 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$viasl', '$numerosl', '$capsl', '$cittasl');";
            $sql3 = "UPDATE ristorante
                    SET 
                        password = '$password',
                        nome = '$nome',
                        ragsoc = '$ragsoc',
                        partitaiva = '$partitaiva',
                        location = (SELECT indirizzo.id
                                                FROM indirizzo
                                                WHERE indirizzo.via = '$via'
                                                AND indirizzo.numero = '$numero'
                                                AND indirizzo.cap = '$cap'
                                                AND indirizzo.citta = '$citta'),
                        sedelegale = (SELECT sedelegale.id
                                                FROM indirizzo AS sedelegale
                                                WHERE sedelegale.via = '$viasl'
                                                AND sedelegale.numero = '$numerosl'
                                                AND sedelegale.cap = '$capsl'
                                                AND sedelegale.citta = '$cittasl')
                        WHERE mail = '$mail';";
            $conn->query($sql1);
            $conn->query($sql2);
            $conn->query($sql3);
            inserisciOrari($giorni, $orariInizio, $orariFine, $mail, $conn, "rlavorasu");
            $conn->commit();
            header("Location: ../frontend/profilo_ristorante.php");           
        } catch (\Throwable $e) {
            $conn->rollback();
        }
    }
}