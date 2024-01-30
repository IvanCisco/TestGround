<!DOCTYPE html>
<head>
    <script src="../js/javascript.js"></script><!--collego filejs -->
</head>

<?php
include("../common/connessione.php");


$nome = $_POST['nome'];
$prezzo = $_POST['prezzo'];
$descrizione = $_POST['descrizione'];
$file_name = $_FILES['fileToUpload']['name'];
$tmp_name = $_FILES['fileToUpload']['tmp_name'];

session_start();
$mail =$_SESSION['utente'];
$mailmod = str_replace(['@', '.'], '', $mail);

$file_extension = pathinfo($file_name, PATHINFO_EXTENSION); 
$new_file_name = $mailmod . '_' . $nome . '.' . $file_extension; // Nome file
$file_destination = '../immagini/' . $new_file_name; // Cartella di destinazione
    



// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $descrizione = $_POST['descrizione'];
    
    // File upload
    if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['fileToUpload']['name'];
        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
        //$destination = 'immagini/' . $file_name; // Destination directory
        $destination = '../immagini/' . $new_file_name;



        // Move uploaded file
        if (move_uploaded_file($tmp_name, $destination)) {
            // Insert plate details into the database
            $sql = "INSERT INTO pietanza (nome, prezzo, descrizione, tipo, mail, immagine)
                    VALUES ('$nome', '$prezzo', '$descrizione', 'piatto', '$mail', '$destination')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Inserimento avvenuto con successo, verrai reindirizzato alla pagina con il tuo menu";
                // Redirect after successful insertion
                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = '../frontend/ristorante.php';
                    }, 5000); // Redirect after 5 seconds
                </script>
                <?php
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Errore durante il caricamento del file.";
        }
    } else {
        echo "Errore durante il caricamento del file.";
    }
}


$conn->close();
?>