<?php

include("../common/connessione.php");
include("../common/funzioni.php");

$nome = $partitaiva = $ragsoc = $mail = $password = $via = $numero = $cap = $citta = $zona = $viasl = $numerosl = $capsl = $cittasl = "";
$giorni = $orariApertura = $orariChiusura = array();
$alreadyErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
    $partitaiva = isset($_POST["partitaiva"]) ? $_POST["partitaiva"] : "";
    $ragsoc = isset($_POST["ragsoc"]) ? $_POST["ragsoc"] : "";
    $mail = isset($_POST["mail"]) ? $_POST["mail"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $via = isset($_POST["via"]) ? $_POST["via"] : "";
    $numero = isset($_POST["numero"]) ? $_POST["numero"] : "";
    $cap = isset($_POST["cap"]) ? $_POST["cap"] : "";
    $citta = isset($_POST["citta"]) ? $_POST["citta"] : "";
    $zona = isset($_POST["zona"]) ? $_POST["zona"] : "";

    $giorni = isset($_POST["giorno"]) ? $_POST["giorno"] : array();
    $orariApertura = isset($_POST["orainizio"]) ? $_POST["orainizio"] : array();
    $orariChiusura = isset($_POST["orafine"]) ? $_POST["orafine"] : array();

    $viasl = isset($_POST["viasl"]) ? $_POST["viasl"] : "";
    $numerosl = isset($_POST["numerosl"]) ? $_POST["numerosl"] : "";
    $capsl = isset($_POST["capsl"]) ? $_POST["capsl"] : "";
    $cittasl = isset($_POST["cittasl"]) ? $_POST["cittasl"] : "";
    if (mailExists($mail, $conn, "ristorante")) {
        $alreadyErr = "Questa mail è già associata a un account! Inserisci una email diversa o effettua il login.";
    } else {
        $sql1 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$via', '$numero', '$cap', '$citta');";
        $sql2 = "INSERT IGNORE INTO indirizzo (via, numero, cap, citta) VALUES ('$viasl', '$numerosl', '$capsl', '$cittasl');";
        $sql4 = "INSERT INTO operainrist (mailrist, zona) VALUES ('$mail', '$zona')";
        $sql3 = "INSERT INTO ristorante (mail, password, partitaiva, nome, ragsoc, location, sedelegale)
                SELECT '$mail', '$password', '$partitaiva', '$nome', '$ragsoc', 
                    (SELECT id
                    FROM indirizzo
                    WHERE via = '$via'
                    AND numero = '$numero'
                    AND cap = '$cap'
                    AND citta = '$citta'
                    ) AS location,
                    (SELECT id
                    FROM indirizzo
                    WHERE via = '$viasl'
                    AND numero = '$numerosl'
                    AND cap = '$capsl'
                    AND citta = '$cittasl'
                    ) AS sedelegale;";
        if ($conn->query($sql1) == TRUE and $conn->query($sql2) == TRUE and $conn->query($sql3) == TRUE and $conn->query($sql4) == TRUE and inserisciOrari($giorni, $orariApertura, $orariChiusura, $mail, $conn, "rlavorasu")) {
            //unset($_SESSION['giorno']);
            //unset($_SESSION['orainizio']);
            //unset($_SESSION['orafine']);
            header("Location: ../login.php?status=ristosignupsuccess");
        } else {
            echo "Error " . $sql1 . "<br>" . $conn->error;
            echo "Error " . $sql2 . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>