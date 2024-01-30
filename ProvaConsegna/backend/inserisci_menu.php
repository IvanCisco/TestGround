<!DOCTYPE html>
<head>
    <script src="../js/javascript.js"></script><!--collego filejs -->
</head>
<?php
// inserisci_menu.php

session_start();
if (!isset($_SESSION['utente'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset($_POST['nome']) && isset($_POST['descrizione']) && isset($_POST['prezzo']) && isset($_POST['selectedPlates'])) {
        // Retrieve form data
        $nome_menu = $_POST['nome'];
        $descrizione_menu = $_POST['descrizione'];
        $prezzo_menu = $_POST['prezzo'];
        $selected_plates = $_POST['selectedPlates'];

        // Get the logged-in user's email
        $mail = $_SESSION['utente'];

        // Database connection and INSERT query
        include("../common/connessione.php"); // Ensure this path is correct

        // Construct the elenco (list of plates) from the selected checkboxes
        $elenco = implode(", ", $selected_plates);

        // Prepare and execute the INSERT query
        //$stmt = $conn->prepare("INSERT INTO pietanza (nome,descrizione,prezzo, tipo, mail, elenco) VALUES ('$nome_menu','$descrizione_menu','$prezzo_menu', 'Menu', '$mail', '$elenco')");
        $tipo_menu = "Menu"; // Adjust the type as needed

        $stmt = $conn->prepare("INSERT INTO pietanza (nome, descrizione, prezzo, tipo, mail, elenco) VALUES (?, ?, ?, ?, ?, ?)");
        // Bind parameters and execute query
        //$stmt->bind_param("sssss", $nome_menu, $descrizione_menu, $prezzo_menu, $mail, $elenco);
        $stmt->bind_param("ssdsss", $nome_menu, $descrizione_menu, $prezzo_menu, $tipo_menu, $mail, $elenco);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            echo "inserimento avvenuto con successo, verrai reindirizzato alla pagina con il tuo menu";
    ?>
    <script>
        redirectdelay(5000, '../frontend/ristorante.php');//delay di 5 secondi post avvenuta registrazione
    </script>
    <?php
        } else {
            echo "Error inserting menu. Please try again.";
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle case where form fields are missing
        echo "Please fill in all the required fields.";
    }
} else {
    // Redirect if accessed directly without form submission
    header("Location: index.php");
    exit();
}
?>
</html>
