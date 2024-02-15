<?php

include("../common/connessione.php");

$nomeErr = $cognomeErr = $sessoErr = $datanascitaErr = $mailErr = $passwordErr = $luogonascitaErr = $alreadyErr = "";
$nome = $cognome = $sesso = $datanascita = $mail = $password = $luogonascita = $zona = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nome"]) and !isset($_POST["nome"])) {
        $nomeErr = "Inserisci un nome";
    } else {
        $nome = test_input($_POST["nome"]);
        if (!preg_match("/^[a-zA-Z]-' ]*$/", $nome)) {
            $nomeErr = "Sono ammesse solo lettere e spazi";
        }
    }

    if (empty($_POST["cognome"]) and !isset($_POST["cognome"])) {
        $cognomeErr = "Inserisci un cognome";
    } else {
        $cognome = test_input($_POST["cognome"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $cognome)) {
            $cognomeErr = "Sono ammesse solo lettere e spazi";
        }
    }

    if (empty($_POST["sesso"])) {
        $sessoErr = "Seleziona un sesso";
    } else {
        $sesso = test_input($_POST["sesso"]);
    }

    $dataNascita = $_POST["datanascita"];

    if (empty($_POST["mail"])) {
        $mailErr = "Inserisci una e-mail";
    } else {
        $mail = test_input($_POST["mail"]);
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mailErr = "Formato e-mail non valido";
        } else {
            $mail = $_POST["mail"];
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Inserisci una password";
    } else {
        $password = $_POST['password'];
    }

    $luogoNascita = $_POST["luogonascita"];
    $citta = $_POST["citta"];
    $zone = $_POST["zone"];

    //Controllo se esiste già un account associato alla mail fornita
    $controllo_mail = "SELECT * FROM fattorino WHERE mail = '$mail'";
    $result = $conn->query($controllo_mail);


    if ($result->num_rows > 0) {
        $alreadyErr = "Questa email è già associata a un account!";
    } else {
        $sql1 = "INSERT INTO fattorino (nome, cognome, mail, password, sesso, datanascita, luogonascita, citta)
                    VALUES ('$nome', '$cognome', '$mail', '$password', '$sesso', '$dataNascita', '$luogoNascita', '$citta')";
        if ($conn->query($sql1) == TRUE and zonaInsert($zone, $mail, $conn, "operainfatt")) {
            header("Location: ../login.php?status=fattsignupsuccess");
        } else {
            echo "Error " . $sql1 . "<br>" . $conn->error;
        }
        $conn->close();
    }
}

function test_input($data) {
    if (!strpos($data, "Via") or !strpos($data, "Piazza")) {
        $data = trim($data);
    }
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>