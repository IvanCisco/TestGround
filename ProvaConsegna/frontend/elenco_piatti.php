<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <p><a href="acquirente.php">Torna indietro</a></p>
        <form action="../backend/inserisci_ordine_acquirente.php" method="POST">
<?php
    include("../common/connessione.php");
    session_start();
if (isset($_GET['nomeristorante'])) {
    $nomeristorante = $_GET['nomeristorante'];


    //echo $nomeristorante;
    //controll trovato online per non avere errori sulla connessione
    $stmt = $conn->prepare("SELECT mail FROM ristorante WHERE nome = ?");
	$stmt->bind_param("s", $nomeristorante); // Assuming $nomeristorante is a string
	$stmt->execute();
	$result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
    // Fetch the mail
    $row = $result->fetch_assoc();
    $mail = $row['mail'];

    $stmt = $conn->prepare("SELECT nome,prezzo,descrizione,tipo,immagine,elenco FROM pietanza WHERE mail = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    //stampo le pietanze di quel ristorante

        echo "<div class='menu-item'>";
        echo "<p>{$row['nome']} - {$row['prezzo']}- {$row['descrizione']} - {$row['tipo']} - {$row['elenco']}";
        echo "<img src='{$row['immagine']}' style='max-width: 150px; max-height: 150px; margin-left: auto; margin-right: auto;display: inline-block; vertical-align: middle;'>";
        echo "<input type='checkbox' name='selectedPlates[]' value='{$row['nome']}|{$row['prezzo']}'><br>";

}
?>
        <br>
        <br>    
        <input type="submit" value="Ordina">
<?php
}else {
    echo "Ristorante not found.";
}

        // Edit icon triggering the edit modal
        }
}
        ?>
    </form>
        </body>
</html>