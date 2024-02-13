<?php
$sql = "SELECT giorno, orainizio, orafine
        FROM  turno
        WHERE turno.id IN (
            SELECT turno
            FROM rlavorasu
            WHERE mail = '$mail');";
$risultato = $conn->query($sql);
if ($risultato->num_rows > 0) {
    while($row = $risultato->fetch_assoc()) {
        echo "<p class=\"" . $row['giorno'] . $row['orainizio'] . $row['orafine'] . "\">" . $row['giorno'] . "   " . $row['orainizio'] . " - " . $row['orafine'] . " ";
        echo "<img src='../immagini/delete-icon2.png' onclick=\"eliminaOrari('{$row['giorno']}','{$row['orainizio']}', '{$row['orafine']}', '{$mail}', 'rlavorasu')\"></img></p>";
    }
} else {
    echo "<p>Non ci sono orari da mostrare.</p>";
}
?>