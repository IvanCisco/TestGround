<?php

$mailErr = $passwordErr = $loginErr = "";
$mail = $password = $utente = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $passwordErr = "Inserisci la password";
    } else {
        $password = $_POST["password"];
    }

    $utente = isset($_POST["utente"]) ? $_POST["utente"] : "";

    $controllo = "SELECT * FROM " . $utente . " WHERE mail='$mail' AND password='$password'";
    $result = $conn->query($controllo);

    if ($result->num_rows > 0) {
        $_SESSION["utente"] = $mail;
        $_SESSION["tipo"] = $utente;
        $_SESSION["logged"] = TRUE;
        header("Location: frontend/" . $utente . ".php");
        //header("Location: http://localhost/ProvaConsegnaCopia/frontend/" . $utente . ".php");
    } else {
        $loginErr = "E-mail o password sbagliati";
    }
    $conn->close();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>