<?php
$mail = $_SESSION["utente"];
$sql = "SELECT *
        FROM pietanza
        WHERE mail = '$mail';";
$risultato = $conn->query($sql);
if ($risultato->num_rows > 0) {
    while($row = $risultato->fetch_assoc()) {
        $id = str_replace([".", "@"], "", $mail) . str_replace(" ", "", $row["nome"]) . str_replace(".", "", $row["prezzo"]) . $row["tipo"];
        echo "<p class=\"menu-item\" id=\"$id\">" . $row["nome"] . " - " . $row["prezzo"] . " - " . $row["descrizione"] . " - " . $row["tipo"] . " - " . $row["elenco"];
        echo "<img src='{$row['immagine']}' style='max-width: 150px; max-height: 150px; margin-left: auto; margin-right: auto;display: inline-block; vertical-align: middle;'>";
        echo "<img src='../immagini/delete-icon2.png' onclick=\"eliminaPiatto('$mail','$id','{$row['nome']}','{$row['prezzo']}','{$row['descrizione']}','{$row['tipo']}','{$row['elenco']}')\"></img></p>";
    }
} else {
    echo "<p class=\"error\">Non hai pietanze per il tuo ristorante al momento!</p>";
}
$conn->close();
?>