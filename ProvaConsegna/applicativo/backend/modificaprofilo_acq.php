<?php
session_start();

include("../common/connessione.php");

if (!isset($_SESSION["utente"])) {
	header("Location: ../index.html");
} else {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mail = $_SESSION["utente"];

        $password = $_POST["password"];
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
		$telefono = $_POST["telefono"];
		$istruzioni = $_POST["istruzioni"];
        $via = $_POST["via"];
        $numero = $_POST["numero"];
        $cap = $_POST["cap"];
        $citta = $_POST["citta"];

		try {
            $conn->begin_Transaction();
            $sql1 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$via', '$numero', '$cap', '$citta')";
			$sql2 = "UPDATE acquirente
					SET 
						nome = '$nome',
						cognome = '$cognome',
						password = '$password',
						telefono = '$telefono',
						istruzioni = '$istruzioni',
						domicilio = (SELECT indirizzo.id
                                                FROM indirizzo
                                                WHERE indirizzo.via = '$via'
                                                AND indirizzo.numero = '$numero'
                                                AND indirizzo.cap = '$cap'
                                                AND indirizzo.citta = '$citta')
						WHERE mail = '$mail'";
			$conn-query($sql1);
			$conn-query($sql2);
			$conn->commit();
            header("Location: ../frontend/profilo_acquirente.php");           
        } catch (\Throwable $e) {
            $conn->rollback();
			echo "<p class\"error\">Errore nel passaggio dei parametri</p>";
			echo $sql1 . "<br>" . $conn->error . "Inizia qui";
			echo $sql2 . "<br>" . $conn->error;
        }
    }
}