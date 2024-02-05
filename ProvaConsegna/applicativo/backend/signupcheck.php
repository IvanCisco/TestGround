<?php

$nomeErr = $cognomeErr = $mailErr = $passwordErr = $telefonoErr = $viaErr = $numeroErr = $capErr = $alreadyErr = "";
$nome = $cognome = $mail = $password = $telefono = $via = $numero = $cap = $citta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["nome"])) {
        $nomeErr = "Inserisci un nome";
    } else {
        $nome = test_input($_POST["nome"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
            $nomeErr = "Sono ammesse solo lettere e spazi";
        }
    }

    if (empty($_POST["cognome"])) {
        $cognomeErr = "Inserisci un cognome";
    } else {
        $cognome = test_input($_POST["cognome"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $cognome)) {
            $cognomeErr = "Sono ammesse solo lettere e spazi";
        }
    }

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

    if (empty($_POST["telefono"])) {
        $telefonoErr = "Inserisci un numero di telefono";
    } else {
        $telefono = test_input($_POST["telefono"]);
        if (!filter_var($telefono, FILTER_VALIDATE_INT)) {
            $telefonoErr = "Sono ammessi solo numeri";
        }
    }

    if (empty($_POST["via"])) {
        $viaErr = "Inserisci una via";
    } else {
        $via = test_input($_POST["via"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $via)) {
            $viaErr = "Sono ammesse solo lettere e spazi";
        }
    }

    if (empty($_POST["numero"])) {
        $numeroErr = "Inserisci un numero civico";
    } else {
        $numero = test_input($_POST["numero"]);
        if (!filter_var($numero, FILTER_VALIDATE_INT)) {
            $numeroErr = "Sono ammessi solo numeri";
        }
    }

    if (empty($_POST["cap"])) {
        $capErr = "Inserisci un cap";
    } else {
        $cap = test_input($_POST["cap"]);
        if (!filter_var($cap, FILTER_VALIDATE_INT)) {
            $capErr = "Sono ammessi solo numeri";
        }
    }

    $datareg = date("Y-m-d");
    $citta = $_POST["citta"];

    /*Controllo se esiste già un'account associato alla mail fornita*/
    $controllo_mail = "SELECT * FROM acquirente WHERE mail = '$mail'";
    $result = $conn->query($controllo_mail);

    if ($result->num_rows > 0) {
        $alreadyErr = "Questa email è già associata a un account!";
    } else {
        $sql2 = "INSERT INTO acquirente (nome, cognome, mail, password, telefono, datareg, domicilio)
            SELECT '$nome', '$cognome', '$mail', '$password', '$telefono', '$datareg', id
            FROM indirizzo
            WHERE via = '$via'
            AND numero ='$numero'
            AND cap = '$cap'
            AND citta = '$citta'";
        $sql1 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$via', '$numero', '$cap', '$citta')";

        if ($conn->query($sql1) == TRUE and $conn->query($sql2) == TRUE) {
            header("Location: ../login.php");
        } else {
            echo "Error ". $sql . "<br>" . $conn->error;
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