<!DOCTYPE html>
<html>
    <head>
    <script src="../js/javascript.js"></script>
    </head>
    <?php
    include("../common/connessione.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted data
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $descrizione = $_POST['descrizione'];

    // Delete query using the provided attributes
    $deleteQuery = "DELETE FROM pietanza WHERE nome = ? AND prezzo = ? AND descrizione = ?";
    //$deleteQuery = "DELETE FROM pietanza WHERE nome = '$nome' AND prezzo = '$prezzo' AND descrizione = '$descrizione'";
    
    // Prepare the statement
    $stmt = $conn->prepare($deleteQuery);
    
    if ($stmt) {
    // Bind parameters and execute
    $stmt->bind_param('sss',$nome, $prezzo, $descrizione);
    if ($stmt->execute()) {
        http_response_code(200);
        echo "Item deleted successfully";
      //
       // <script>
      //  redirectdelay(5000, 'acquirente.php');//delay di 5 secondi post avvenuta registrazione
    //	</script>
    } else {
        http_response_code(500);
        echo "Error deleting item: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    } else {
        http_response_code(500);
        echo "Error in query preparation: " . $conn->error;
    }
    $conn->close();
}
?>
</html>