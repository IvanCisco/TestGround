<?php
include("../common/connessione.php");

session_start();
//var_dump($_POST);

if (isset($_POST['submitOrder'])) {
    // Assuming you have retrieved the necessary data from the form
    $metodoPagamento = $_POST['metodoPagamento'];
if (isset($_POST['selectedPlates'])) {
    // Assuming database connection and other configurations are set up

    // Retrieve selected plates from the form
    //$selected_plates = $_POST['selectedPlates'];
    //    $selected_plates = $_POST['selectedPlates'];
    $selected_Plates = json_decode($_POST['selectedPlates'], true);
}

    
    if (isset($_SESSION['utente'])) {
    $mailacq = $_SESSION['utente'];
    } // Fetch the user's email; replace this with your logic to get the email
    $data = date("Y-m-d"); // Current date in 'YYYY-MM-DD' format
    $ora = date("H:i:s"); // Current time in 'HH:MM:SS' format
    $stato = "in preparazione"; // Set default status

    // Insert into 'ordine' table
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
    $queryContiene = "INSERT INTO contiene (nome, mail, data, ora) VALUES (?, ?, ?, ?)";
    $stmtContiene = $conn->prepare($queryContiene);
    

    if (is_array($selected_Plates)) {
     foreach ($selected_Plates as $selectedPlate) {
        
        // Split the combined values using the pipe separator
        $plateValues = explode('|', $selectedPlate);

        // Check if the array has both values (nome and prezzo)
        //if (count($plateValues) == 2) {
         //list($nome, $prezzo) = $plateValues;
         //echo $nome;
         //echo $prezzo;
         
         // Check if the array has both values (nome and prezzo)
    if (isset($plateValues[1])) {
        list($nome, $prezzo) = $plateValues;
            // Fetch the restaurant's email using the $nome value
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
            // Now you have $nome and $prezzo separately for each selected plate
            // Insert into 'contiene' table
            $stmtContiene->bind_param("ssss", $nome, $mailRistorante, $data, $ora);
            $stmtContiene->execute();
    //echo "Data inserted into contiene successfully.";
        }else{
            echo "Error: Restaurant email not found for plate $nome.";
        }
    }
    /*
    if (!$stmtContiene->execute()) {
    echo "Error: " . $stmtContiene->error;
    */
}
}
    




        
    // Close the statements
    $stmtOrdine->close();
    $stmtContiene->close();



echo "Ordine eseguito con successo. Verrai reindirizzato alla lista di ristoranti";
header("refresh:5;url=../frontend/acquirente.php");
        
        exit();
    // Redirect to Acquirente.php after order placement
    //header("Location: Acquirente.php");
    
    /*
} else {
    // Redirect to a different page or display an error message if the form was not submitted
   // header("Location: error_page.php");
    echo "sono qui";
    exit();
    */
}


} else {
    echo "Error processing selectedPlates.";
}
session_destroy()

?>
