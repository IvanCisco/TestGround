<?php
$sql = "SELECT giorno, orainizio, orafine
        FROM  turno
        WHERE id IN (
            SELECT turno
            FROM $tabella
            WHERE mail = '$mail');";
$risultato = $conn->query($sql);
if ($risultato->num_rows > 0) {
    while($row = $risultato->fetch_assoc()) {
        echo "<p id=\"" . $row['giorno'] . $row['orainizio'] . $row['orafine'] . "\">" . $row['giorno'] . "   " . $row['orainizio'] . " - " . $row['orafine'] . " ";
        echo "<img src='../immagini/delete-icon2.png' onclick=\"eliminaOrari('{$row['giorno']}','{$row['orainizio']}', '{$row['orafine']}', '{$mail}', '{$tabella}')\"></img></p>";
    }
} else {
    echo "<p class=\"error\">Non ci sono orari da mostrare.</p>";
}
?>