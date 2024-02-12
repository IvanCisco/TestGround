<?php
$sql = "SELECT giorno, orainizio, orafine
        FROM  turno
        WHERE turno.id IN (
            SELECT turno
            FROM rlavorasu
            WHERE mailrist = '$mail');";
$risultato = $conn->query($sql);
if ($risultato->num_rows > 0) {
    while($row = $risultato->fetch_assoc()) {
        echo "<p>" . $row['giorno'] . "   " . $row['orainizio'] . " - " . $row['orafine'] . " ";
        echo "<img src='../immagini/delete-icon2.png' onclick=\"eliminaOrari('{$row['giorno']}','{$row['orainizio']}', '{$row['orafine']}', '{$mail}', 'ristorante')\"></img></p>";
    }
} else {
    echo "<p>Non ci sono orari da mostrare.</p>";
}
?>