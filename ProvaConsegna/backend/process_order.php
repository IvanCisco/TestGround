<?php
include("../common/connessione.php");

session_start();
//var_dump($_POST);

if (isset($_POST['submitOrder'])) {
    
    $metodoPagamento = $_POST['metodoPagamento'];
if (isset($_POST['selectedPlates'])) {
    

    //recupero piatti
    $selected_Plates = json_decode($_POST['selectedPlates'], true);
}

    
    if (isset($_SESSION['utente'])) {
    $mailacq = $_SESSION['utente'];
    } // mail
    $data = date("Y-m-d"); // data corrente
    $ora = date("H:i:s"); // ora corrente
    $stato = "in preparazione"; // sato default

    // Insert in ordine
    //QUESTA è LA INSERT CHE FUNZIONA
    
    $queryOrdine = "INSERT INTO ordine (data, ora, stato, metodopagamento, mailacq) VALUES (?, ?, ?, ?, ?)";
    $stmtOrdine = $conn->prepare($queryOrdine);
    $stmtOrdine->bind_param("sssss", $data, $ora, $stato, $metodoPagamento, $mailacq);
    $stmtOrdine->execute();
    //FINE query ORDINE

    // Retrieve the auto-generated order ID
    //$orderId = $stmtOrdine->insert_id;

    // Insert into 'contiene' table for each selected item
    // QUESTA è LA INSERT CHE  NON FUNZIONA
    //inseri in contiene quindi lato ristorante
    $queryContiene = "INSERT INTO contiene (nome, mail, data, ora) VALUES (?, ?, ?, ?)";
    $stmtContiene = $conn->prepare($queryContiene);
    
    // se sono stati selezionati piatti
    if (is_array($selected_Plates)) {
     foreach ($selected_Plates as $selectedPlate) {
        
        // divido
        $plateValues = explode('|', $selectedPlate);

        // Check if the array has both values (nome and prezzo)
        //if (count($plateValues) == 2) {
         //list($nome, $prezzo) = $plateValues;
         //echo $nome;
         //echo $prezzo;
         
         // Check if the array has both values (nome and prezzo)
    if (isset($plateValues[1])) {
        list($nome, $prezzo) = $plateValues;
            // recupero la mail del ristorante
        $queryFetchMail = "SELECT mail FROM pietanza WHERE nome = ?";
        $stmtFetchMail = $conn->prepare($queryFetchMail);
        $stmtFetchMail->bind_param("s", $nome);
        $stmtFetchMail->execute();
        $resultFetchMail = $stmtFetchMail->get_result();

        if ($resultFetchMail && $resultFetchMail->num_rows > 0) {
            $rowFetchMail = $resultFetchMail->fetch_assoc();
            $mailRistorante = $rowFetchMail['mail'];

            // check mail 
            if (isset($mailRistorante)) {
            
            // Insert in contiene
            $stmtContiene->bind_param("ssss", $nome, $mailRistorante, $data, $ora);
            $stmtContiene->execute();
    //echo "Dati inseriti";
        }else{
            echo "Errore: Non è stato trovato alcun ristorante per questo piatto  $nome.";
        }
    }
    /*
    if (!$stmtContiene->execute()) {
    echo "Errore: " . $stmtContiene->error;
    */
}
}
    




        
    // chiudo connessione
    $stmtOrdine->close();
    $stmtContiene->close();



echo "Ordine eseguito con successo. Verrai reindirizzato alla lista di ristoranti";
header("refresh:5;url=../frontend/acquirente.php");
        
        exit();
    
    //header("Location: Acquirente.php");
    
    /*
} else {
    
   // header("Location: error_page.php");
    echo "sono qui";
    exit();
    */
}


} else {
    echo "Errore nell'array selectedPlates.";
}
session_destroy()

?>
