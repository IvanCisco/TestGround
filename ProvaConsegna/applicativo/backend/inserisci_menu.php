<!DOCTYPE html>
<head>
    <script src="../js/javascript.js"></script><!--collego filejs -->
</head>
<?php
// inserisci_menu.php

session_start();
if (!isset($_SESSION['utente'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // controllo non siano vuoti
    if (isset($_POST['nome']) && isset($_POST['descrizione']) && isset($_POST['prezzo']) && isset($_POST['selectedPlates'])) {
        // recupero dati dai form
        $nome_menu = $_POST['nome'];
        $descrizione_menu = $_POST['descrizione'];
        $prezzo_menu = $_POST['prezzo'];
        $selected_plates = $_POST['selectedPlates'];

        // recupero mail
        $mail = $_SESSION['utente'];

        // connessione database
        include("../common/connessione.php"); 

        // tutti i piatti selezionati vengono separati da virgola in elenco 
        $elenco = implode(", ", $selected_plates);

        // Prepare and execute the INSERT query
        //$stmt = $conn->prepare("INSERT INTO pietanza (nome,descrizione,prezzo, tipo, mail, elenco) VALUES ('$nome_menu','$descrizione_menu','$prezzo_menu', 'Menu', '$mail', '$elenco')");
        $tipo_menu = "Menu"; 

        $stmt = $conn->prepare("INSERT INTO pietanza (nome, descrizione, prezzo, tipo, mail, elenco) VALUES (?, ?, ?, ?, ?, ?)");
        
        //$stmt->bind_param("sssss", $nome_menu, $descrizione_menu, $prezzo_menu, $mail, $elenco);
        //s indica stringa mentre d indica numero a virgola mobile 
        $stmt->bind_param("ssdsss", $nome_menu, $descrizione_menu, $prezzo_menu, $tipo_menu, $mail, $elenco);
        $stmt->execute();

        // controllo inserimento
        if ($stmt->affected_rows > 0) {
            echo "inserimento avvenuto con successo, verrai reindirizzato alla pagina con il tuo menu";
    ?>
    <script>
        redirectdelay(5000, '../frontend/ristorante.php');//delay di 5 secondi post avvenuta registrazione
    </script>
    <?php
        } else {
            echo "Error durante l'inserimento del menu, riprova.";
        }

        // chiudo stmt e connessione
        $stmt->close();
        $conn->close();
    } else {
        // gestione se non ha inserito tutti i campi
        echo "Assicurarsi di aver compilato tutti i campi";
    }
} else {
    // reindirizzo
    header("Location: ../index.html");
    exit();
}
?>
</html>
