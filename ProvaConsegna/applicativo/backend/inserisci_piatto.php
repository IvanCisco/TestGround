<?php
include("../common/connessione.php");
session_start();

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    $errore = "";
    $nome = "";
    $prezzo = "";
    $descrizione = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mail =$_SESSION['utente'];
        $nome = $_POST['nome'];
        $prezzo = $_POST['prezzo'];
        $descrizione = $_POST['descrizione'];
        $file_name = $_FILES['fileToUpload']['name'];
        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
        $mailmod = str_replace(['@', '.'], '', $mail);
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); 
        $new_file_name = $mailmod . '_' . $nome . '.' . $file_extension; // Nome file
        $file_destination = '../immagini/' . $new_file_name; // Cartella di destinazione
        
    
        // upload file come indicato su ariel
        if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['fileToUpload']['name'];
            $tmp_name = $_FILES['fileToUpload']['tmp_name'];
            //$destination = 'immagini/' . $file_name; // Destination directory
            $destination = '../immagini/' . $new_file_name;
            // sposto nella cartella il file
            if (move_uploaded_file($tmp_name, $destination)) {
                // Insert nel database
                $sql = "INSERT INTO pietanza (nome, prezzo, descrizione, tipo, mail, immagine)
                        VALUES ('$nome', '$prezzo', '$descrizione', 'piatto', '$mail', '$destination')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: ../frontend/ristorante.php");                
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $errore = "Errore durante il caricamento del piatto.";
            }
        } else {
            $errore = "Errore durante il caricamento del file, non è stata selezionata alcuna immagine.";
        }
    }
}
$conn->close();
?>