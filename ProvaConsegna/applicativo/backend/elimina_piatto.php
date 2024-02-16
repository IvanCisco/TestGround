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
            /*echo "Piatto eliminato con successo";*/
		    $risposta = array("successo"=>TRUE);
		    echo json_encode($risposta);
        } else {
            http_response_code(500);
            echo "Errore durante l'eliminazion: " . $conn->error;
		    $risposta = array("successo" => FALSE, "errore" => "Esecuzione della query non riuscita o parametri mal settati.");
            echo json_encode($risposta);
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