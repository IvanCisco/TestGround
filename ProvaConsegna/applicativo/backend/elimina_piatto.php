<!DOCTYPE html>
<html>
    <head>
    <script src="../js/javascript.js"></script>
    </head>
    <?php
    include("../common/connessione.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // recupero dati
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $descrizione = $_POST['descrizione'];

    // query di delete con i dati che ho appena recuperato
    $deleteQuery = "DELETE FROM pietanza WHERE nome = ? AND prezzo = ? AND descrizione = ?";
    //$deleteQuery = "DELETE FROM pietanza WHERE nome = '$nome' AND prezzo = '$prezzo' AND descrizione = '$descrizione'";
    
    
    $stmt = $conn->prepare($deleteQuery);
    
    if ($stmt) {
    // paramentri 
    $stmt->bind_param('sss',$nome, $prezzo, $descrizione);
    //codici di risposta per eseguire l'azione
    if ($stmt->execute()) {
        http_response_code(200);
        echo "Piatto eliminato con successo";
      //
       // <script>
      //  redirectdelay(5000, 'acquirente.php');//delay di 5 secondi post avvenuta registrazione
    //	</script>
    } else {
        http_response_code(500);
        echo "Errore durante l'eliminazion: " . $conn->error;
    }

    // chiudo la connesione
    $stmt->close();
    } else {
        http_response_code(500);
        echo "Errore : " . $conn->error;
    }
    $conn->close();
}
?>
</html>